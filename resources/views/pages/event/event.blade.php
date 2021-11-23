@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Event</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Event</li>
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
                                            <th>Trip</th>
                                            <th>Harga</th>
                                            <th>Kategori</th>
                                            <th>Tujuan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Trip</th>
                                            <th>Harga</th>
                                            <th>Kategori</th>
                                            <th>Tujuan</th>
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
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="biaya">Harga Mulai Dari</label>
                        <input type="number" class="form-control" id="biaya" name="biaya" required>
                    </div>
                    <div class="form-group">
                        <label for="kuota">Kuota Maksimum</label>
                        <input type="text" class="form-control" id="kuota" name="kuota" required>
                    </div>
                    <div class="form-group">
                        <label for="transportasi">Transportasi</label>
                        <select class="form-control" id="transportasi" name="transportasi">
                            @foreach ($transportasi as $trans)
                                <option value={{$trans->id}}>{{$trans->transportasi}} - Muatan Max {{$trans->muatan}} Orang</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori Event</label>
                        <select class="form-control" id="kategori" name="kategori">
                            @foreach ($kategori as $kat)
                                <option value={{$kat->id}}>{{$kat->kategori}}</option>
                            @endforeach
                        </select>
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


    <!-- Modal View Paket  -->
    <div class="modal fade" id="paketView" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Form Update</h5>
                    <button type="button" onclick="clearForm()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row ml-0 mr-0 mb-2" id="form-paket">
                        <div class="col-4">
                            <input type="hidden" id="event_id" name="event_id" />
                            <div class="form-group">
                                <label for="paket">Paket Peserta</label>
                                <input type="text" class="form-control" id="paket" name="paket" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                        </div>
                        <div class="col-4 pt-2">
                            <button type="submit" class="btn btn-primary mt-4">Tambahkan</button>
                        </div>
                    </form>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table-paket">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Paket</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="clearForm()" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal View Jadwal  -->
    <div class="modal fade" id="agendaView" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Form Update</h5>
                    <button type="button" onclick="clearForm()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row ml-0 mr-0 mb-2" id="form-agenda">
                        <div class="col-4">
                            <input type="hidden" id="eventagenda_id" name="eventagenda_id" />
                            <div class="form-group mb-1">
                                <label for="destinasi">Destinasi</label>
                                <select class="form-control" id="destinasi" name="destinasi">
                                    @foreach ($destinasi as $dest)
                                        <option value={{$dest->id}}>{{$dest->nama_tujuan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label for="waktu">Waktu</label>
                                <input type="text" class="form-control" id="waktu" name="waktu" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="kegiatan">Kegiatan</label>
                                <textarea class="form-control" id="kegiatan" name="kegiatan" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="col-1 pt-2">
                            <button type="submit" class="btn btn-primary mt-4">Tambahkan</button>
                        </div>
                    </form>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table-jadwal">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Tujuan & Kegiatan</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="clearForm()" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal View Keterangan  -->
    <div class="modal fade" id="keteranganView" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Form Update</h5>
                    <button type="button" onclick="clearForm()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row ml-0 mr-0 mb-2" id="form-keterangan">
                        <div class="col-4">
                            <input type="hidden" id="eventketerangan_id" name="eventketerangan_id" />
                            <div class="form-group mb-1">
                                <label for="jenis">Jenis Keterangan</label>
                                <select class="form-control" id="jenis" name="jenis">
                                    <option value="Deskripsi">Deskripsi</option>
                                    <option value="Perlengkapan">Perlengkapan</option>
                                    <option value="Fasilitas">Fasilitas</option>
                                    <option value="Tidak Termasuk">Tidak Termasuk</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="col-1 pt-2">
                            <button type="submit" class="btn btn-primary mt-4">Tambahkan</button>
                        </div>
                    </form>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm" id="table-keterangan">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="clearForm()" data-dismiss="modal">Close</button>
                </div>
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
                    "url" : "/event/get_datatables",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token()?>"
                    }
                },
                "columns" : [
                    {"data": "id"},
                    {"data": "judul"},
                    {"data": "biaya"},
                    {"data": "kategori"},
                    {"data": "tujuan"},
                    {"data": "action"}
                ]
            });
        }

        function setDataUpdate(id,judul,biaya,transportasi,kategori,kuota){
            $('#id').val(id);
            $('#judul').val(judul);
            $('#biaya').val(biaya);
            $('#transportasi').val(transportasi);
            $('#kategori').val(kategori);
            $('#kuota').val(kuota);
        }

        $('#form-input').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-input')[0]);
            var url = "";
            var id = $('#id').val();  
            if(id === ""){
                url = "/event/insert";
            }else{
                url = "/event/update";
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

        $('#form-gambar').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-gambar')[0]);
            var url = "/event/updategambar";
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

        $('#form-paket').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-paket')[0]);
            var url = "/event/insertpaket";

            $.ajax({
                method : "POST",
                url : url,
                dataType: 'json',
                data: new FormData($('#form-paket')[0]),
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
                                $('#table-paket').DataTable().ajax.reload();
                                clearForm();
                                // $('#modalView').modal('hide');
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

        $('#form-agenda').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-agenda')[0]);
            var url = "/event/insertjadwal";

            $.ajax({
                method : "POST",
                url : url,
                dataType: 'json',
                data: new FormData($('#form-agenda')[0]),
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
                                $('#table-jadwal').DataTable().ajax.reload();
                                clearForm();
                                // $('#modalView').modal('hide');
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

        $('#form-keterangan').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($('#form-keterangan')[0]);
            var url = "/event/insertketerangan";

            $.ajax({
                method : "POST",
                url : url,
                dataType: 'json',
                data: new FormData($('#form-keterangan')[0]),
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
                                $('#table-keterangan').DataTable().ajax.reload();
                                $('#keterangan').val('');
                                // clearForm();
                                // $('#modalView').modal('hide');
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
                    $.get(`/event/delete/${id}`, function(data){
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

        function getImages(id){
            $('#idGambar').val(id);

            $.get(`/event/getgambar/${id}`, function(data){
                for(let dataRes of data){
                    $(`#v${dataRes.deskripsi}`).attr("src", dataRes.images);
                }
            })
        }


        function getPaket(id){
            $('#event_id').val(id);
            $('#table-paket').DataTable().destroy();
            $('#table-paket').DataTable({
                "processing": true,
                "lengthChange": false,
                "serverSide": true,
                "searching": false,
                "ordering" : false,
                "paging":   false,
                "info": false,
                "autoWidth": false,
                "ajax": {
                    "url" : "/event/get_data_paket",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token()?>",
                        "id": id
                    }
                },
                "columns" : [
                    {"data": "id"},
                    {"data": "paket"},
                    {"data": "harga"},
                    {"data": "action"}
                ]
            });
        }

        function hapusPaket(id){
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
                    $.get(`/event/hapuspaket/${id}`, function(data){
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
                                    $('#table-paket').DataTable().ajax.reload();
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
        
        function hapusJadwal(id){
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
                    $.get(`/event/hapusjadwal/${id}`, function(data){
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
                                    $('#table-jadwal').DataTable().ajax.reload();
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

        function getAgenda(id){
            $('#eventagenda_id').val(id);
            $('#table-jadwal').DataTable().destroy();
            $('#table-jadwal').DataTable({
                "processing": true,
                "lengthChange": false,
                "serverSide": true,
                "searching": false,
                "ordering" : false,
                "paging":   false,
                "info": false,
                "autoWidth": false,
                "ajax": {
                    "url" : "/event/get_data_jadwal",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token()?>",
                        "id": id
                    }
                },
                "columns" : [
                    {"data": "id"},
                    {"data": "waktu"},
                    {"data": "tujuan"},
                    {"data": "action"}
                ]
            });
        }

        function getKeterangan(id){
            $('#eventketerangan_id').val(id);
            $('#table-keterangan').DataTable().destroy();
            $('#table-keterangan').DataTable({
                "processing": true,
                "lengthChange": false,
                "serverSide": true,
                "searching": false,
                "ordering" : false,
                "paging":   false,
                "info": false,
                "autoWidth": false,
                "ajax": {
                    "url" : "/event/get_data_keterangan",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token()?>",
                        "id": id
                    }
                },
                "columns" : [
                    {"data": "id"},
                    {"data": "judul"},
                    {"data": "keterangan"},
                    {"data": "action"}
                ]
            });
        }
        function hapusKeterangan(id){
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
                    $.get(`/event/hapusketerangan/${id}`, function(data){
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
                                    $('#table-keterangan').DataTable().ajax.reload();
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
            // $('#event_id').val('');
            // $('#eventagenda_id').val('');
            $('#idGambar').val('');
            $("#form-input")[0].reset();
            $("#form-gambar")[0].reset();
            $("#form-paket")[0].reset();
            $("#form-agenda")[0].reset();
            // $("#form-keterangan")[0].reset();
            // document.getElementById('form-input').reset();
        }
        
    </script>
@endpush