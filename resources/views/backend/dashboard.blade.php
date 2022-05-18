@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('dashboard') !!}
@endsection

@section('content')
    <div class="card">
        <div class="card-content">
            @if (session('warning'))
            <div class="card-alert card gradient-45deg-amber-amber">
                <div class="card-content white-text">
                <p>
                    <i class="material-icons">warning</i> {{ session('warning') }}</p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            <p class="caption mb-0">
                Welcome {{ Auth::user()->name }}
            </p>

            @if(Auth::user()->hasRole('superadmin'))
            <div id="card-stats">
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="card animate fadeLeft">
                            <div class="card-content cyan white-text">
                            <p class="card-stats-title"><i class="material-icons">directions</i> Obyek Wisata</p>
                            <h4 class="card-stats-number white-text">{{ count(\App\Wisata::where('tipe_wisata', 'obyek')->whereNull('deleted_at')->get()) }}</h4>
                            <!-- <p class="card-stats-compare">
                                <i class="material-icons">keyboard_arrow_up</i> 15%
                                <span class="cyan text text-lighten-5">from yesterday</span>
                            </p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card animate fadeLeft">
                            <div class="card-content red accent-2 white-text">
                            <p class="card-stats-title"><i class="material-icons">directions</i> Desa Wisata</p>
                            <h4 class="card-stats-number white-text">{{ count(\App\Wisata::where('tipe_wisata', 'desa')->whereNull('deleted_at')->get()) }}</h4>
                            <!-- <p class="card-stats-compare">
                                <i class="material-icons">keyboard_arrow_up</i> 70% <span class="red-text text-lighten-5">last month</span>
                            </p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card animate fadeRight">
                            <div class="card-content orange lighten-1 white-text">
                            <p class="card-stats-title"><i class="material-icons">hotel</i> Homestay</p>
                            <h4 class="card-stats-number white-text">{{ count(\App\Akomodasi::whereNull('deleted_at')->get()) }}</h4>
                            <!-- <p class="card-stats-compare">
                                <i class="material-icons">keyboard_arrow_up</i> 80%
                                <span class="orange-text text-lighten-5">from yesterday</span>
                            </p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card animate fadeRight">
                            <div class="card-content green lighten-1 white-text">
                            <p class="card-stats-title"><i class="material-icons">hotel</i> Hotel</p>
                            <h4 class="card-stats-number white-text">{{ count(\App\Akomodasi::whereNull('deleted_at')->get()) }}</h4>
                            <!-- <p class="card-stats-compare">
                                <i class="material-icons">keyboard_arrow_up</i> 80%
                                <span class="orange-text text-lighten-5">from yesterday</span>
                            </p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul id="subkatakomodasi" class="collection z-depth-1 animate fadeLeft">
                <li class="collection-item avatar">
                    <i class="material-icons green circle">hotel</i>
                    <h6 class="collection-header m-0">Hotel</h6>
                    <p>Statistik Jenis Jenis Hotel</p>
                </li>
                <li class="collection-item">
                @php
                $jmlHotelBintang = count(\App\Hotel::where('jenis_hotel', 'bintang')->whereNull('deleted_at')->get());
                $jmlHotelNonBintang = count(\App\Hotel::where('jenis_hotel', 'nonbintang')->whereNull('deleted_at')->get());
                @endphp
                <div id="card-stats">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">hotel</i> Hotel Bintang</p>
                                <h4 class="card-stats-number white-text">{{ $jmlHotelBintang }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">hotel</i> Hotel Non Bintang</p>
                                <h4 class="card-stats-number white-text">{{ $jmlHotelNonBintang }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </li>
            </ul>
            
            <ul id="menginapLama" class="collection z-depth-1 animate fadeLeft">
                <li class="collection-item avatar">
                    <i class="material-icons orange circle">hotel</i>
                    <h6 class="collection-header m-0">Homestay Paling Lama di Inap</h6>
                    <p>Daftar home stay yang paling lama di pakai pewisata</p>
                </li>
                @php
                $wisataDesa = \App\Menginap::selectRaw('*, SUM(lama_menginap) as lm')->groupBy('akomodasi_id')->orderByRaw('SUM(lama_menginap) DESC')->limit(5)->get();
                @endphp
                @foreach($wisataDesa as $wk)
                <li class="collection-item">
                    <div class="row">
                        <div class="col s12">
                            <p class="collections-title">{{ $wk->akomodasi->nama_pemilik }} ({{ $wk->akomodasi->kontak }}) - {{ $wk->akomodasi->alamat }}</p>
                            <p class="collections-content">{{ $wk->lm }} Hari</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            
            <ul id="belanja" class="collection z-depth-1 animate fadeLeft">
                <li class="collection-item avatar">
                    <i class="material-icons green circle">shopping_basket</i>
                    <h6 class="collection-header m-0">Belanja Wisata Terbanyak</h6>
                    <p>Daftar wisatawan yang berbelanja terbanyak</p>
                </li>
                @php
                $wisataDesa = \App\Belanja::selectRaw('*, SUM(jumlah_orang) as jo')
                ->groupBy('wisata_id')->orderByRaw('SUM(jumlah_orang) DESC')
                ->limit(5)->get();
                @endphp
                @foreach($wisataDesa as $wk)
                <li class="collection-item">
                    <div class="row">
                        <div class="col s12">
                            <p class="collections-title">{{ $wk->wisata->nama }}</p>
                            <p class="collections-content">{{ $wk->jo }} Orang</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif

            @if(Auth::user()->hasRole('operator'))
            <ul id="subkatakomodasi" class="collection z-depth-1 animate fadeLeft">
                <li class="collection-item avatar">
                    <i class="material-icons green circle">directions</i>
                    <h6 class="collection-header m-0">Wisata</h6>
                    <p>Statistik Pengunjung 
                    @if(\Auth::user()->pengelola[0]->wisata->tipe_wisata=='desa')
                    dan Lama Menginap Homestay 
                    @endif
                    Selama Tahun {{ date('Y') }}</p>
                </li>
                <li class="collection-item">
                @php
                $tp = \App\WisataKunjungan::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
                ->selectRaw('*, SUM(jumlah_wisatawan) as totalpengunjung')
                ->whereYear('tanggal', date('Y'))
                ->whereNull('deleted_at')
                ->first();
                
                if(\Auth::user()->pengelola[0]->wisata->tipe_wisata=='desa') {
                    $lm = \App\Menginap::whereHas('akomodasi', function($query){
                        $query->where('wisata_id', \Auth::user()->pengelola[0]->wisata_id);
                    })
                    ->selectRaw('*, SUM(lama_menginap) as lamamenginap')
                    ->whereYear('tanggal', date('Y'))
                    ->whereNull('deleted_at')
                    ->first();
                }
                @endphp
                <div id="card-stats">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">hotel</i> Total Pengunjung</p>
                                <h4 class="card-stats-number white-text">{{ (!empty($tp->totalpengunjung)) ? $tp->totalpengunjung : 0 }} Orang</h4>
                                </div>
                            </div>
                        </div>
                        @if(\Auth::user()->pengelola[0]->wisata->tipe_wisata=='desa')
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">hotel</i> Total Lama Menginap Homestay</p>
                                <h4 class="card-stats-number white-text">{{ (!empty($lm->lamamenginap)) ? $lm->lamamenginap : 0 }} Hari</h4>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                </li>
            </ul>
            
            @if(\Auth::user()->pengelola[0]->wisata->tipe_wisata=='desa')
            <ul id="subkatakomodasi" class="collection z-depth-1 animate fadeLeft">
                <li class="collection-item avatar">
                    <i class="material-icons green circle">shopping_basket</i>
                    <h6 class="collection-header m-0">Belanja Per Kategori</h6>
                    <p>Statistik Jumlah Belanja Per Kategori Selama Tahun {{ date('Y') }}</p>
                </li>
                <li class="collection-item">
                @php
                $kuliner = \App\Belanja::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
                ->selectRaw('*, SUM(jumlah_orang) as jumlahorang')
                ->where('kategori_belanja', 'kuliner')
                ->whereYear('tanggal', date('Y'))
                ->whereNull('deleted_at')
                ->first();

                $transportasi = \App\Belanja::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
                ->selectRaw('*, SUM(jumlah_orang) as jumlahorang')
                ->where('kategori_belanja', 'transportasi')
                ->whereYear('tanggal', date('Y'))
                ->whereNull('deleted_at')
                ->first();

                $oleholeh = \App\Belanja::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
                ->selectRaw('*, SUM(jumlah_orang) as jumlahorang')
                ->where('kategori_belanja', 'oleholeh')
                ->whereYear('tanggal', date('Y'))
                ->whereNull('deleted_at')
                ->first();

                $paketwisata = \App\Belanja::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
                ->selectRaw('*, SUM(jumlah_orang) as jumlahorang')
                ->where('kategori_belanja', 'paketwisata')
                ->whereYear('tanggal', date('Y'))
                ->whereNull('deleted_at')
                ->first();
                @endphp
                <div id="card-stats">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">favorite</i> Kuliner</p>
                                <h4 class="card-stats-number white-text">{{ (!empty($kuliner->jumlahorang)) ? $kuliner->jumlahorang : 0 }} Orang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">directions_car</i> Transportasi</p>
                                <h4 class="card-stats-number white-text">{{ (!empty($transportasi->jumlahorang)) ? $transportasi->jumlahorang : 0 }} Orang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">card_giftcard</i> Oleh-Oleh</p>
                                <h4 class="card-stats-number white-text">{{ (!empty($oleholeh->jumlahorang)) ? $oleholeh->jumlahorang : 0 }} Orang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="card animate fadeLeft">
                                <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">card_travel</i> Paket Wisata</p>
                                <h4 class="card-stats-number white-text">{{ (!empty($paketwisata->jumlahorang)) ? $paketwisata->jumlahorang : 0 }} Orang</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </li>
            </ul>
            @endif
            @endif

            @if(Auth::user()->hasRole('operator_hotel'))
            <ul id="subkatakomodasi" class="collection z-depth-1 animate fadeLeft">
                <li class="collection-item avatar">
                    <i class="material-icons green circle">hotel</i>
                    <h6 class="collection-header m-0">Hotel</h6>
                    <p>Statistik Lama & Jumlah Penginap Hotel Selama Tahun {{ date('Y') }}</p>
                </li>
                <li class="collection-item">
                    
                </li>
            </ul>
            @endif
            
        </div>
    </div>
@endsection

@push('style')
<style>
.collection .collection-item.avatar {
    min-height: 0;
}
</style>
@endpush