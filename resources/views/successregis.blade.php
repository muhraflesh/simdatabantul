@extends('layouts.auth')

@section('content')
<div id="login-page" class="row">
    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="input-field col s12">
                <h5 class="ml-4">Success Registration</h5>
                </div>
            </div>
            <div class="row margin">
                <div class="card-alert card gradient-45deg-green-teal">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">check_circle</i> Pendaftaran anda berhasil, tim admin akan memverifikasi pendaftaran akun anda. Kami akan menghubungi anda melalui email jika akun anda sudah terverifikasi</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                <p class="margin center-align medium-small"><a href="{{ route('login') }}">Ke halaman Login</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
