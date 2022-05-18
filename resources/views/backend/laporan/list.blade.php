@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_kunjungan_desa_wisata_'.$tipe_wisata) !!}
@endsection

@section('action')
@if(!empty(\Request::get('waktuTipe')))
    @php
    $uriDownload = \Request::get('download') ? \Request::fullUrl() : \Request::fullUrl()."&download=true"
    @endphp
@else
    @php
    $uriDownload = \Request::get('download') ? \Request::fullUrl() : \Request::fullUrl()."?waktuTipe=harian&waktu=".date('Y-m-d')."&download=true"
    @endphp
@endif
<div class="col s2 m6 l6">
    <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{ $uriDownload }}">
        <span class="hide-on-small-onl">
            Export Excel
        </span><i class="material-icons left">file_download</i>
    </a>
</div>
<!-- <div class="col s2 m6 l6">
    <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right" href="#!" data-target="dropdown1">
    <i class="material-icons hide-on-med-and-up">settings</i><span class="hide-on-small-onl">Aksi</span><i class="material-icons right">arrow_drop_down</i></a>
    <ul class="dropdown-content" id="dropdown1" tabindex="0">
        <li tabindex="0">
            <a class="grey-text text-darken-2" href="{{ route('backend::kunjungan.desa_wisata.create', ['tipe'=>$tipe_wisata]) }}">
                Tambah Data
            </a>
        </li>
        <li class="divider" tabindex="-1"></li>
        <li tabindex="0"><a class="grey-text text-darken-2" href="user-login.html">Logout</a></li>
    </ul>
</div> -->
@endsection

@section('content')

