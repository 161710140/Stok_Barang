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

   // public function MainCat()
   // {
   //    return $this->belongsTo('App\Kategori','parent_id');
   // }

   // public function SubCat()
   // {
   //    return $this->hasMany('App\Kategori','parent_id');
   // }
}
