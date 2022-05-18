@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_pengelola_obyek_wisata') !!}
@endsection

@section('action')
<div class="col s2 m6 l6">
    <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{ route('backend::pengguna.create') }}?tipe=obyek_wisata">
        <span class="hide-on-small-onl">
            Tambah Data
        </span><i class="material-icons left">add</i>
    </a>
</div>
<!-- <div class="col s2 m6 l6">
    <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right" href="#!" data-target="dropdown1">
    <i class="material-icons hide-on-med-and-up">settings</i><span class="hide-on-small-onl">Aksi</span><i class="material-icons right">arrow_drop_down</i></a>
    <ul class="dropdown-content" id="dropdown1" tabindex="0">
        <li tabindex="0">
            <a class="grey-text text-darken-2" href="{{ route('backend::pengelola.obyek_wisata.create') }}">
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
                <form class="col s12" action="{{ route('backend::pengelola.obyek_wisata.index') }}" method="GET">
                    <div class="row">
                        <div class="input-field col m4 s6">
                            <input type="text" name="nama" value="{{ \Request::get('nama') }}" class="form-control form-control-sm" placeholder="Nama Wisata" />
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
                        <th data-field="nama">Nama Pengelola</th>
                        <th data-field="nohp">No HP</th>
                        <th data-field="email">Email</th>
                        <th data-field="obyek_wisata">Obyek Wisata</th>
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
                                {{ $res->user->name }}
                            </td>
                            <td>
                                {{ $res->user->no_hp }}
                            </td>
                            <td>
                                {{ $res->user->email }}
                            </td>
                            <td>
                                {{ $res->wisata->nama }}
                            </td>
                            <td>
                                <a class="btn waves-effect gradient-45deg-light-blue-cyan btn-small center" href="#!" onclick="lihatData('{{ json_encode($res) }}')">
                                    <span class="hide-on-small-onl">Lihat</span>
                                    <i class="material-icons left">remove_red_eye</i>
                                </a>
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
    $('#zoomFoto').modal();
    $('#lihatDetail').modal();
    $('#konfirmasiDelete').modal();
    // $('.dropdown-trigger').dropdown({
    //     inDuration: 300,
    //     outDuration: 225,
    //     constrainWidth: false, // Does not change width of dropdown to that of the activator
    //     hover: false, // Activate on hover
    //     gutter: 0, // Spacing from edge
    //     coverTrigger: false, // Displays dropdown below the button
    //     alignment: 'left', // Displays dropdown with edge aligned to the left of button
    //     stopPropagation: false // Stops event propagation
    // });
});

function zoomFoto(url){
    // console.log(url);
    $('#zoomFoto').modal('open');
    $('#srcZoomFoto').attr('src', url);
}

function deleteData(id){
    console.log(id);
    dataHtml = "<form method=\"POST\" action=\"{{ url('backend/master/obyek_wisata') }}/"+id+"/delete\" accept-charset=\"UTF-8\">";
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
    $('#nama').val(obj.user.name);
    $('#wisata').val(obj.wisata.nama);
    $('#alamat_wisata').val(obj.wisata.alamat);
    $('#no_hp').val(obj.user.no_hp);
    $('#email').val(obj.user.email);
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
          <h4 class="card-title">Informasi Pengelola Obyek Wisata</h4>
          <form class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <input id="nama" type="text" readonly disabled placeholder="Nama Pengelola">
                <label for="nama">Nama Pengelola</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea id="wisata" style="height: 45px;" class="materialize-textarea" readonly disabled placeholder="Nama Wisata"></textarea>
                <label for="wisata">Nama Wisata</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea id="alamat_wisata" style="height: 45px;" class="materialize-textarea" readonly disabled placeholder="Alamat Wisata"></textarea>
                <label for="alamat_wisata">Alamat Wisata</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col m6 s12">
                <input id="no_hp" type="text" readonly disabled placeholder="No HP">
                <label for="no_hp">No HP</label>
              </div>
              <div class="input-field col m6 s12">
                <input id="email" type="text" readonly disabled placeholder="Email">
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