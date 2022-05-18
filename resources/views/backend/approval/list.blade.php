@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_approval') !!}
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
                <form class="col s12" action="{{ route('backend::approval.index') }}" method="GET">
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
                        <th data-field="nama">Nama Destinasi</th>
                        <th data-field="email">Alamat</th>
                        <th data-field="role">Tipe Destinasi</th>
                        <th data-field="tanggal">Tanggal Pengajuan</th>
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
                                @if($res->nama_hotel)
                                    {{ $res->nama_hotel }}
                                @else
                                    {{ $res->nama }}
                                @endif
                            </td>
                            <td>
                                @if($res->nama_hotel)
                                    {{ $res->alamat_hotel }}
                                @else
                                    {{ $res->alamat }}
                                @endif
                            </td>
                            <td>
                                @if($res->nama_hotel)
                                    Hotel
                                @else
                                    @if($res->tipe_wisata == 'obyek')
                                        Obyek Wisata
                                    @else
                                        Desa Wisata
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{ $res->tanggal_pengajuan }}
                            </td>
                            <td>
                                <a class="btn dropdown-trigger waves-effect gradient-45deg-light-blue-cyan btn-small center" href="#!" data-target="dropdown{{ $no }}">
                                    <span class="hide-on-small-onl">Aksi</span>
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <ul id='dropdown{{ $no }}' class='dropdown-content'>
                                    <li>
                                        <a href="{{ route('backend::approval.edit', ['id' => $res->id_pengajuan]) }}">
                                            <i class="material-icons">remove_red_eye</i>Lihat
                                        </a>
                                    </li>
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
});

</script>
@endpush