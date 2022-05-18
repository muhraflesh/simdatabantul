@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_master_hotel') !!}
@endsection

@section('action')
<div class="col s2 m6 l6">
    <a class="btn dd-settings waves-effect waves-light breadcrumbs-btn right" href="{{ route('backend::master.hotel.create') }}">
        <span class="hide-on-small-onl">
            Tambah Data
        </span><i class="material-icons left">add</i>
    </a>
</div>
<!-- <div class="col s2 m6 l6">
    <a class="btn dd-settings waves-effect waves-light breadcrumbs-btn right" href="#!" data-target="dd-1">
    <i class="material-icons hide-on-med-and-up">settings</i><span class="hide-on-small-onl">Aksi</span><i class="material-icons right">arrow_drop_down</i></a>
    <ul class="dropdown-content" id="dd-1" tabindex="0">
        <li tabindex="0">
            <a class="grey-text text-darken-2" href="{{ route('backend::master.hotel.create') }}">
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
                <form class="col s12" action="{{ route('backend::master.hotel.index') }}" method="GET">
                    <div class="row">
                        <div class="input-field col m4 s6">
                            <input type="text" name="nama" value="{{ \Request::get('nama') }}" class="form-control form-control-sm" placeholder="Nama Hotel" />
                        </div>
                        <div class="input-field col m4 s12">
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
                        <th data-field="id" style="width: 20px">#</th>
                        <th data-field="nama">Nama Hotel</th>
                        <th data-field="jenis">Jenis Hotel</th>
                        <th data-field="pemilik">Pemilik Hotel</th>
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
                                {{ $res->nama_hotel }}
                            </td>
                            <td>
                                {{ ucwords($res->jenis_hotel) }}
                            </td>
                            <td>
                                {{ $res->user->name }}
                            </td>
                            <td>
                                <a class="btn dd-trigger waves-effect gradient-45deg-light-blue-cyan btn-small center" href="#!" data-target="dd{{ $no }}">
                                    <span class="hide-on-small-onl">Aksi</span>
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <ul id='dd{{ $no }}' class='dropdown-content'>
                                    <li><a href="#!" onclick="lihatData('{{ json_encode($res) }}')"><i class="material-icons">remove_red_eye</i>Lihat</a></li>
                                    <li>
                                        <a href="{{ route('backend::master.hotel.edit', ['id' => $res->id]) }}">
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
                            <td colspan="6">
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

function deleteData(id){
    console.log(id);
    dataHtml = "<form method=\"POST\" action=\"{{ url('backend/master/hotel') }}/"+id+"/delete\" accept-charset=\"UTF-8\">";
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
    $('#nama').val(obj.nama_hotel);
    $('#nama_pemilik').val(obj.user.name);
    $('#jenis').val(obj.jenis_hotel);
    $('#alamat').val(obj.alamat_hotel);
    $('#kontak').val(obj.kontak_hotel);
    $('#email').val(obj.email_hotel);
    $('#lihatDetail').modal('open');
  }
</script>

<div id="lihatDetail" class="modal">
    <div class="modal-content">
    <div class="card-content">
          <h4 class="card-title">Hotel</h4>
          <form class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <input id="nama" type="text" readonly disabled placeholder="Nama Hotel">
                <label for="nama">Nama Hotel</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="nama_pemilik" type="text" readonly disabled placeholder="Nama Pemilik Hotel">
                <label for="nama_pemilik">Nama Pemilik Hotel</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="jenis" type="text" readonly disabled placeholder="Jenis Hotel">
                <label for="jenis">Jenis Hotel</label>
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
                <input id="kontak" type="text" readonly disabled placeholder="kontak">
                <label for="kontak">Kontak HP</label>
              </div>
              <div class="input-field col m6 s12">
                <input id="email" type="text" readonly disabled placeholder="email">
                <label for="email">Email</label>
              </div>
            </div>            
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