<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BrandController extends Controller
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
        $title = "List Brand";
        $query = Brand::where('nama', 'like', '%' . $search . '%');
        $data = $query->paginate(10)->appends(['search' => $search]);
        return view('admin.brand.index', compact('data', 'title', 'search', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Brand";
        return view('admin.brand.create', compact('title'));
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

        Brand::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.brand.index')
            ->with('success', 'Brand berhasil dibuat.');
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
        $title = "Edit Brand";
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand', 'title'));
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

        $brand = Brand::findOrFail($id);

        $brand->nama = $request->nama;

        $brand->save();

        return redirect()->route('admin.brand.index')
            ->with('success', 'Brand berhasil diperbarui.');
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
            $data = Brand::find($id);
            $data->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status'   => false,
                'message'  =>  'Tidak dapat mengahapus data, data brand sudah berhubungan dengan data lain'
            ], 400);
        }
        return response()->json([
            'status'     => true,
            'message' => 'Success delete brand'
        ], 200);
    }
}
