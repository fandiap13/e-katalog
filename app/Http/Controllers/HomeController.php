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
        $produk = Produk::limit(8)->orderBy('created_at', 'desc')->get();
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
        $query->join('brand', 'brand.id', '=', 'produk.brand_id');
        $query->whereRaw('LOWER(produk.nama) LIKE ?', ['%' . $search . '%']);
        $query->orWhereRaw('LOWER(kategori.nama) LIKE ?', ['%' . $search . '%']);
        $query->orWhereRaw('LOWER(brand.nama) LIKE ?', ['%' . $search . '%']);

        // pencarian brand
        if (!empty($brand_id)) {
            $query->where('produk.brand_id', $brand_id);
        }

        // pencarian brand
        if (!empty($kategori_id)) {
            $query->where('produk.kategori_id', $kategori_id);
        }

        // pencarian harga
        if (!empty($harga_awal) && !empty($harga_akhir)) {
            $query->whereBetween('produk.harga', [$harga_awal, $harga_akhir]);
        }

        if ($pengurutan) {
            $query->orderByRaw('CAST(produk.harga AS UNSIGNED) ' . $pengurutan);
        } else {
            $query->orderBy("id", "DESC");
        }

        $data = $query->paginate(10)->appends([
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
        $produk = Produk::orderBy('created_at', 'desc')->get();
        $kategori = Kategori::all();
        $brand = Brand::all();

        return view("produk", [
            'title' => "Daftar Produk",
            'data' => $produk,
            'kategori' => $kategori,
            'brand' => $brand,
        ]);
    }

    public function tentangkami(Request $request)
    {
        return "on going";
    }

    public function faq(Request $request)
    {
        return "on going";
    }
}
