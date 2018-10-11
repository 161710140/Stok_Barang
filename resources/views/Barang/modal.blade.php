<div id="supModal" class="modal fade" role="dialog" data-backdrop="static">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="POST" id="sup_form" enctype="multipart/form-data">
                {{csrf_field()}} {{ method_field('POST') }}
                  <div class="modal-header" style="background-color: lightblue;">
                     <button type="button" class="close" data-dismiss="modal" >&times;</button>
                     <h4 class="modal-title" >Add Data</h4>
                  </div>
                  <div class="modal-body">
                     
                     <span id="form_output"></span>
                     <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label>Nama :</label>
                        <select id="supplier_id" name="supplier_id" class="form-control">
                            <option selected disabled>Pilih Suplier</option>
                            @foreach($Supplier as $data)
                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                            @endforeach
                        </select>
                        <span class="help-block has-error nama_error"></span>
                     </div>

                     <div class="form-group">
                        <label>Nama Barang </label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Laptop" />
                        <span class="help-block has-error nama_error"></span>
                     </div>

                     <div class="form-group">
                        <label>Merk</label>
                        <input type="text" name="merk" id="merk" class="form-control" placeholder="Aqua" />
                        <span class="help-block has-error merk_error"></span>
                     </div>

                     <div class="form-group">
                        <label>Harga Satuan</label>
                        <input type="text" name="harga_satuan" id="harga_satuan" class="form-control" placeholder="" />
                        <span class="help-block has-error harga_satuan_error"></span>
                     </div>

                     <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" placeholder="" />
                        <span class="help-block has-error stok_error"></span>
                     </div>

                     

                  <div class="modal-footer">
                    <input type="hidden" name="student_id" id="student_id" value=""/>
                    <input type="hidden" name="button_action" id="button_action" value="insert"/>
                     <input type="submit" name="submit" id="aksi" value="Tambah" class="btn btn-info" />
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                  </div>
               </form>
            </div>
         </div>
      </div>