@extends('layouts.auth')

@section('content')
<div id="login-page" class="row">
    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="input-field col s12">
                <h5 class="ml-4">Download Template Dokumen Registrasi</h5>
                </div>
            </div>
            <div class="row margin">
                <a href="{{ route('template_doc.download', ['name'=>'susunan_pengurus']) }}">
                    <div class="card-alert card gradient-45deg-green-teal">
                        <div class="card-content white-text">
                            <p>
                                <i class="material-icons">archive</i> &nbsp Dokumen susunan pengurus
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row margin">
                <a href="{{ route('template_doc.download', ['name'=>'permohonan_registrasi']) }}">
                    <div class="card-alert card gradient-45deg-purple-light-blue">
                        <div class="card-content white-text">
                            <p>
                                <i class="material-icons">archive</i> &nbsp Dokumen permohonan registrasi
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row margin">
                <a href="{{ route('template_doc.download', ['name'=>'foto_deskripsi']) }}">
                    <div class="card-alert card gradient-45deg-purple-deep-purple">
                        <div class="card-content white-text">
                            <p>
                                <i class="material-icons">archive</i> &nbsp Dokumen foto & deskripsi
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                <p class="margin center-align medium-small"><a href="{{ route('register') }}">Ke halaman Registrasi</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
