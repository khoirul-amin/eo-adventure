<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
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
                <p class="text-right mb-0"><b>Data</b><br>
                <span class="text-success">Laporan Transaksi</span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <th width="10%">No</th>
                            <th width="23%">Invoice</th>
                            <th width="23%">Pemesan</th>
                            <th width="23%">Tanggal</th>
                            <th width="23%">Status Transaksi</th>
                        </tr>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $data)
                        @php
                            $date=date_create($data->dadeline_pembayaran);
                            $status_transaksi = "";
                            if($data->status_transaksi == 1){
                                $status_transaksi = "Disetujui";
                            }elseif($data->status_transaksi == 2){
                                $status_transaksi = "Ditolak";
                            }elseif($data->status_transaksi == 3){
                                $status_transaksi = "Menunggu";
                            }elseif($data->status_transaksi == 4){
                                $status_transaksi = "Dibatalkan";
                            }
                        @endphp
                            <tr>
                                <td width="10%">{{$no}}</td>
                                <td width="23%">{{$data->invoice}}</td>
                                <td width="23%">{{$data->name}}</td>
                                <td width="23%">{{date_format($date,"d-M-Y H:i:s")}}</td>
                                <td width="23%">{{$status_transaksi}}</td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
    </div>
</body>
</html>