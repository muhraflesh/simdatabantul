@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_master_akomodasi') !!}
@endsection

@section('action')
<div class="col s2 m6 l6">
    <a class="btn dd-settings waves-effect waves-light breadcrumbs-btn right" href="{{ route('backend::master.akomodasi.create') }}">
        <span class="hide-on-small-onl">
            Tambah Data
        </span><i class="material-icons left">add</i>
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

                @if(\Auth::user()->hasRole('superadmin'))
                <form class="col s12" action="{{ route('backend::master.akomodasi.index') }}" method="GET">
                    <div class="row">
                        <div class="input-field col m4 s6">
                            <input type="text" name="nama" value="{{ \Request::get('nama') }}" class="form-control form-control-sm" placeholder="Nama Pemilik" />
                        </div>
                        <div class="input-field col m4 s12">
                            <div class="input-field col s12">
                                <button class="btn cyan waves-effect waves-light" type="submit">
                                <i class="material-icons left">search</i> Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
                </p>
                <div class="row">
                    <div class="col s12">
                    <table class="responsive-table">
                        <thead>
                        <tr>
                            <th data-field="id" style="width: 20px">#</th>
                            <th data-field="namah">Nama Homestay</th>
                            <th data-field="nama">Nama Pemilik</th>
                            <th data-field="kontak">Kontak</th>
                            <th data-field="jml_kamar">Jumlah Kamar</th>
                            <th data-field="harga_kamar">Harga Kamar</th>
                            @if(\Auth::user()->hasRole('superadmin'))
                            <th data-field="desa">Desa Wisata</th>
                            @endif
                            <th data-field="aksi">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1;?>
                            @forelse($data as $res)
                            <tr>
                                <td>
                                    {{ $no }}
                                </td>
                                <td>
                                    {{ $res->nama_akomodasi }}
                                </td>
                                <td>
                                    {{ $res->nama_pemilik }}
                                </td>
                                <td>
                                    {{ $res->kontak }}
                                </td>
                                <td>
                                    {{ $res->jumlah_kamar }}
                                </td>
                                <td>
                                    {{ $res->harga_kamar }}
                                </td>
                                @if(\Auth::user()->hasRole('superadmin'))
                                <td>
                                    {{ $res->wisata->nama }}
                                </td>
                                @endif
                                <td>
                                    <a class="btn dd-trigger waves-effect gradient-45deg-light-blue-cyan btn-small center" href="#!" data-target="dd{{ $no }}">
                                        <span class="hide-on-small-onl">Aksi</span>
                                        <i class="material-icons right">arrow_drop_down</i>
                                    </a>
                                    <ul id='dd{{ $no }}' class='dropdown-content'>
                                        <li><a href="#!" onclick="lihatData('{{ json_encode($res) }}')"><i class="material-icons">remove_red_eye</i>Lihat</a></li>
                                        <li>
                                            <a href="{{ route('backend::master.akomodasi.edit', ['id' => $res->id]) }}">
                                                <i class="material-icons">edit</i>Ubah
                                            </a>
                                        </li>
                                        <li><a href="#!" onclick="deleteData('{{ $res->id }}')"><i class="material-icons">delete</i>Hapus</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <?php $no++;?>
                            @empty
                            <tr>
                                <td colspan="{{ (\Auth::user()->hasRole('superadmin')) ? '8' : '7'}}">
                                    Tidak ada data.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center-align">
                        {{ $data->links("pagination::materializecss") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('#zoomFoto').modal();
    $('#lihatDetail').modal();
    $('#konfirmasiDelete').modal();
    $('.dd-trigger').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        coverTrigger: false, // Displays dropdown below the button
        alignment: 'left', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
    });
});

function zoomFoto(url){
    // console.log(url);
    $('#zoomFoto').modal('open');
    $('#srcZoomFoto').attr('src', url);
}

function deleteData(id){
    console.log(id);
    dataHtml = "<form method=\"POST\" action=\"{{ url('backend/master/akomodasi') }}/"+id+"/delete\" accept-charset=\"UTF-8\">";
    dataHtml += "   <input name=\"_method\" type=\"hidden\" value=\"DELETE\">";
    dataHtml += '   {{ csrf_field() }}';
    dataHtml += "   <input type=\"submit\" class=\"btn btn-sm btn-danger\" value=\"Hapus\">";
    dataHtml += "   <a href=\"#!\" class=\"modal-action modal-close waves-effect waves-green btn-flat\">Tutup</a>";
    dataHtml += "</form>";

    $('#tombol').html(dataHtml);
    $('#konfirmasiDelete').modal('open');
}

  function lihatData(data){
    var obj = JSON.parse(data);
    console.log(obj);
    $('#nama_akomodasi').val(obj.nama_akomodasi);
    $('#nama_pemilik').val(obj.nama_pemilik);
    $('#alamat').val(obj.alamat);
    $('#kontak').val(obj.kontak);
    $('#jumlah_kamar').val(obj.jumlah_kamar);
    $('#harga_kamar').val(obj.harga_kamar);
    @if(\Auth::user()->hasRole('superadmin'))
    $('#desa_wisata').val(obj.wisata.nama);
    @endif
    $('#lihatDetail').modal('open');
  }
</script>
<div id="zoomFoto" class="modal">
    <div class="modal-content">
        <img src="{{ asset('uploads/default.jpg') }}" id="srcZoomFoto" width="100%" />
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
    </div>
</div>

<div id="lihatDetail" class="modal">
    <div class="modal-content">
    <div class="card-content">
          <h4 class="card-title">Akomodasi</h4>
          <form class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <input id="nama_akomodasi" type="text" readonly disabled placeholder="Nama Homestay">
                <label for="nama">Nama Homestay</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="nama_pemilik" type="text" readonly disabled placeholder="Nama Pemilik">
                <label for="nama">Nama Pemilik</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea id="alamat" style="height: 45px;" class="materialize-textarea" readonly disabled placeholder="Alamat"></textarea>
                <label for="alamat">Alamat</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col m6 s12">
                <input id="kontak" type="text" readonly disabled placeholder="Kontak">
                <label for="kontak">Kontak</label>
              </div>
              <div class="input-field col m6 s12">
                <input id="jumlah_kamar" type="text" readonly disabled placeholder="Jumlah Kamar">
                <label for="jumlah_kamar">Jumlah Kamar</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col m12 s12">
                <input id="harga_kamar" type="text" readonly disabled placeholder="0">
                <label for="harga_kamar">Harga Kamar</label>
              </div>
            </div>
            @if(\Auth::user()->hasRole('superadmin'))
            <div class="row">
              <div class="input-field col m12 s12">
                <input id="desa_wisata" type="text" readonly disabled placeholder="Desa Wisata">
                <label for="desa_wisata">Desa Wisata</label>
              </div>
            </div>
            @endif    
          </form>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
    </div>
</div>

<div id="konfirmasiDelete" class="modal">
    <div class="modal-content">
        <h4>Konfirmasi</h4>
        <p>Apakah data ini benar akan dihapus?</p>
    </div>
    <div class="modal-footer">
        <div id="tombol"></div>
    </div>
</div>
@endpush