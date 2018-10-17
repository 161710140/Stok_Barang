<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
   protected $fillable= ['Nama_Kategori'];
   public $timestamps = true;

   public function Barang()
   {
   	 return $this->hasMany('App\Barang','Kategori_id');
   }

   public function Penjualan()
   {
   	 return $this->hasOne('App\Penjualan','Kategori_id');
   }
   public function childs()
   {
      return $this->hasMany('App\SubKategori','parent_id');
   }
}
