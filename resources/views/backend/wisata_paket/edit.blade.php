@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('edit_wisata_paket') !!}
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

                <form enctype="multipart/form-data" class="form-horizontal" action="{{ route('backend::wisata_paket.update', ['id'=>Request::segment(3)]) }}" method="post">
                <input name="_method" type="hidden" value="PATCH">
                @include('backend.wisata_paket.form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection