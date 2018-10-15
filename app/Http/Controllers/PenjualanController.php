<?php

namespace App\Http\Controllers;

use App\Penjualan;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Barang;
use App\Kategori;
class PenjualanController extends Controller
{
    public function json()
    {
        $jual = Penjualan::all();
        return Datatables::of($jual)
        ->addColumn('jual', function($jual){
            return $jual->barangjual->Merk;
        })
         ->addColumn('kategoriname', function($jual){
            return $jual->Kategori->Nama_Kategori;
        })
        ->addColumn('formatharga', function($jual){
            return number_format($jual->Total_Bayar,2,',','.');
        })
        ->addColumn('action', function($jual){
            return '<a href="#" class="btn btn-xs btn-primary edit" data-id="'.$jual->id.'">
            <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;
            <a href="#" class="btn btn-xs btn-danger delete" id="'.$jual->id.'">
            <i class="glyphicon glyphicon-remove"></i> Delete</a>';

            })
        ->rawColumns(['action','jual','formatharga','kategoriname'])->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        $jual = Penjualan::all();
        $kategori = Kategori::all();
        return view('penjual.index', compact('barang','jual','kategori'));
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
        $barang = Barang::where('id',$request->Barang_id)->first();
        $Stok = $barang->Stok;
        $this->validate($request, [
            'Kode_Penjualan' => 'required',
            'Tanggal_Jual' => 'required',
            'Nama_Pelanggan' => 'required',
            'Barang_id' => 'required',
            'Kategori_id' => 'required',
            'Jumlah' => "required|numeric|max:$Stok|min:1",
            // 'Total_Bayar' => 'required',
        ],[
            'Kode_Penjualan.required' => ':Attribute Tidak Boleh Kosong',
            'Tanggal_Jual.required' => ':Attribute Harus Diisi',
            'Nama_Pelanggan.required' => ':Attribute Tidak Boleh Kosong',
            'Barang_id.required' => ':Attribute Harus Diisi',
            'Kategori_id.required' => ':Attribute Harus Diisi',
            'Jumlah.required' => ':Attribute Diisi',
            'Jumlah.max' => ":Attribute tidak boleh melebihi jumlah stok yaitu ".$Stok,
            // 'Total_Bayar.required' => 'Harus Diisi',
        ]);
        $data = new Penjualan;
        $data->Kode_Penjualan = $request->Kode_Penjualan;
        $data->Tanggal_Jual = $request->Tanggal_Jual;
        $data->Nama_Pelanggan = $request->Nama_Pelanggan;
        $data->Barang_id = $request->Barang_id;
        $data->Kategori_id = $request->Kategori_id;
        $data->Jumlah = $request->Jumlah;
        $total = $request->Jumlah;
        $baru = Barang::where('id', $data->Barang_id)->first();
        $data->Total_Bayar = $total*$baru->Harga_Satuan;
        $data->save();
        $baru->Stok = $baru->Stok - $total;
        $baru->save();
        return response()->json([
            'success'=>true,
            'message'=>'Berhasil!'

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return $penjualan;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'Kode_Penjualan' => 'required',
            'Tanggal_Jual' => 'required',
            'Nama_Pelanggan' => 'required',
            'Barang_id' => 'required',
            'Jumlah' => 'required|not_in:0',
            // 'Total_Bayar' => 'required',
        ],[
            'Kode_Penjualan.required' => ':Attribute Tidak Boleh Kosong',
            'Tanggal_Jual.required' => ':Attribute Harus Diisi',
            'Nama_Pelanggan.required' => ':Attribute Tidak Boleh Kosong',
            'Barang_id.required' => ':Attribute Harus Diisi',
            'Jumlah.required' => ':Attribute Harus Diisi',
            'Jumlah.not_in'=> ':Attribute tidak boleh 0'
            // 'Total_Bayar.required' => 'Harus Diisi',
        ]);
        $data = Penjualan::find($id);
        $data->Kode_Penjualan = $request->Kode_Penjualan;
        $data->Tanggal_Jual = $request->Tanggal_Jual;
        $data->Nama_Pelanggan = $request->Nama_Pelanggan;
        $data->Kategori_id = $request->Kategori_id;
        $data->Barang_id = $request->Barang_id;

        $baru = Barang::where('id', $data->Barang_id)->first();
        if ($request->Jumlah <= $baru->Stok) 
        {
             $data->Jumlah = $request->Jumlah;
             $Jumlah = Penjualan::find($id);
             $Jumlah->Jumlah = $Jumlah->Jumlah - $request->Jumlah;

             $stok = Barang::where('id', $data->Barang_id)->first();
             $stok->Stok =  $stok->Stok + $Jumlah->Jumlah;
             $stok->save();
             $Jumlah->save();
             $data->Total_Bayar = $data->Jumlah*$baru->Harga_Satuan;
             $data->save(); 

            return response()->json([
                'success'=>true,
                'message'=>'Data Berhasil Di Update!'
            ]);   
        }
        elseif ($request->Jumlah >= $baru->Stok) 
        {
             
             $stok = Barang::where('id', $data->Barang_id)->first();
             $stok->Stok =  ($stok->Stok + $data->Jumlah) - $request->Jumlah;
             $stok->save();
             $data->Jumlah = $request->Jumlah;

             $Jumlah = Penjualan::find($id);
             $Jumlah->Jumlah = $Jumlah->Jumlah - $request->Jumlah;

             $Jumlah->save();
             $data->Total_Bayar = $data->Jumlah*$baru->Harga_Satuan;
             $data->save(); 
             return response()->json([
                'success'=>true,
                'message'=>'Data Berhasil Di Update!'
                 ]); 
        }
            return response()->json([
                'error'=>true,
            ]);
        
        // $baru = Barang::where('id', $data->Barang_id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
    public function removedata(Request $request)
    {
        $penjualan = Penjualan::find($request->input('id'));
        if($penjualan->delete())
        {
            echo 'Data Deleted';
        }
    }
}