<div class="row">
    <div class="col s12 m12 l12">
        <div id="responsive-table" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">{{ @$page_description }}</h4>
                <p class="mb-2">
                @if (session('success'))
                <div class="card-alert card gradient-45deg-green-teal">
                    <div class="card-content white-text">
                    <p>
                        <i class="material-icons">check</i> {{ session('success') }}</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif

                <form class="col s12" action="{{ route('backend::laporan.index', ['tipe'=>$tipe_wisata]) }}" method="GET">
                    <div class="row">
                        @if(\Auth::user()->hasRole('superadmin'))
                        <div class="input-field col m4 s6">
                            <select name="laporan">
                                <option value="desa"{{ (\Request::get("laporan")=="desa") ? " selected" : "" }}>Pengunjung Desa Wisata</option>
                                <option value="obyek"{{ (\Request::get("laporan")=="obyek") ? " selected" : "" }}>Pengunjung Obyek Wisata</option>
                                <option value="belanja"{{ (\Request::get("laporan")=="belanja") ? " selected" : "" }}>Orang Belanja</option>
                                <option value="menginap"{{ (\Request::get("laporan")=="menginap") ? " selected" : "" }}>Pengunjung Menginap</option>
                            </select>
                        </div>
                        @endif                        
                        <div class="input-field col m2 s12">
                            <select name="waktuTipe" id="waktuTipe">
                                <option value="harian"{{ (\Request::get("waktuTipe")=="harian") ? " selected" : "" }}>Harian</option>
                                <option value="mingguan"{{ (\Request::get("waktuTipe")=="mingguan") ? " selected" : "" }}>Mingguan</option>
                                <option value="bulanan"{{ (\Request::get("waktuTipe")=="bulanan") ? " selected" : "" }}>Bulanan</option>
                                <option value="tahunan"{{ (\Request::get("waktuTipe")=="tahunan") ? " selected" : "" }}>Tahunan</option>
                                <option value="periodik"{{ (\Request::get("waktuTipe")=="periodik") ? " selected" : "" }}>Periodik</option>
                            </select>
                        </div>
                        <div class="input-field col m3 s12" id="chooseWaktu">
                        </div>
                        <div class="input-field col m3 s12">
                            <div class="input-field col s12">
                                <button class="btn cyan waves-effect waves-light" type="submit">
                                <i class="material-icons left">search</i> Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
                </p>
            <div class="row">
                <div class="col s12">
                <table class="responsive-table">
                    <thead>
                    <tr>
                    @if(\Auth::user()->hasRole('superadmin'))
                        @php
                        if(\Request::get('laporan')=='menginap'){
                            $col1 = "Nama Akomodasi";
                            $col4 = "Lama Menginap";
                        }elseif(\Request::get('laporan')=='belanja'){
                            $col1 = "Nama Wisata";
                            $col4 = "Jumlah Wisatawan Belanja";
                        }else{
                            $col1 = "Nama Wisata";
                            $col4 = "Jumlah Wisatawan";
                        }
                        @endphp
                        <th data-field="id" style="width: 20px">#</th>
                        <th data-field="nama">{{$col1}}</th>
                        <th data-field="kecamatan">Kecamatan</th>
                        <th data-field="jumlah">{{$col4}}</th>
                    @elseif(\Auth::user()->hasRole('operator'))
                        <th data-field="id" style="width: 20px">#</th>
                        <th data-field="tgl">Tanggal</th>
                        <th data-field="jumlah">Jumlah Wisatawan</th>
                    @endif
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=1;?>
                    @if(\Auth::user()->hasRole('superadmin'))
                        @if(\Request::get('laporan')=='desa' || \Request::get('laporan')=='obyek' || \Request::get('laporan')=='belanja')
                        @forelse($data as $res)
                            <tr>
                                <td>
                                    {{ $no }}
                                </td>
                                <td>
                                    {{ $res->wisata->nama }}
                                </td>
                                <td>
                                    {{ $res->wisata->kelurahan->kecamatan->nama }}
                                </td>
                                <td>
                                    {{ $res->jumlahna }}
                                </td>
                            </tr>
                            <?php $no++;?>
                            @empty
                            <tr>
                                <td colspan="{{ (\Auth::user()->hasRole('superadmin')) ? '6' : '5'}}">
                                    Tidak ada data.
                                </td>
                            </tr>
                            @endforelse
                        @elseif(\Request::get('laporan')=='menginap')
                            @forelse($data as $res)
                            <tr>
                                <td>
                                    {{ $no }}
                                </td>
                                <td>
                                    {{ $res->akomodasi->nama_pemilik }} - {{ $res->akomodasi->alamat }}
                                </td>
                                <td>
                                    {{ $res->akomodasi->wisata->kelurahan->kecamatan->nama }}
                                </td>
                                <td>
                                    {{ $res->jumlahna }}
                                </td>
                            </tr>
                            <?php $no++;?>
                            @empty
                            <tr>
                                <td colspan="{{ (\Auth::user()->hasRole('superadmin')) ? '6' : '5'}}">
                                    Tidak ada data.
                                </td>
                            </tr>
                            @endforelse
                        @endif
                    @elseif(\Auth::user()->hasRole('operator'))
                        @forelse($data as $res)
                        <tr>
                            <td>
                                {{ $no }}
                            </td>
                            <td>
                                {{ $res->tanggal }}
                            </td>
                            <td>
                                {{ $res->jumlah_wisatawan }}
                            </td>
                        </tr>
                        <?php $no++;?>
                        @empty
                        <tr>
                            <td colspan="{{ (\Auth::user()->hasRole('superadmin')) ? '6' : '5'}}">
                                Tidak ada data.
                            </td>
                        </tr>
                        @endforelse
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function(){

    initRangePick();
    
    $('.dropdown-trigger').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        coverTrigger: false, // Displays dropdown below the button
        alignment: 'left', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
    });

    showForm("{{ \Request::get('waktuTipe') ? \Request::get('waktuTipe') : 'harian' }}");
});

$("select#waktuTipe").change(function(){
    var waktuTipe = $(this).children("option:selected").val();
    showForm(waktuTipe);
});

