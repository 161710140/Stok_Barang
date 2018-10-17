<!DOCTYPE html>
<html>
<head>
	<title>Penjualan</title>
</head>
<body>
	<div id="Modal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog">
         <div class="modal-content">
            <form method="post" id="form" enctype="multipart/form-data">
               <div class="modal-header" style="background-color: lightblue;">
                  <h4 class="modal-title" >Add Data</h4>
                  <button type="button" class="close" data-dismiss="modal" >&times;</button>
               </div>

               <div class="modal-body">
                  {{csrf_field()}} {{ method_field('POST') }}
                  <span id="form_tampil"></span>
                  <input type="hidden" name="id" id="id">

                  <div class="form-group">
                     <label>Nama KategoriSub</label>
                     <input type="text" name="name" id="name" class="form-control" placeholder="Masukan Nama Kategori">
                     <span class="help-block has-error Nama_Kategori_error"></span>
                  </div>
                   <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">

                     <label>Kategori Utama</label>
                     <select class="form-control select-dua" name="parent_id" id="parent_id" style="width: 468px">
                        <option disabled selected>Pilih Kategori</option>
                        @foreach($kat as $data)
                        <option value="{{$data->id}}">{{$data->Nama_Kategori}}</option>
                        @endforeach
                     </select>
                     <span class="help-block has-error Nama_Barang_error">
                  </div>

				<div class="modal-footer">
					<input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
					<input type="button" value="Cancel" class="btn btn-default" data-dismiss="modal"/>
				</div>
               </form>
            </div>
         </div>
      </div>
      <script type="text/javascript">
      </script>
</body>
</html>