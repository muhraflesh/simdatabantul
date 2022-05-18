@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_laporan') !!}
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

                <form class="col s12" action="{{ route('backend::laporan.desa') }}" method="GET">
                    <div class="row">                     
                        <div class="input-field col m2 s12">
                            <select name="waktuTipe" id="waktuTipe" class="browser-default">
                                <option value="harian"{{ (\Request::get("waktuTipe")=="harian") ? " selected" : "" }}>Harian</option>
                                <option value="mingguan"{{ (\Request::get("waktuTipe")=="mingguan") ? " selected" : "" }}>Mingguan</option>
                                <option value="bulanan"{{ (\Request::get("waktuTipe")=="bulanan") ? " selected" : "" }}>Bulanan</option>
                                <option value="tahunan"{{ (\Request::get("waktuTipe")=="tahunan") ? " selected" : "" }}>Tahunan</option>
                                <!-- <option value="periodik"{{ (\Request::get("waktuTipe")=="periodik") ? " selected" : "" }}>Periodik</option> -->
                            </select>
                        </div>
                        <div class="input-field col m3 s12" id="chooseWaktu">
                        </div>
                        <!-- <div class="input-field col m2 s12">
                            <label>
                                <input type="checkbox" name="cbLama" id="cbLama" onchange="lamaNginap()"/>
                                <span>Lama Menginap</span>
                            </label>
                        </div>
                        <div class="input-field col m1 s12" id="lamaMenginap"></div> -->
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
                <div class="col s12 tb">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            @if(\Auth::user()->hasRole('superadmin'))
                            <!-- <th data-field="id" style="width: 20px" rowspan="2">No</th> -->
                            <th data-field="nama" rowspan="2">Desa Wisata</th>
                            @endif
                            <th data-field="wisatawan" rowspan="2">Wisatawan</th>
                            @if(\Request::get("waktuTipe")=="harian" || \Request::get("waktuTipe")=="")
                            <th data-field="hari" style="text: center;" colspan="12">Tanggal</th>
                            @elseif(\Request::get("waktuTipe")=="mingguan")
                            <th data-field="tanggal" style="text: center;" colspan="12">Minggu Ke</th>
                            @elseif(\Request::get("waktuTipe")=="bulanan")
                            <th data-field="tanggal" style="text: center;" colspan="12">Tanggal</th>
                            @elseif(\Request::get("waktuTipe")=="tahunan")
                            <th data-field="bulan" style="text: center;" colspan="12">Bulan</th>
                            @endif
                        </tr>
                        <tr>
                            @if(\Request::get("waktuTipe")=="harian" || \Request::get("waktuTipe")=="")
                            <th>{{ \Carbon\Carbon::parse(\Request::get("waktu"))->format('d-M-y') }}</th>
                            @elseif(\Request::get("waktuTipe")=="mingguan")
                                @php
                                $firstDate = \Request::get("waktuTahun")."-".\Request::get("waktuBulan")."-01";
                                $lastDate = date('Y-m-t', strtotime($firstDate));
                                $weekNumber = App\Utils\LaporanDownload\DesaWisata::weekOfMonth($lastDate);
                                @endphp
                                @for($iWeek=1;$iWeek<=$weekNumber;$iWeek++)
                                <th>{{ $iWeek }}</th>
                                @endfor
                            @elseif(\Request::get("waktuTipe")=="bulanan")
                                @php
                                $a_date = \Request::get("waktuTahun")."-".\Request::get("waktuBulan")."-01";
                                @endphp
                                @for($iDay=1;$iDay<=date('t', strtotime($a_date));$iDay++)
                                <th>{{ $iDay }}</th>
                                @endfor
                            @elseif(\Request::get("waktuTipe")=="tahunan")
                            <th>01</th>
                            <th>02</th>
                            <th>03</th>
                            <th>04</th>
                            <th>05</th>
                            <th>06</th>
                            <th>07</th>
                            <th>08</th>
                            <th>09</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1;?>
                    @forelse($data as $res)
                    <tr>
                        @if(\Auth::user()->hasRole('superadmin'))
                        <!-- <td rowspan="3">
                            {{ $no }}
                        </td> -->
                        <td rowspan="3">
                            {{ $res->wisata->nama }}
                        </td>
                        @endif
                        <td>
                            Wisman
                        </td>
                        @php
                        $tipe = \Request::get('waktuTipe') ? \Request::get('waktuTipe') : 'harian';
                        if(!empty(\Request::get('waktuBulan'))){
                            $waktu = \Request::get('waktuBulan')."|".\Request::get('waktuTahun');
                        }else{
                            $waktu = \Request::get('waktu') ? \Request::get('waktu') : date('Y-m-d');
                        }
                        $wisatawan = App\Utils\LaporanDownload\DesaWisata::getStatistikDesaWisata($res->wisata_id, $tipe, $waktu);                        
                        @endphp
                        @foreach($wisatawan['mancanegara'] as $wm)
                        <td>{{ $wm }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>
                            Wisnus
                        </td>
                        @foreach($wisatawan['nusantara'] as $wn)
                        <td>{{ $wn }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>
                            Jumlah
                        </td>
                        @if(\Request::get("waktuTipe")=="harian" || \Request::get("waktuTipe")=="")
                        <td>{{ $wisatawan['mancanegara'][0]+$wisatawan['nusantara'][0] }}</td>
                        @elseif(\Request::get("waktuTipe")=="mingguan")
                        @for($i=0;$i<$weekNumber;$i++)
                        <td>{{ $wisatawan['mancanegara'][$i]+$wisatawan['nusantara'][$i] }}</td>
                        @endfor
                        @elseif(\Request::get("waktuTipe")=="bulanan")
                        @for($i=0;$i<date('t', strtotime($a_date));$i++)
                        <td>{{ $wisatawan['mancanegara'][$i]+$wisatawan['nusantara'][$i] }}</td>
                        @endfor
                        @elseif(\Request::get("waktuTipe")=="tahunan")
                        @for($i=0;$i<12;$i++)
                        <td>{{ $wisatawan['mancanegara'][$i]+$wisatawan['nusantara'][$i] }}</td>
                        @endfor
                        @endif
                    </tr>
                    <?php $no++;?>
                    @empty
                    <tr>
                        <td colspan="{{ (\Auth::user()->hasRole('superadmin')) ? '16' : '14'}}">
                            Tidak ada data.
                        </td>
                    </tr>
                    @endforelse
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
<style>
.tb{
    width: 500px;
    overflow-x: scroll;
    margin-left: 5em;
    overflow-y: visible;
    padding: 0;
}
</style>
@endpush

@push('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function(){

    initRangePick();
    // change cbx
    // $('#cbLama').prop('checked', true);
    
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
        // html += '<input type="text" name="waktu" id="waktuHarian" value="{{ \Request::get("waktu") ? \Request::get("waktu") : date('Y-m-d') }}" class="validate datepicker"/>';
        // $("#chooseWaktu").html(html);
        // initDatePick();
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

function lamaNginap(){
    var cek = $('#cbLama').is(":checked");

    // $('#cbLama').prop('checked', true);
    if(cek){
        html = '<input type="number" name="lama" value="1"/>';
    }else{
        html = '';
    }

    $("#lamaMenginap").html(html);
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