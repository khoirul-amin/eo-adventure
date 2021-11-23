@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Transportasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Transportasi</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Tables</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalform">Tambah</button>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Transportasi</th>
                                            <th>Muatan</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Transportasi</th>
                                            <th>Muatan</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalform" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="form-input" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Form Update</h5>
                    <button type="button" onclick="clearForm()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="transportasi">Nama</label>
                        <input type="text" class="form-control" id="transportasi" name="transportasi" required>
                    </div>
                    <div class="form-group">
                        <label for="muatan">Muatan</label>
                        <input type="text" class="form-control" id="muatan" name="muatan" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="clearForm()" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
   
    <!-- Modal View && Update -->
    <div class="modal fade" id="modalView" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="form-gambar" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Form Update</h5>
                    <button type="button" onclick="clearForm()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-5 mt-2 mr-2"> 
                            <img src="{{asset('images')}}/gambar_kosong.png" id="vimages1" class="w-100" alt="images1">
                        </div>
                        <div class="col-5 mt-2 ml-2"> 
                            <img src="{{asset('images')}}/gambar_kosong.png" id="vimages2" class="w-100" alt="images2">
                        </div>
                        <div class="col-5 mt-2 mr-2">
                            <img src="{{asset('images')}}/gambar_kosong.png" id="vimages3" class="w-100" alt="images3">
                        </div>
                        <div class="col-5 mt-2 ml-2">
                            <img src="{{asset('images')}}/gambar_kosong.png" id="vimages4" class="w-100" alt="images4">
                        </div>
                    </div>
                    <hr/>
                    <h3>Silahkan Masukkan gambar untuk update</h3>
                    <input type="hidden" name="id_gambar" id="idGambar">
                    <div class="form-group">
                        <label for="images1">Images 1</label>
                        <input type="file" class="form-control-file" id="images1" name="images1">
                    </div>
                    <div class="form-group">
                        <label for="images2">Images 2</label>
                        <input type="file" class="form-control-file" id="images2" name="images2">
                    </div>
                    <div class="form-group">
                        <label for="images3">Images 3</label>
                        <input type="file" class="form-control-file" id="images3" name="images3">
                    </div>
                    <div class="form-group">
                        <label for="images4">Images 4</label>
                        <input type="file" class="form-control-file" id="images4" name="images4">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="clearForm()" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection 

@push('styles')
    
  <link rel="stylesheet" href="{{asset('assets')}}/adminLte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"  href="{{asset('assets')}}/adminLte/plugins/sweetalert2/sweetalert2.css"/>
@endpush

@push('scripts')
        
    <script src="{{asset('assets')}}/adminLte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/adminLte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('assets')}}/adminLte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/adminLte/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="{{asset('js')}}/custom.js"></script>

    <script>
        allDataProduct();
        function getAllProduct(){
            $('#example1').DataTable().destroy();
            allDataProduct();
        };

        function allDataProduct(){
            $('#example1').DataTable({
                lengthMenu: [[10, 50, 200, 1000], [10, 50, 200, 1000]],
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax": {
                    "url" : "/transportasi/get_datatables",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token()?>"
                    }
                },
                "columns" : [
                    {"data": "id"},
                    {"data": "transportasi"},
                    {"data": "muatan"},
                    {"data": "keterangan"},
                    {"data": "action"}
                ]
            });
        }

        function setDataUpdate(id,transportasi,muatan,keterangan){
            $('#id').val(id);
            $('#transportasi').val(transportasi);
            $('#muatan').val(muatan);
            $('#keterangan').val(keterangan);
        }

        $('#form-input').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-input')[0]);
            var url = "";
            var id = $('#id').val();  
            if(id === ""){
                url = "/transportasi/insert";
            }else{
                url = "/transportasi/update";
            }

            $.ajax({
                method : "POST",
                url : url,
                dataType: 'json',
                data: new FormData($('#form-input')[0]),
                contentType: false,
                processData: false,
                cache: false,
                async: false,
                success: function(data){
                    if(data.status){
                        Swal.fire({
                            title: 'Sukses',
                            text: data.message,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick :false,
                        }).then((result) => {
                            if (result.value) {
                                $('#example1').DataTable().ajax.reload();
                                clearForm();
                                $('#modalform').modal('hide');
                            }
                        })
                    }else{
                        Swal.fire(
                            'Gagal',
                            data.message,
                            'error'
                        )
                    }
                },
                error: function(err){
                    alerError(err);
                }
            })
        })

        function hapus(id){
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah anda yakin mau menghapus data ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor:'#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.get(`/transportasi/delete/${id}`, function(data){
                        if(data.status){
                            Swal.fire({
                                title: 'Sukses',
                                text: data.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                allowOutsideClick :false,
                            }).then((result) => {
                                if (result.value) {
                                    $('#example1').DataTable().ajax.reload();
                                }
                            })
                        }else{
                            Swal.fire(
                                'Gagal',
                                data.message,
                                'error'
                            )
                        }
                    });
                }
            })
        }

        $('#form-gambar').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-gambar')[0]);
            var url = "/transportasi/updategambar";
            var id = $('#idGambar').val();

            $.ajax({
                method : "POST",
                url : url,
                dataType: 'json',
                data: new FormData($('#form-gambar')[0]),
                contentType: false,
                processData: false,
                cache: false,
                async: false,
                success: function(data){
                    if(data.status){
                        Swal.fire({
                            title: 'Sukses',
                            text: data.message,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick :false,
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                                $('#example1').DataTable().ajax.reload();
                                clearForm();
                                $('#modalView').modal('hide');
                            }
                        })
                    }else{
                        Swal.fire(
                            'Gagal',
                            data.message,
                            'error'
                        )
                    }
                },
                error: function(err){
                    alerError(err);
                }
            })
        });

        function getImages(id){
            $('#idGambar').val(id);

            $.get(`/transportasi/getgambar/${id}`, async function(data){
                for(let dataRes of data){
                   await $(`#v${dataRes.deskripsi}`).attr("src", dataRes.images);
                }
            })
        }

        function clearForm(){
            $('#id').val('');
            $('#idGambar').val('');
            $("#form-input")[0].reset();
            $("#form-gambar")[0].reset();
            // document.getElementById('form-input').reset();
        }
        
    </script>
@endpush