<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{

   protected $fillable= ['nama_sub','kategori_id'];
   public $timestamps = true;

  public function parent()
   {
       return $this->belongsTo('App\Kategori','parent_id');
   }
}
