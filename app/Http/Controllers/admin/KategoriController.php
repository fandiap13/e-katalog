<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type');
        $title = "List Kategori";
        $query = Kategori::where('nama', 'like', '%' . $search . '%');
        if ($type == "parent") {
            $query->where('parent_id', null);
        }
        if ($type == "subkategori") {
            $query->where('parent_id', '!=', null);
        }
        $data = $query->paginate(10)->appends(['search' => $search]);
        return view('admin.kategori.index', compact('data', 'title', 'search', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Kategori";
        // $parentKategori = Kategori::where('parent_id', null)->get();
        $parentKategori = Kategori::get();

        return view('admin.kategori.create', compact('title', 'parentKategori'));
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
            'nama' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Kategori::create([
            'nama' => $request->nama,
            'parent_id' => $request->parent_id ? $request->parent_id : null
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Kategori";
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.show', compact('kategori', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Kategori";
        $kategori = Kategori::findOrFail($id);
        // $parentKategori = Kategori::where('parent_id', null)->get();
        $parentKategori = Kategori::get();
        return view('admin.kategori.edit', compact('kategori', 'title', 'parentKategori'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kategori = Kategori::findOrFail($id);

        $kategori->nama = $request->nama;
        $kategori->parent_id = $request->parent_id ? $request->parent_id : null;

        $kategori->save();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
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
            $data = Kategori::find($id);
            $data->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status'   => false,
                'message'  =>  'Tidak dapat mengahapus data, data kategori sudah berhubungan dengan data lain'
            ], 400);
        }
        return response()->json([
            'status'     => true,
            'message' => 'Success delete kategori'
        ], 200);
    }
}
