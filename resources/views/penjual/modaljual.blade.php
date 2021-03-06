<!DOCTYPE html>
<html>
<head>
	<title>Penjualan</title>
</head>
<body>
	<div id="jualModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog">
         <div class="modal-content">
            <form method="post" id="jual_form" enctype="multipart/form-data">
               <div class="modal-header" style="background-color: lightblue;">
                  <h4 class="modal-title" >Add Data</h4>
                  <button type="button" class="close" data-dismiss="modal" >&times;</button>
               </div>

               <div class="modal-body">
                  {{csrf_field()}} {{ method_field('POST') }}
                  <span id="form_tampil"></span>
                  <input type="hidden" name="id" id="id">

                  <div class="form-group">
                     <label>Kode Penjualan</label>
                     <input type="text" name="Kode_Penjualan" id="Kode_Penjualan" class="form-control" placeholder="masukan kode barang">
                     <span class="help-block has-error Kode_Penjualan_error"></span>
                  </div>

                  <div class="form-group">
                     <label>Tanggal Jual</label>
                     <input type="date" name="Tanggal_Jual" id="Tanggal_Jual" class="form-control">
                     <span class="help-block has-error Tanggal_Jual_error"></span>
                  </div>

                  <div class="form-group">
                     <label>Nama Pelanggan</label>
                     <input type="text" name="Nama_Pelanggan" id="Nama_Pelanggan" class="form-control" placeholder="masukan nama anda">
                     <span class="help-block has-error Jumlah_error"></span>
                  </div>
               
                  <div class="form-group {{ $errors->has('Barang_id') ? 'has-error' : '' }}">

                     <label>Barang</label>
                     <select class="form-control select-dua" name="Barang_id" id="Barang_id" style="width: 468px">
                     	<option disabled selected>Pilih Barang</option>
                     	@foreach($barang as $data)
                     	<option value="{{$data->id}}">{{$data->Merk}}</option>
                     	@endforeach
                     </select>
                     <span class="help-block has-error Nama_Barang_error">
                  </div>

                  <div class="form-group">
                  	<label>Jumlah</label>
                     <input type="text" id="Jumlah" name="Jumlah" class="form-control" placeholder="masukan jumlah">
                  	<span class="help-block has-error Jumlah_error"></span>
                  </div>
                  <label>Nama Kategori</label>
                     <select class="form-control select-dua" name="Kategori_id" id="Kategori_id" style="width: 468px">
                        <option disabled selected>Pilih Kategori</option>
                        @foreach($kategori as $data)
                        <option value="{{$data->id}}">{{$data->Nama_Kategori}}</option>
                        @endforeach
                     </select>
                     @if ($errors->has('Kategori_id'))
                     <span class="help-block has-error Nama_error">
                        <strong>{{$errors->first('Kategori_id')}}</strong>
                     </span>
                     @endif
                  </div>          
				<div class="modal-footer">
					<input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
					<input type="button" value="Cancel" class="btn btn-default" data-dismiss="modal"/>
				</div>
               </form>
            </div>
         </div>
      </div>

</body>
</html>