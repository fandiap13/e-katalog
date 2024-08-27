<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use App\Models\Warna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "List Produk";

        $search = false;

        $nama = $request->get('nama') ? strtolower($request->get('nama')) : "";
        $keterangan = $request->get('keterangan') ? strtolower($request->get('keterangan')) : "";
        $harga = $request->get('harga') ? strtolower($request->get('harga')) : "";
        $brand_id = $request->get('brand_id') ? strtolower($request->get('brand_id')) : "";
        $kategori_id = $request->get('kategori_id') ? strtolower($request->get('kategori_id')) : "";

        $brand = Brand::all();
        $kategori = Kategori::all();

        $query = Produk::select("produk.*");
        $query->join('kategori', 'kategori.id', '=', 'produk.kategori_id');
        $query->leftJoin('brand', 'brand.id', '=', 'produk.brand_id');

        if ($nama != "") {
            $search = true;
            $query->whereRaw('LOWER(produk.nama) LIKE ?', ['%' . $nama . '%']);
        }

        if ($keterangan != "") {
            $search = true;
            $query->whereRaw('LOWER(produk.keterangan) LIKE ?', ['%' . $keterangan . '%']);
        }

        if ($harga != "") {
            $search = true;
            $query->whereRaw('LOWER(produk.harga) LIKE ?', ['%' . $harga . '%']);
        }

        // pencarian brand
        // if ($brand_id != "") {
        //     $search = true;
        //     $query->where('produk.brand_id', $brand_id);
        // }

        // pencarian kategori
        if ($kategori_id != "") {
            $search = true;
            $query->where('produk.kategori_id', $kategori_id);
        }

        $query->orderBy("id", "DESC");
        $data = $query->paginate(10)->appends([
            'nama' => $nama,
            'keterangan' => $keterangan,
            'harga' => $harga,
            // 'brand_id' => $brand_id,
            'kategori_id' => $kategori_id,
        ]);

        $validatedData = [
            'nama' => $nama,
            // 'brand_id' => $brand_id,
            'kategori_id' => $kategori_id,
            'keterangan' => $keterangan,
            'harga' => $harga,
        ];

        // Preprocessing teks (Cleaning, Case Folding, Tokenisasi, Lemmatization, Stopword Removal)
        $inputText = implode(' ', $validatedData);
        $preprocessedInput = $this->preprocessText($inputText);

        // Dapatkan data produk sepeda
        $products = $data;
        $documentVectors = $products->map(function ($product) use ($preprocessedInput) {
            $productText = implode(' ', [
                $product->nama,
                $product->harga,
                $product->keterangan,
                $product->kategori_id,
                // $product->brand_id,
            ]);
            $preprocessedProductText = $this->preprocessText($productText);

            // Hitung TF-IDF dan Cosine Similarity
            $tfidfProduct = $this->calculateTFIDF($preprocessedProductText, $preprocessedInput);
            $tfidfInput = $this->calculateTFIDF($preprocessedInput, $preprocessedInput);
            $similarity = $this->cosineSimilarity($tfidfProduct, $tfidfInput);

            $product->similarity = $similarity * 100; // Convert to percentage

            return $product;
        });

        // Urutkan berdasarkan similarity secara descending
        $recommendedProducts = $documentVectors->sortByDesc('similarity');

        // echo "<pre>";
        // foreach ($products as $key => $value) {
        //     print_r($value);
        // }
        // echo "</pre>";
        // return;

        return view('admin.produk.index', compact('data', 'title', 'brand_id', 'kategori_id', 'brand', 'kategori', 'nama', 'keterangan', 'harga', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Produk";
        $brand = Brand::all();
        $kategori = Kategori::where("parent_id", null)->get();

        return view('admin.produk.create', compact('title', 'brand', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            // 'brand_id' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            // 'brand_id' => $request->brand_id,
            'keterangan' => $request->keterangan,
            'kategori_id' => $request->kategori,
        ]);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dibuat.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Produk";
        $produk = Produk::findOrFail($id);
        $brand = Brand::all();
        $kategori = Kategori::where("parent_id", null)->get();

        return view('admin.produk.edit', compact('produk', 'title', 'brand', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'brand_id' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $produk = Produk::findOrFail($id);

        $produk->nama = $request->nama;
        $produk->harga = $request->harga;
        $produk->brand_id = $request->brand_id;
        $produk->keterangan = $request->keterangan;
        $produk->kategori_id = $request->kategori;
        $produk->save();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json([
                    'status'   => false,
                    'message'  =>  'Produk tidak ditemukan'
                ], 400);
            }

            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }

            if ($produk->gambar_2 && file_exists(public_path($produk->gambar_2))) {
                unlink(public_path($produk->gambar_2));
            }

            if ($produk->gambar_3 && file_exists(public_path($produk->gambar_3))) {
                unlink(public_path($produk->gambar_3));
            }

            $produk->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status'   => false,
                'message'  =>  'Tidak dapat mengahapus data, data produk sudah berhubungan dengan data lain'
            ], 400);
        }
        return response()->json([
            'status'     => true,
            'message' => 'Success delete produk'
        ], 200);
    }

    public function uploadgambar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'     => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $produk_id = $request->produk_id;
        $produk = Produk::find($produk_id);
        if (!$produk) {
            return response()->json([
                'status'     => false,
                'message' => "Produk tidak ditemukan!"
            ], 400);
        }

        $file = $request->file('gambar');

        // Buat nama file yang unik
        $fileName = time() . '_' . $produk->id . '.' . $file->getClientOriginalExtension();

        // Simpan gambar ke direktori public/assets/img
        $file->move(public_path('assets/img'), $fileName);

        $urlImage = "assets/img/" . $fileName;

        if ($request->type == "gambar") {
            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }
            $produk->gambar = $urlImage;
        }

        if ($request->type == "gambar_2") {
            if ($produk->gambar_2 && file_exists(public_path($produk->gambar_2))) {
                unlink(public_path($produk->gambar_2));
            }
            $produk->gambar_2 = $urlImage;
        }

        if ($request->type == "gambar_3") {
            if ($produk->gambar_3 && file_exists(public_path($produk->gambar_3))) {
                unlink(public_path($produk->gambar_3));
            }
            $produk->gambar_3 = $urlImage;
        }

        $produk->save();

        return response()->json([
            'status'     => true,
            'message' => 'Success upload gambar produk'
        ], 200);
    }

    public function addwarnaproduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'warna' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Warna::create([
            'warna' => $request->warna,
            'bg_color' => $request->bg_color,
            'keterangan' => $request->keterangan,
            'produk_id' => $request->produk_id,
        ]);

        return redirect()->to(url('admin/produk/' . $request->produk_id . '/edit'))
            ->with('success', 'Warna produk berhasil ditambahkan.');
    }

    public function updatewarnaproduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'warna' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $warna = Warna::findOrFail($request->id);
        $warna->warna = $request->warna;
        $warna->bg_color = $request->bg_color;
        $warna->keterangan = $request->keterangan;
        $warna->produk_id = $request->produk_id;
        $warna->save();

        return redirect()->to(url('admin/produk/' . $request->produk_id . '/edit'))
            ->with('success', 'Warna produk berhasil diubah.');
    }

    public function destroywarnaproduk($id)
    {
        try {
            $warnaproduk = Warna::findOrFail($id);
            $warnaproduk->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status'   => false,
                'message'  =>  'Tidak dapat mengahapus data, data warna sudah berhubungan dengan data lain'
            ], 400);
        }
        return response()->json([
            'status'     => true,
            'message' => 'Success menghapus warna produk'
        ], 200);
    }

    public function detailwarna($id)
    {
        $warna = Warna::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $warna
        ], 200);
    }


    private function preprocessText($text)
    {
        // Cleaning
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);

        // Case Folding
        $text = strtolower($text);

        // Tokenisasi
        $tokens = explode(' ', $text);

        // Lemmatization
        $lemmas = array_map([$this, 'lemma'], $tokens);

        // Stopword Removal (Contoh stopwords: 'dan', 'yang', 'di')
        $stopwords = ['dan', 'yang', 'di'];
        $filteredTokens = array_diff($lemmas, $stopwords);

        return $filteredTokens;
    }

    private function lemma($word)
    {
        // Logika lemmatization sederhana (ganti dengan algoritma lemmatization sesungguhnya)
        // Contoh: mengembalikan kata dasar atau bentuk dasar dari kata yang diberikan
        return $word; // Ganti ini dengan hasil lemmatization yang sesungguhnya
    }

    private function calculateTFIDF($document, $corpus)
    {
        // Hitung Term Frequency (TF)
        $tf = [];
        $termCounts = array_count_values($document);
        foreach ($document as $term) {
            $tf[$term] = $termCounts[$term] / count($document);
        }

        // Hitung Inverse Document Frequency (IDF)
        $idf = [];
        $corpusSize = count($corpus);
        foreach ($document as $term) {
            $termInCorpus = array_count_values($corpus)[$term] ?? 0;
            $idf[$term] = log($corpusSize / ($termInCorpus + 1));
        }

        // Hitung TF-IDF
        $tfidf = [];
        foreach ($document as $term) {
            $tfidf[$term] = $tf[$term] * $idf[$term];
        }

        return $tfidf;
    }

    private function cosineSimilarity($vectorA, $vectorB)
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        foreach ($vectorA as $term => $value) {
            $dotProduct += $value * ($vectorB[$term] ?? 0);
            $magnitudeA += pow($value, 2);
        }

        foreach ($vectorB as $value) {
            $magnitudeB += pow($value, 2);
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        return $magnitudeA && $magnitudeB ? $dotProduct / ($magnitudeA * $magnitudeB) : 0;
    }
}
