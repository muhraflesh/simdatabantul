{{ csrf_field() }}

<div class="col m12">

    <div class="row">
        <div class="input-field col s12{{ $errors->has('nama') ? ' has-warning' : '' }}">
            <input name="nama" value="{{ (!empty($data->name))? $data->name : old('nama') }}" id="nama" type="text" class="validate">
            <label for="nama">Nama Pengguna</label>
            <!-- @if ($errors->has('nama'))
                <div class="form-control-feedback">{{ $errors->first('nama') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('username') ? ' has-warning' : '' }}">
            <input name="username" value="{{ (!empty($data->username))? $data->username : old('username') }}"{{ (!empty($data->username)) ? ' readonly disabled': ''}} id="username" type="text" class="validate">
            <label for="username">Username</label>
            <!-- @if ($errors->has('username'))
                <div class="form-control-feedback">{{ $errors->first('username') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('no_hp') ? ' has-warning' : '' }}">
            <input name="no_hp" value="{{ (!empty($data->no_hp))? $data->no_hp : old('no_hp') }}" id="no_hp" type="text" class="validate">
            <label for="no_hp">No HP</label>
            <!-- @if ($errors->has('no_hp'))
                <div class="form-control-feedback">{{ $errors->first('no_hp') }}</div>
            @endif -->
        </div>
    </div>

    <!-- <div class="row">
        <div class="input-field col s12{{ $errors->has('deskripsi') ? ' has-warning' : '' }}">
            <textarea rows="20" id="konten" name="deskripsi" class="form-control" placeholder="">{{ old('deskripsi') }}</textarea>
            <label for="deskripsi">Deskripsi</label>
            @if ($errors->has('deskripsi'))
                <div class="form-control-feedback">{{ $errors->first('deskripsi') }}</div>
            @endif
        </div>
    </div> -->

    <div class="row">
        <div class="input-field col s12{{ $errors->has('email') ? ' has-warning' : '' }}">
            <input name="email" value="{{ (!empty($data->email))? $data->email : old('email') }}"{{ (!empty($data->email)) ? ' readonly disabled': ''}} id="email" type="email" class="validate">
            <label for="email">Email</label>
            <!-- @if ($errors->has('email'))
                <div class="form-control-feedback">{{ $errors->first('email') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('password') ? ' has-warning' : '' }}">
            <input name="password" value="{{ old('password') }}" id="email" type="password" class="validate">
            <label for="password">Password</label>
            <!-- @if ($errors->has('password'))
                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
            @endif -->
            @if(!empty($data->password))
            <small>
            *Biarkan jika tidak akan diubah.
            </small>
            @endif
        </div>
    </div>

    <div class="input-field col s12">
        <!-- <input type="submit" class="btn waves-effect waves-light right" name="simpan" value="Simpan"> -->
        <a href="{{ route('backend::pengguna.index') }}" class="btn waves-effect waves-light left" role="button">Batal
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
            <i class="material-icons right">save</i>
        </button>
    </div>
    <!-- <div class="form-group">
        <input type="submit" class="btn btn-success btn-sm" name="simpan" value="Simpan">
        <a href="{{ route('backend::pengguna.index') }}" class="btn btn-primary btn-sm" role="button">Batal</a>
    </div> -->
</div>

@push('script')
<script src="{{ asset('vendors/formatter/jquery.formatter.min.js') }}"></script>
<script>
$(function() {

});
</script>
@endpush