<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    // protected $table = 'supliers';
    protected $fillable = ['Nama','Asal_Kota'];
    public $timestamp = true;

    public function barang(){
    	return $this->hasMany('App\Barang','suplier_id');
    }
}
