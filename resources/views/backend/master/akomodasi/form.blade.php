{{ csrf_field() }}

<div class="col m12">

<div class="row">
    <div class="input-field col s12{{ $errors->has('nama_akomodasi') ? ' has-warning' : '' }}">
        <input name="nama_akomodasi" value="{{ (!empty($data->nama_akomodasi))? $data->nama_akomodasi : old('nama_akomodasi') }}" id="nama_akomodasi" type="text" class="validate">
        <label for="nama_akomodasi">Nama Homestay</label>
        <!-- @if ($errors->has('nama_akomodasi'))
            <div class="form-control-feedback">{{ $errors->first('nama_akomodasi') }}</div>
        @endif -->
    </div>
</div>

<div class="row">
    <div class="input-field col s12{{ $errors->has('nama_pemilik') ? ' has-warning' : '' }}">
        <input name="nama_pemilik" value="{{ (!empty($data->nama_pemilik))? $data->nama_pemilik : old('nama_pemilik') }}" id="nama_pemilik" type="text" class="validate">
        <label for="nama_pemilik">Nama Pemilik</label>
        <!-- @if ($errors->has('nama_pemilik'))
            <div class="form-control-feedback">{{ $errors->first('nama_pemilik') }}</div>
        @endif -->
    </div>
</div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('alamat') ? ' has-warning' : '' }}">
            <textarea style="height: 45px;" spellcheck="false" name="alamat" class="materialize-textarea">{{ (!empty($data->alamat))? $data->alamat : old('alamat') }}</textarea>
            <label for="alamat">Alamat</label>
            <!-- @if ($errors->has('alamat'))
                <div class="form-control-feedback">{{ $errors->first('alamat') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('kontak') ? ' has-warning' : '' }}">
            <input name="kontak" value="{{ (!empty($data->kontak))? $data->kontak : old('kontak') }}" id="kontak" type="text" class="validate">
            <label for="kontak">Kontak</label>
            <!-- @if ($errors->has('kontak'))
                <div class="form-control-feedback">{{ $errors->first('kontak') }}</div>
            @endif -->
        </div>
    </div>
    
    <div class="row">
        <div class="input-field col s12{{ $errors->has('jumlah_kamar') ? ' has-warning' : '' }}">
            <input name="jumlah_kamar" value="{{ !empty(old('jumlah_kamar')) ? old('jumlah_kamar') : (!empty($data->jumlah_kamar)) ? $data->jumlah_kamar : 0 }}" id="jumlah_kamar" type="number" min="1" class="validate">
            <label for="jumlah_kamar">Jumlah Kamar</label>
            <!-- @if ($errors->has('jumlah_kamar'))
                <div class="form-control-feedback">{{ $errors->first('jumlah_kamar') }}</div>
            @endif -->
        </div>
    </div>
    
    <div class="row">
        <div class="input-field col s12{{ $errors->has('harga_kamar') ? ' has-warning' : '' }}">
            <input name="harga_kamar" value="{{ !empty(old('harga_kamar')) ? old('harga_kamar') : (!empty($data->harga_kamar)) ? $data->harga_kamar : 0 }}" id="harga_kamar" type="number" min="1" class="validate">
            <label for="harga_kamar">Harga Kamar</label>
            <!-- @if ($errors->has('harga_kamar'))
                <div class="form-control-feedback">{{ $errors->first('harga_kamar') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row" style="display:none;">
        <div class="col s12{{ $errors->has('jumlah_kamar') ? ' has-warning' : '' }}">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" class="browser-default">
            @foreach(\App\AkomodasiKategori::get() as $kategori)
                <option value="{{ $kategori->id }}"{{ (@$data->akomodasi_kategori_id == $kategori->id)? ' selected' : '' }}>{{ ucwords($kategori->nama) }}</option>
            @endforeach
            </select>
            <!-- @if ($errors->has('kecamatan'))
                <div class="form-control-feedback">{{ $errors->first('kecamatan') }}</div>
            @endif -->
        </div>
    </div>

    @if(\Auth::user()->hasRole('superadmin'))
    <div class="row">
        <div class="col s12{{ $errors->has('jumlah_kamar') ? ' has-warning' : '' }}">
            <label for="desa_wisata">Desa Wisata</label>
            <select id="desa_wisata" name="desa_wisata" class="browser-default">
            @foreach(\App\Wisata::where('tipe_wisata', 'desa')->get() as $desaWisata)
                <option value="{{ $desaWisata->id }}"{{ (@$data->wisata_id == $desaWisata->id)? ' selected' : '' }}>{{ ucwords($desaWisata->nama) }}</option>
            @endforeach
            </select>
            <!-- @if ($errors->has('kecamatan'))
                <div class="form-control-feedback">{{ $errors->first('kecamatan') }}</div>
            @endif -->
        </div>
    </div>
    @endif

    <div class="input-field col s12">
        <!-- <input type="submit" class="btn waves-effect waves-light right" name="simpan" value="Simpan"> -->
        <a href="{{ route('backend::master.akomodasi.index') }}" class="btn waves-effect waves-light left" role="button">Batal
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
            <i class="material-icons right">save</i>
        </button>
    </div>
    <!-- <div class="form-group">
        <input type="submit" class="btn btn-success btn-sm" name="simpan" value="Simpan">
        <a href="{{ route('backend::master.akomodasi.index') }}" class="btn btn-primary btn-sm" role="button">Batal</a>
    </div> -->
</div>

@push('script')
<script>

    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function browseImage(e){
        readURL(e, '#img');
    }

    $("select#kecamatan").change(function(){
        var kecamatanId = $(this).children("option:selected").val();

        $.ajax({
            type:'GET',
            url:"{{ url('getKelurahan') }}/"+kecamatanId,
            // data:"id=" + propinsi,
            success: function(html){
                dataHtml = "<div class=\"row\">";
                dataHtml += "<label for=\"kelurahan\">Kelurahan</label>";
                dataHtml += "<select id=\"kelurahan\" name=\"kelurahan\" class=\"browser-default\">\"";
                html.forEach(function(item, index){
                    dataHtml += "<option value='"+item.id+"'>"+ item.nama_pemilik +"</option>";
                });
                dataHtml += "</select>";

                $("#kelurahan").html(dataHtml);
            }
        });
    });

</script>
@endpush