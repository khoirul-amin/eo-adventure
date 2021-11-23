@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Gigs</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">View Gigs</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    @if ($banner_event->first())
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                            @php
                                $id=0;
                            @endphp
                            @foreach ($banner_event as $item)
                                @if ($id == 0)
                                    <div class="carousel-item active">
                                        <img src="{{$item->images}}" class="d-block w-100" alt="...">
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        <img src="{{$item->images}}" class="d-block w-100" alt="...">
                                    </div>
                                @endif
                            @php
                                $id++;
                            @endphp
                            @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-3 ml-3">
                    <h2>{{$event->judul}}</h2>
                    <b>Harga Mulai Dari </b>
                    <h3 class="mt-3">Rp {{number_format($event->biaya,0,',','.')}}</h3>
                    <hr/>
                    
                    <p><b>Kuota Maksimum:</b> {{$event->kuota}} Orang</p>
                    <p><b>Tansportasi :</b> {{$transportasi->transportasi}} - Muatan Max {{$transportasi->muatan}} Orang</p>
                    <p><b>Kategori :</b> {{$event->kategori}}</p>
                </div>
                <div class="col text-center">
                    <a href="/event" class="btn btn-danger">Back</a>
                </div>
            </div>

            <div class="row" style="margin-top:50px;">
                <div class="col-12">
                    <ul class="nav  nav-pills justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Harga Paket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Rencana Perjalanan</a>
                        </li>
                    </ul>
                    <hr>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h4 class="mb-3"><b>Deskripsi</b></h4>
                                <p style="text-align: justify;">
                                    @if ($keterangan)
                                        {{$keterangan->keterangan}}
                                    @endif
                                    
                                </p>
                                @if ($perlengkapan->first())
                                    <h5 class="mt-3 font-weight-bold">Perlengkapan</h5>
                                    @foreach ($perlengkapan as $perl)
                                        - {{$perl->keterangan}} <br/>
                                    @endforeach
                                @endif
                                @if ($fasilitas->first())
                                    <h5 class="mt-3 font-weight-bold">Fasilitas</h5>
                                    @foreach ($fasilitas as $fas)
                                        - {{$fas->keterangan}} <br/>
                                    @endforeach
                                @endif
                                @if ($tidaktermasuk->first())
                                    <h5 class="mt-3 font-weight-bold">Tidak Termasuk</h5>
                                    @foreach ($tidaktermasuk as $tid)
                                        - {{$tid->keterangan}} <br/>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h4 class="mb-3"><b>Paket Harga</b></h4>
                                
                                <table class="table table-sm" id="table-paket">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Paket</th>
                                            <th scope="col">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no_paket = 1;
                                        @endphp
                                        @foreach ($paket as $paket_harga)
                                            <tr>
                                                <td>{{$no_paket}}</td>
                                                <td>{{$paket_harga->paket}}</td>
                                                <td> Rp   {{number_format($paket_harga->harga,0,',','.')}}</td>
                                            </tr>
                                            @php
                                                $no_paket++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h4 class="mb-3"><b>Agenda Kegiatan</b></h4>
                                
                                <table class="table table-sm" id="table-paket">
                                    <tbody>
                                        @foreach ($agenda as $ag)
                                            <tr>
                                                <td> - </td>
                                                <td><span class="font-weight-bold">{{$ag->waktu}}</span></td>
                                                <td><h5><i class="fas fa-map-marker-alt"></i> {{$ag->nama_tujuan}} - {{$ag->provinsi}}</h5><p>{{$ag->keterangan}}</p></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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
@endpush

@push('scripts')
@endpush