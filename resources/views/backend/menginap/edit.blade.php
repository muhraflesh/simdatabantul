@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('edit_akomodasi_'.$tipe_wisata) !!}
@endsection

@section('content')
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                @if ($errors->any())

                    <div class="card-alert card gradient-45deg-amber-amber">
                        <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> Perhatian
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif

                <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('backend::menginap.update', ['id'=>Request::segment(4), 'tipe' => $tipe_wisata]) }}" method="post">
                    <input name="_method" type="hidden" value="PATCH">
                    @include('backend.menginap.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection