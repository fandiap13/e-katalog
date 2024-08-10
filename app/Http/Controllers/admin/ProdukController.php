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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat.');
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
        $title = "Edit User";
        $user = User::findOrFail($id);
        $brand = Brand::all();
        $kategori = Kategori::where("parent_id", null)->get();

        return view('admin.users.edit', compact('user', 'title', 'brand', 'kategori'));
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
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::findOrFail($id);

        $user->nama = $request->nama;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
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
            $user = User::find($id);
            $user->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status'   => false,
                'message'  =>  'Tidak dapat mengahapus data, data user sudah berhubungan dengan data lain'
            ], 400);
        }
        return response()->json([
            'status'     => true,
            'message' => 'Success delete user'
        ], 200);
    }
}
