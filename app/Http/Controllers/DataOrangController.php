<?php

namespace App\Http\Controllers;

use App\DataOrang;
use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\DataTables\Datatables;
use PDF;
class DataOrangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function json()
    // {
    //   return datatables()->of(DataOrang::all())->make(true);
    // }

    public function index()
    {
        return view('DataOrang.index');
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
         $this->validate($request,[
            'Nama' => 'required',
            'Lahir' => 'required',
            'Alamat' => 'required',
            ],
            [
                'Nama.required'=>'Isi Data Terlebih Dahulu',
            ]
        );
        // Mengambil Semua Inputan Data Sebagai Array
         $Nama = $request->all();
         // Memberi Attribute NULL pada Photo
         $Nama['Photo'] = null;
         

         if ($request->hasFile('Photo')){
            $Nama['Photo'] = '/upload/Photo/'.str_slug($Nama['Nama'], '-').'.'
            .$request->Photo->getClientOriginalExtension();
            $request->Photo->move(public_path('/upload/Photo/'), $Nama['Photo']);
        }
        DataOrang::create($Nama);

        return response()->json([
            'success' => true,
            'message' => 'Data Successfully Added'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DataOrang  $dataOrang
     * @return \Illuminate\Http\Response
     */
    public function show(DataOrang $dataOrang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DataOrang  $dataOrang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Nama = DataOrang::findOrFail($id);
        return $Nama;
        return view('DataOrang.form-edit');
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DataOrang  $dataOrang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    { 
        $input = $request->all();
        $Nama =DataOrang::findOrFail($id);
        $input['Photo'] = $Nama->Photo;

        if ($request->hasFile('Photo')){
            if (!$Nama->Photo == null){
                unlink(public_path($Nama->Photo));
            }
           $input['Photo'] = '/upload/Photo/'.str_slug($input['Nama'], '-').'.'.$request->Photo->getClientOriginalExtension();
            $request->Photo->move(public_path('/upload/Photo/'), $input['Photo']);
        }
        $Nama->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data Successfully Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DataOrang  $dataOrang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Nama = DataOrang::findOrFail($id);
        if ($Nama->delete()) {
        if (!$Nama->Photo == null){
            unlink(public_path($Nama->Photo));
        }   
    }
        DataOrang::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data Successfully Deleted'
        ]);
    }
    public function apiData()
    {
        $Nama = DataOrang::all();
 
        return Datatables::of($Nama)
         ->addColumn('show_photo', function($Nama){
                if ($Nama->Photo == NULL){
                    return 'No Image';
                }
                return '<img class="rounded-square" width="50" height="50" src="'. url($Nama->Photo) .'?'.time().'" alt="">';
            })
            ->addColumn('action', function($Nama){
                return '<a onclick="editForm('. $Nama->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                       '<a onclick="deleteData('. $Nama->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action','show_photo','Alamat'])->make(true);
    }
    public function exportdata()
    {
        $Nama = DataOrang::limit(20)->get();
        $pdf = PDF::loadView('DataOrang.pdf', compact('Nama'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

}
