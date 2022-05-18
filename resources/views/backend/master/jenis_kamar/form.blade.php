{{ csrf_field() }}

<div class="col m12">

    <div class="row">
        <div class="input-field col s12{{ $errors->has('jenis_kamar') ? ' has-warning' : '' }}">
            <input name="jenis_kamar" value="{{ (!empty($data->jenis_kamar))? $data->jenis_kamar : old('jenis_kamar') }}" id="jenis_kamar" type="text" class="validate">
            <label for="jenis_kamar">Jenis Kamar</label>
            <!-- @if ($errors->has('jenis_kamar'))
                <div class="form-control-feedback">{{ $errors->first('jenis_kamar') }}</div>
            @endif -->
        </div>
    </div>
    
    <div class="row">
        <div class="input-field col s12{{ $errors->has('harga') ? ' has-warning' : '' }}">
            <input name="harga" value="{{ !empty(old('harga')) ? old('harga') : (!empty($data->harga_permalam)) ? $data->harga_permalam : 0 }}" id="harga" type="number" class="validate">
            <label for="harga">Harga Permalam</label>
            <!-- @if ($errors->has('harga'))
                <div class="form-control-feedback">{{ $errors->first('harga') }}</div>
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

    <div class="input-field col s12">
        <!-- <input type="submit" class="btn waves-effect waves-light right" name="simpan" value="Simpan"> -->
        <a href="{{ route('backend::master.jenis_kamar.index') }}" class="btn waves-effect waves-light left" role="button">Batal
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
            <i class="material-icons right">save</i>
        </button>
    </div>
    <!-- <div class="form-group">
        <input type="submit" class="btn btn-success btn-sm" name="simpan" value="Simpan">
        <a href="{{ route('backend::master.jenis_kamar.index') }}" class="btn btn-primary btn-sm" role="button">Batal</a>
    </div> -->
</div>

@push('style')
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
@endpush

@push('script')
<script src="{{ asset('vendors/formatter/jquery.formatter.min.js') }}"></script>
<script>
tinymce.init({
    selector:'textarea.keterangan',
    width: 900,
    height: 300
});
$(function() {
    
});
</script>
@endpush