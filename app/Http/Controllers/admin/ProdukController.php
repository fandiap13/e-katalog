<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
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

        $search = $request->get('search') ? strtolower($request->get('search')) : "";
        $query = Produk::select("produk.*");
        $query->join('kategori', 'kategori.id', '=', 'produk.kategori_id');
        $query->join('brand', 'brand.id', '=', 'produk.brand_id');
        $query->whereRaw('LOWER(produk.nama) LIKE ?', ['%' . $search . '%']);
        $query->orWhereRaw('LOWER(kategori.nama) LIKE ?', ['%' . $search . '%']);
        $query->orWhereRaw('LOWER(brand.nama) LIKE ?', ['%' . $search . '%']);
        $data = $query->paginate(10)->appends(['search' => $search]);

        return view('admin.produk.index', compact('data', 'title', 'search'));
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
            'brand_id' => 'required',
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
            'brand_id' => $request->brand_id,
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
}
