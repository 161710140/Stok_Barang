<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Suplier;
use App\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    public function json()
    {
        $barang = Barang::all();
        return Datatables::of($barang)
        ->addColumn('supliername', function($barang){
            return $barang->suplier->Nama;
        })
        ->addColumn('kategoriname', function($barang){
            return $barang->Kategori->Nama_Kategori;
        })
        ->addColumn('action', function($barang){
            return '<a href="#" class="btn btn-xs btn-primary edit" data-id="'.$barang->id.'">
            <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;
            <a href="#" class="btn btn-xs btn-danger delete" id="'.$barang->id.'">
            <i class="glyphicon glyphicon-remove"></i> Delete</a>';

            })
        ->rawColumns(['action','supliername','kategoriname'])->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suplier = Suplier::all();
        $kategori = Kategori::all();
        return view('barang.index', compact('suplier','kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'suplier_id' => 'required',
            'Kategori_id' => 'required',
            'Nama_Barang' => 'required',
            'Merk' => 'required|unique:barangs,Merk',
            'Harga_Satuan' => 'required',
            'Stok' => 'required',
        ],[
            'suplier_id.required' => ':Attribute Tidak Boleh Kosong',
            'Nama_Barang.required' => ':Attribute Harus Diisi',
            'Merk.required' => ':Attribute Tidak Boleh Kosong',
            'Merk.unique' => ':Attribute Sudah Tersedia!',
            'Harga_Satuan.required' => ':Attribute Harus Diisi',
            'Stok.required' => ':Attribute Harus Diisi',
        ]);
        $data = new Barang;
        $data->Kategori_id = $request->Kategori_id;
        $data->suplier_id = $request->suplier_id;
        $data->Nama_Barang = $request->Nama_Barang;
        $data->Merk = $request->Merk;
        $data->Harga_Satuan = $request->Harga_Satuan;
        $data->Stok = $request->Stok;
        $data->save();
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return $barang;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'suplier_id'=>'required',
            'Kategori_id'=>'required',
            'Nama_Barang' => 'required',
            'Merk'=>'required',
            'Harga_Satuan' => 'required',
            'Stok' => 'required',
        ],[
            'suplier_id.required' => ':Attribute Tidak Boleh Kosong',
            'Nama_Barang.required' => ':Attribute Harus Diisi',
            'Merk.required' => ':Attribute Tidak Boleh Kosong',
            'Harga_Satuan.required' => ':Attribute Tidak Boleh Kosong',
            'Stok.required' => ':Attribute Tidak Boleh Kosong',
        ]);
        $barang = Barang::findOrFail($id);
        $barang->suplier_id = $request->suplier_id;
        $barang->Kategori_id = $request->Kategori_id;
        $barang->Nama_Barang = $request->Nama_Barang;
        $barang->Merk = $request->Merk;
        $barang->Harga_Satuan = $request->Harga_Satuan;
        $barang->Stok = $request->Stok;
        $success = $barang->save();
        if ($success){
            return response()->json([
                'success'=>true,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        //
    }

    public function removedata(Request $request)
    {
        $barang = Barang::find($request->input('id'));
        if($barang->delete())
        {
            echo 'Data Deleted';
        }
    }
}
