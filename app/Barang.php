<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['Kategori_id','suplier_id','Nama_Barang', 'Merk', 'Harga_Satuan', 'Stok'];
    public $timestamp = true;

    public function suplier(){
    	return $this->belongsTo('App\Suplier','suplier_id');
    }

    public function penjualan(){
    	return $this->hasOne('App\Penjualan','Barang_id');
    }

    public function Kategori()
    {
    	return $this->belongsTo('App\Kategori','Kategori_id');
    }
}
