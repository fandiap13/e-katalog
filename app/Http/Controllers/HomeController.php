<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::limit(4)->orderBy('created_at', 'desc')->get();
        return view("home", [
            'title' => "Beranda",
            'data' => $produk,
        ]);
    }

    public function produk(Request $request)
    {
        $search = $request->get('search') ? strtolower($request->get('search')) : "";
        $kategori_id = $request->get('kategori');
        $brand_id = $request->get('brand');
        $harga_awal = $request->get('harga_awal');
        $harga_akhir = $request->get('harga_akhir');
        $pengurutan = $request->get('pengurutan');

        $query = Produk::select("produk.*");
        $query->join('kategori', 'kategori.id', '=', 'produk.kategori_id');
        $query->leftJoin('brand', 'brand.id', '=', 'produk.brand_id');

        if (!empty($search)) {
            $query->whereRaw('LOWER(produk.nama) LIKE ?', ['%' . $search . '%']);
            $query->orWhereRaw('LOWER(kategori.nama) LIKE ?', ['%' . $search . '%']);
            $query->orWhereRaw('LOWER(brand.nama) LIKE ?', ['%' . $search . '%']);
        }

        // pencarian brand
        if (!empty($brand_id)) {
            $query->where('produk.brand_id', $brand_id);
        }

        // pencarian kategori
        if (!empty($kategori_id)) {
            $query->where('produk.kategori_id', $kategori_id);
        }

        // pencarian harga
        if (!empty($harga_awal) && !empty($harga_akhir)) {
            $query->whereBetween('produk.harga', [$harga_awal, $harga_akhir]);
        }

        if ($pengurutan) {
            if ($pengurutan == 'terdahulu') {
                $query->orderBy('produk.created_at', "ASC");
            }
            if ($pengurutan == 'terbaru') {
                $query->orderBy('produk.created_at', "DESC");
            }
            if ($pengurutan == 'termurah') {
                $query->orderByRaw('CAST(produk.harga AS UNSIGNED) ASC');
            }
            if ($pengurutan == 'termahal') {
                $query->orderByRaw('CAST(produk.harga AS UNSIGNED) DESC');
            }
        }

        $data = $query->paginate(12)->appends([
            'search' => $search,
            'pengurutan' => $pengurutan,
            'harga_awal' => $harga_awal,
            'harga_akhir' => $harga_akhir,
            'kategori' => $kategori_id,
            'brand' => $brand_id,
        ]);

        $kategori = Kategori::all();
        $brand = Brand::all();

        return view("produk", [
            'title' => "Daftar Produk",
            'data' => $data,
            'kategori' => $kategori,
            'brand' => $brand,
            // pencarian
            'search' => $search,
            'pengurutan' => $pengurutan,
            'harga_awal' => $harga_awal,
            'harga_akhir' => $harga_akhir,
            'kategori_id' => $kategori_id,
            'brand_id' => $brand_id,
        ]);
    }

    public function detailproduk($id)
    {
        $produk = Produk::findOrFail($id);

        $produk_terkait = Produk::select("produk.*")
            ->where('kategori_id', $produk->kategori_id)
            // ->orWhere('brand_id', $produk->brand_id)
            ->limit(4)
            ->get();

        return view("detail_produk", [
            'title' => "Detail Produk",
            'data' => $produk,
            'produk_terkait' => $produk_terkait,
            'link_produk_terkait' => url('produk?kategori=' . $produk->kategori_id . '&brand=' . $produk->brand_id)
        ]);
    }

    public function tentangkami(Request $request)
    {
        return view('tentangkami', [
            'title' => "Tentang Kami"
        ]);
    }

    public function faq(Request $request)
    {
        return view('faq', [
            'title' => "FAQ"
        ]);
    }
}
