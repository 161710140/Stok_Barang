<?php

namespace App\Http\Controllers;
use App\SubKategori;
use App\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
         $subkat = SubKategori::all();
        return Datatables::of($subkat)
        ->addColumn('action', function($subkat){
            return '<a href="#" class="btn btn-xs btn-primary edit" data-id="'.$subkat->id.'">
            <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;
            <a href="#" class="btn btn-xs btn-danger delete" id="'.$subkat->id.'">
            <i class="glyphicon glyphicon-remove"></i> Delete</a>';

            })
        ->rawColumns(['action'])->make(true);
    }
    public function index()
    {
        $subkat = SubKategori::all();
        $kat = Kategori::all();
        return view('Subkategori.index',compact('subkat','kat'));
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
            'name' => 'required',
        ],[
            'name.required' => ':Attribute Tidak Boleh Kosong',
        ]);
        $data = new SubKategori;
        $data->name = $request->name;
        $data->parent_id = $request->parent_id;
        $data->save();
        return response()->json(['success'=>true]);
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
        $subkat = SubKategori::findOrFail($id);
        return $subkat;
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
         $this->validate($request, [
            'name' => 'required',
        ],[
            'name.required' => ':Attribute Tidak Boleh Kosong',
        ]);
        $data = SubKategori::findOrfail($id);
        $data->name = $request->name;
        $data->parent_id = $request->parent_id;
        $data->save();
        return response()->json(['success'=>true]);
    }

    public function removedata(Request $request)
    {
        $subkat = SubKategori::find($request->input('id'));
        if($subkat->delete())
        {
            echo 'Data Deleted';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
