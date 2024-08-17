<?php

namespace App\Http\Controllers;

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
        $produk = Produk::orderBy('created_at', 'desc')->get();
        return view("produk", [
            'title' => "Daftar Produk",
            'data' => $produk,
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
