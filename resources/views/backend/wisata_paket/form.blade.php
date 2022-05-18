{{ csrf_field() }}

<div class="col m12">

    <div class="row">
        <div class="input-field col s12{{ $errors->has('nama') ? ' has-warning' : '' }}">
            <input name="nama" value="{{ (!empty($data->nama))? $data->nama : old('nama') }}" id="nama" type="text" class="validate">
            <label for="nama">Nama Paket Wisata</label>
            <!-- @if ($errors->has('nama'))
                <div class="form-control-feedback">{{ $errors->first('nama') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <label class="active" for="keterangan">Keterangan</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <textarea style="height: 45px;" spellcheck="false" name="keterangan" class="materialize-textarea keterangan">{{ (!empty($data->keterangan))? $data->keterangan : old('keterangan') }}</textarea>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('harga') ? ' has-warning' : '' }}">
            <input name="harga" value="{{ (!empty($data->harga))? $data->harga : old('harga') }}" id="harga" type="number" min="1" value="1" class="validate">
            <label for="harga">Harga</label>
            <!-- @if ($errors->has('harga'))
                <div class="form-control-feedback">{{ $errors->first('harga') }}</div>
            @endif -->
        </div>
    </div>

    <div class="input-field col s12">
        <!-- <input type="submit" class="btn waves-effect waves-light right" name="simpan" value="Simpan"> -->
        <a href="{{ route('backend::wisata_paket.index') }}" class="btn waves-effect waves-light left" role="button">Batal
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

@push('style')
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
@endpush

@push('script')
<script>
    $(function() {
        tinymce.init({
            selector:'textarea.keterangan',
            width: 900,
            height: 300
        });
    });
</script>
@endpush