function showForm(tipe){
    html = '';

    // console.log(tipe)
    if(tipe=="periodik"){
        html += '<input type="text" name="waktu" id="waktuPeriodik" value="{{ \Request::get("waktu") }}" class="form-control form-control-sm"/>';
        $("#chooseWaktu").html(html);
        initRangePick();
    }else if(tipe=="tahunan"){
        html += "<select name='waktu' class='browser-default'>";
                @for($i=2010; $i<=date('Y'); $i++)
        html += "   <option value='{{ $i }}'{{ \Request::get('waktu')==$i ? ' selected' : '' }}>{{ $i }}</option>";
                @endfor
        html += "</select>";
        $("#chooseWaktu").html(html);
    }else if(tipe=="bulanan"){
        html += '<select name="waktuBulan" class="browser-default">';
            html += '<option value="01"{{ \Request::get('waktuBulan')=="01" ? ' selected' : '' }}>Januari</option>';
            html += '<option value="02"{{ \Request::get('waktuBulan')=="02" ? ' selected' : '' }}>Febuari</option>';
            html += '<option value="03"{{ \Request::get('waktuBulan')=="03" ? ' selected' : '' }}>Maret</option>';
            html += '<option value="04"{{ \Request::get('waktuBulan')=="04" ? ' selected' : '' }}>April</option>';
            html += '<option value="05"{{ \Request::get('waktuBulan')=="05" ? ' selected' : '' }}>Mei</option>';
            html += '<option value="06"{{ \Request::get('waktuBulan')=="06" ? ' selected' : '' }}>Juni</option>';
            html += '<option value="07"{{ \Request::get('waktuBulan')=="07" ? ' selected' : '' }}>Juli</option>';
            html += '<option value="08"{{ \Request::get('waktuBulan')=="08" ? ' selected' : '' }}>Agustus</option>';
            html += '<option value="09"{{ \Request::get('waktuBulan')=="09" ? ' selected' : '' }}>September</option>';
            html += '<option value="10"{{ \Request::get('waktuBulan')=="10" ? ' selected' : '' }}>Oktober</option>';
            html += '<option value="11"{{ \Request::get('waktuBulan')=="11" ? ' selected' : '' }}>November</option>';
            html += '<option value="12"{{ \Request::get('waktuBulan')=="12" ? ' selected' : '' }}>Desember</option>';
        html += '</select>';
        html += "<select name='waktuTahun' class='browser-default'>";
                @for($i=2010; $i<=date('Y'); $i++)
        html += "   <option value='{{ $i }}'{{ \Request::get('waktuTahun')==$i ? ' selected' : '' }}>{{ $i }}</option>";
                @endfor
        html += "</select>";
        $("#chooseWaktu").html(html);
    }else if(tipe=="mingguan"){
        html += '<input type="text" name="waktu" id="waktuHarian" value="{{ \Request::get("waktu") ? \Request::get("waktu") : date('Y-m-d') }}" class="validate datepicker"/>';
        $("#chooseWaktu").html(html);
        initDatePick();
    }else if(tipe=="harian"){
        html += '<input type="text" name="waktu" id="waktuHarian" value="{{ \Request::get("waktu") ? \Request::get("waktu") : date('Y-m-d') }}" class="validate datepicker"/>';
        $("#chooseWaktu").html(html);
        initDatePick();
    }
    
}

function clear(){
    $("#chooseWaktu").html("");
}

function initDatePick(){
    $('#waktuHarian').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd"
    });
}

function initRangePick(){
    $('#waktuPeriodik').daterangepicker({
        opens: 'left',
        // startDate: '1997-08-29',
        // endDate: '1997-08-31',
        
        locale: {
            format: 'YYYY/M/DD'
        },
        // ranges: {
        //    'Today': [moment(), moment()],
        //    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //    'This Month': [moment().startOf('month'), moment().endOf('month')],
        //    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        // }
    });
}
</script>
@endpush