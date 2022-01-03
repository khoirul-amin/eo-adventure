@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Ulasan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Data Ulasan</li>
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
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>User</th>
                                            <th>Rating</th>
                                            <th>Ulasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>NO</th>
                                            <th>User</th>
                                            <th>Rating</th>
                                            <th>Ulasan</th>
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
                    "url" : "/ulasan/get_datatables",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token()?>"
                    }
                },
                "columns" : [
                    {"data": "no"},
                    {"data": "nama"},
                    {"data": "rating"},
                    {"data": "ulasan"},
                ]
            });
        }

        
    </script>
@endpush