@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_pengguna') !!}
@endsection

@section('action')
<div class="col s2 m6 l6">
    <a class="btn waves-effect waves-light breadcrumbs-btn right" href="{{ route('backend::pengguna.create') }}">
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
            <a class="grey-text text-darken-2" href="{{ route('backend::pengguna.create') }}">
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
                <form class="col s12" action="{{ route('backend::pengguna.index') }}" method="GET">
                    <div class="row">
                        <div class="input-field col m4 s6">
                            <input type="text" name="nama" value="{{ \Request::get('nama') }}" class="form-control form-control-sm" placeholder="Nama" />
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
                        <th data-field="nama">Nama</th>
                        <th data-field="email">Email / Username</th>
                        <th data-field="role">Role</th>
                        <th data-field="tanggal">Tanggal</th>
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
                                {{ $res->name }}
                            </td>
                            <td>
                                {{ $res->email }} | {{ $res->username }}
                            </td>
                            <td>
                            @foreach($res->roles()->get() as $role)
                                {{ $role->display_name }}
                            @endforeach
                            </td>
                            <!-- <td>
                                @if($res->status)
                                <span class="label label-success text-secondary">Aktif</span>
                                @else
                                <span class="label label-warning text-secondary">Belum Aktif</span>
                                @endif
                            </td> -->
                            <td>
                                {{ $res->created_at->format('Y/m/d') }}
                            </td>
                            <td>
                                <!-- <a class="mb-6 btn waves-effect gradient-45deg-light-blue-cyan btn-small" title="Ubah" href="{{ route('backend::pengguna.edit', ['id' => $res->id]) }}"> 
                                Ubah
                                </a> -->
                                <!-- @if(!$res->status)
                                <button class="mb-6 btn waves-effect gradient-45deg-light-blue-cyan btn-small" title="Aktif" onclick="active('{{ substr($res->id,0,5) }}')"> Aktif
                                    <i class="fa fa-check"></i>
                                </button>
                                @endif -->

                                <a class="btn dropdown-trigger waves-effect gradient-45deg-light-blue-cyan btn-small center" href="#!" data-target="dropdown{{ $no }}">
                                    <span class="hide-on-small-onl">Aksi</span>
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <ul id='dropdown{{ $no }}' class='dropdown-content' style="min-width: 148px !important;">
                                    <!-- <li><a href="#!" onclick="lihatData('{{ json_encode($res) }}')"><i class="material-icons">remove_red_eye</i>Lihat</a></li> -->
                                    <li>
                                        <a href="{{ route('backend::pengguna.edit', ['id' => $res->id]) }}">
                                            <i class="material-icons">edit</i>Ubah
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!" onclick="deleteData('{{ $res->id }}')">
                                            <i class="material-icons">delete</i><small>Hapus</small>
                                        </a>
                                    </li>
                                    @if($res->login_counter >= 5)
                                    <li>
                                        <a href="#!" onclick="bukaBlokir('{{ $res->id }}')">
                                            <i class="material-icons">lock_open</i><small>Buka Blokir</small>
                                        </a>
                                    </li>
                                    @endif
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
    $('#konfirmasiDelete').modal();
    $('#konfirmasiBukaBlokir').modal();
});

function deleteData(id){
    console.log(id);
    dataHtml = "<form method=\"POST\" action=\"{{ url('backend/pengguna') }}/"+id+"/delete\" accept-charset=\"UTF-8\">";
    dataHtml += "   <input name=\"_method\" type=\"hidden\" value=\"DELETE\">";
    dataHtml += '   {{ csrf_field() }}';
    dataHtml += "   <input type=\"submit\" class=\"btn btn-sm btn-danger\" value=\"Hapus\">";
    dataHtml += "   <a href=\"#!\" class=\"modal-action modal-close waves-effect waves-green btn-flat\">Tutup</a>";
    dataHtml += "</form>";

    $('#tombol').html(dataHtml);
    $('#konfirmasiDelete').modal('open');
}

function bukaBlokir(id){
    // console.log(id);
    dataHtml = "<form method=\"POST\" action=\"{{ url('backend/pengguna') }}/"+id+"/bukablokir\" accept-charset=\"UTF-8\">";
    dataHtml += "   <input name=\"_method\" type=\"hidden\" value=\"POST\">";
    dataHtml += '   {{ csrf_field() }}';
    dataHtml += "   <input type=\"submit\" class=\"btn btn-sm btn-danger\" value=\"Buka Status Blokir\">";
    dataHtml += "   <a href=\"#!\" class=\"modal-action modal-close waves-effect waves-green btn-flat\">Tutup</a>";
    dataHtml += "</form>";

    $('#tombolBukaBlokir').html(dataHtml);
    $('#konfirmasiBukaBlokir').modal('open');
}
</script>

<div id="konfirmasiDelete" class="modal">
    <div class="modal-content">
        <h4>Konfirmasi</h4>
        <p>Apakah data ini benar akan dihapus?</p>
    </div>
    <div class="modal-footer">
        <div id="tombol"></div>
    </div>
</div>

<div id="konfirmasiBukaBlokir" class="modal">
    <div class="modal-content">
        <h4>Konfirmasi</h4>
        <p>Apakah user ini benar akan dibuka status blokirnya?</p>
    </div>
    <div class="modal-footer">
        <div id="tombolBukaBlokir"></div>
    </div>
</div>
@endpush