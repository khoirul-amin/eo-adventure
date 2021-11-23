@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Order Status</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Order Status</li>
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
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Form Update || Insert</h5>
                    <button type="button" onclick="clearForm()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="status">Status Gigs</label>
                        <input type="text" class="form-control" id="status" name="status" required>
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
                    "url" : "/status-order/get_datatables",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token()?>"
                    }
                },
                "columns" : [
                    {"data": "id"},
                    {"data": "status"},
                    {"data": "action"}
                ]
            });
        }

        function setDataUpdate(id,status){
            $('#id').val(id);
            $('#status').val(status);
        }

        $('#form-input').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-input')[0]);
            var url = "";
            var id = $('#id').val();  
            if(id === ""){
                url = "/status-order/insert";
            }else{
                url = "/status-order/update";
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
                    $.get(`/status-order/delete/${id}`, function(data){
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

        function clearForm(){
            $('#id').val('');
            $("#form-input")[0].reset();
            // document.getElementById('form-input').reset();
        }
        
    </script>
@endpush