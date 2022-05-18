@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('profile') !!}
@endsection

@section('action')
@if($action!='edit')
<div class="col s2 m6 l6">
    <a class="btn dd-settings waves-effect waves-light breadcrumbs-btn right" href="{{ route('backend::profile.edit') }}">
        <span class="hide-on-small-onl">
            Ubah Profil
        </span><i class="material-icons left">edit</i>
    </a>
</div>
@endif
@endsection

@section('content')
    <div class="card">
        <div class="card-content">
            @php
            $user = Auth::user();
            @endphp

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

            <form action="" method="POST">
                @if($action=="edit")
                <input name="_method" type="hidden" value="PATCH">
                {{ csrf_field() }}
                @endif

                @if($user->hasRole('superadmin'))
                <div class="input-field col s12 m6">
                    <input type="text" disabled readonly value="{{ $user->username }}" />
                    <label>Username</label>
                </div>
                <div class="input-field col s12 m6">
                    <input name="name" type="text"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ $user->name }}" />
                    <label>Nama</label>
                </div>
                
                <div class="input-field col s12 m6">
                    <input name="no_hp" type="text"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ $user->no_hp }}" />
                    <label>Kontak HP</label>
                </div>
                <div class="input-field col s12 m6">
                    <input name="email" type="email"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ $user->email }}" />
                    <label>Email</label>
                </div>
                @endif

                @if($user->hasRole('operator_hotel'))
                <div class="input-field col s12 m12">
                    <input name="nama_hotel" type="text"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ $user->hotel->nama_hotel }}" />
                    <label>Nama Hotel</label>
                </div>
                <div class="input-field col s12 m12">
                    <input name="alamat" type="text"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ $user->hotel->alamat_hotel }}" />
                    <label>Alamat</label>
                </div>
                <div class="input-field col s12 m6">
                    <input name="kontak" type="text"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ $user->hotel->kontak_hotel }}" />
                    <label>No HP</label>
                </div>
                <div class="input-field col s12 m6">
                    <input type="text" disabled readonly value="{{ $user->hotel->email_hotel }}" />
                    <label>Email</label>
                </div>
                <div class="input-field col s12 m12">
                    <input type="text" disabled readonly value="{{ $user->username }}" />
                    <label>Username</label>
                </div>
                @endif

                @if($user->hasRole('operator'))
                
                @if(!empty($user->pengelola))
                <div class="input-field col s12 m6">
                    <input name="nama_wisata" type="text"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ @$user->pengelola[0]->wisata->nama }}" />
                    <label>Nama Wisata</label>
                </div>
                <div class="input-field col s12 m6">
                    <input name="jam_buka" class="timepicker" type="text"{{ ($action=="view") ? " disabled readonly" : ""}} value="{{ substr(@$user->pengelola[0]->wisata->jam_buka, 0, 5) }}" />
                    <label>Jam Buka</label>
                </div>
                @else
                <p>
                Akun anda belum mengelola tempat wisata.
                </p>
                @endif

                <div class="input-field col s12 m12">
                    <input type="text" disabled readonly value="{{ $user->username }}" />
                    <label>Username</label>
                </div>
                @endif

                @if($action=='edit')
                <div class="input-field col s12 m12">
                    <input type="password" value="" name="password" />
                    <label>Password*</label>
                    <small>*Kosongkan jika tidak ingin diubah</small>
                    @if ($errors->has('password'))
                    <div class="card-alert card gradient-45deg-amber-amber">
                        <div class="card-content white-text">
                            <p>
                                <i class="material-icons">warning</i> {{ $errors->first('password') }}</p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                </div>

                <div class="col s12 m12">
                    <div class="card-alert card orange lighten-5">
                        <div class="card-content orange-text">
                            <p style="font-weight: 600;">Syarat Password:</p>
                            <p>* Jumlah karakter minimal 8 karakter.</p>
                            <p>* Memuat kombinasi huruf besar kecil, angka, dan karakter.</p>
                        </div>
                        <button type="button" class="close orange-text" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>

                <div class="input-field col s12">
                    <a href="{{ route('backend::profile') }}" class="btn waves-effect waves-light left" role="button">Batal
                        <i class="material-icons left">arrow_back</i>
                    </a>
                    <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
                        <i class="material-icons right">save</i>
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(function () {
        $('.timepicker').timepicker({
            defaultTime : '08:30',
            autoClose : true,
            twelveHour : false,
            format:"HH:ii"
        });
    });
</script>
@endpush