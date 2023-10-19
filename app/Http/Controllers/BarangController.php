<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manage_barang', [
            'title' => "Manage Barang"
        ]);
    }

    public function getAll()
    {
        return Barang::all()->toJson();
    }

    public function getData($id)
    {
        return Barang::find($id)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'foto_barang' => 'required|mimes:png,jpg|max:100',
            'nama_barang' => 'required|max:255|unique:tbl_barang',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required'
        ]);
        if ($request->file('foto_barang')) {
            $validatedData['foto_barang'] = $request->file('foto_barang')->store('img/foto-barang');
        }
        Barang::create($validatedData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $rules = [
            'nama_barang' => 'required|max:255|unique:tbl_barang,nama_barang,' . $request->input('id_barang'),
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer'
        ];
        if ($request->file('foto_barang')) {
            $rules['foto_barang'] = 'nullable|mimes:jpg,png|max:100';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto_barang')) {
            $validatedData['foto_barang'] = $request->file('foto_barang')->store('img/foto-barang');
        }

        Barang::find($request->input('id_barang'))->update($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Barang::where('id', $request->input('id'))->delete();
    }
}
