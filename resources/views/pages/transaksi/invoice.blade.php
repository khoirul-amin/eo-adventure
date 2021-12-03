<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice {{$data->invoice}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h1 class="text-success mb-0 pb-0"><b>{{ config('app.name', 'Laravel') }}</b></h1>
            </div>
            <div class="col-6 ml-auto">
                <p class="text-right mb-0"><b>INVOICE</b><br>
                <span class="text-success">{{$data->invoice}}</span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <th width="23%">Penyedia Jasa</th>
                            <td width="2%">:</td>
                            <td>{{ config('app.name', 'Laravel') }}</td>

                            <th width="23%">Admin</th>
                            <td width="2%">:</td>
                            <td>{{$admin_name}}</td>
                        </tr>
                        <tr>
                            <th width="23%">Pemesan</th>
                            <td width="2%">:</td>
                            <td>{{$user->name}}</td>

                            <th width="23%">Total Bayar</th>
                            <td width="2%">:</td>
                            <td>Rp {{number_format($paket->harga,0,',','.')}}</td>
                        </tr>
                        <tr>
                            <th width="23%">Tanggal Transaksi</th>
                            <td width="2%">:</td>
                            <td>{{$date}}</td>

                            <th width="23%">Paket</th>
                            <td width="2%">:</td>
                            <td>{{$paket->paket}}</td>
                        </tr>
                        <tr>
                            <th width="23%">Status Transaksi</th>
                            <td width="2%">:</td>
                            <td>{{$status_transaksi}}</td>

                            <th width="23%">Trip</th>
                            <td width="2%">:</td>
                            <td>{{$event->judul}}</td>
                        </tr>
                        <tr>
                            <th width="23%">Tanggal Pemberangkatan</th>
                            <td width="2%">:</td>
                            <td>{{$pemberangkatan}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <div class="col-12">
                <b>DETAIL TUJUAN</b>

                <table class="table table-sm table-borderless">
                    <tbody>
                        @foreach ($agenda as $ag)
                            <tr>
                                <td> - </td>
                                <td><span class="font-weight-bold">{{$ag->waktu}}</span></td>
                                <td><h5> {{$ag->nama_tujuan}} - {{$ag->provinsi}}</h5><p>{{$ag->keterangan}}</p></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p>Invoice ini sah di Proses oleh Komputer <br>
                Silahkan hubungi <b class="text-success">Admin</b> apabila membutuhkan bantuan</p>
            </div>
        </div>
    </div>
</body>
</html>