{{ csrf_field() }}

<div class="col m12">

    @if(\Auth::user()->hasRole('superadmin'))
    <div class="row">
        <div class="col s12{{ $errors->has('jumlah_kamar') ? ' has-warning' : '' }}">
            <label for="obyek_wisata">Obyek Wisata</label>
            <select id="obyek_wisata" name="obyek_wisata" class="browser-default">
            @foreach(\App\Wisata::where('tipe_wisata', 'obyek')->get() as $wisata)
                <option value="{{ $wisata->id }}"{{ (@$data->wisata_id == $wisata->id)? ' selected' : '' }}>{{ ucwords($wisata->nama) }}</option>
            @endforeach
            </select>
            <!-- @if ($errors->has('kecamatan'))
                <div class="form-control-feedback">{{ $errors->first('kecamatan') }}</div>
            @endif -->
        </div>
    </div>
    @endif

    <div class="row">
        <div class="input-field col s12{{ $errors->has('tanggal') ? ' has-warning' : '' }}">
            <input name="tanggal" value="{{ (!empty($data->tanggal))? $data->tanggal : old('tanggal') }}" id="tanggal" type="text" class="validate datepicker">
            <label for="tanggal">Tanggal</label>
            <!-- @if ($errors->has('tanggal'))
                <div class="form-control-feedback">{{ $errors->first('tanggal') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('jumlah_wisatawan') ? ' has-warning' : '' }}">
            <input name="jumlah_wisatawan" value="{{ (!empty($data->jumlah_wisatawan))? $data->jumlah_wisatawan : old('jumlah_wisatawan') }}" id="jumlah_wisatawan" type="number" min="1" value="1" class="validate">
            <label for="jumlah_wisatawan">Jumlah Wisatawan</label>
            <!-- @if ($errors->has('jumlah_wisatawan'))
                <div class="form-control-feedback">{{ $errors->first('jumlah_wisatawan') }}</div>
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
    <!-- <div class="row">
        <div class="input-field file-field col s12{{ $errors->has('foto') ? ' has-warning' : '' }}">
            <div class="btn float-right">
                <span>Lampirkan Foto</span>
                <input type="file" name="foto" class="form-control" onchange="browseImage(this)" >
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate valid" type="text">
            </div>
            <img src="{{ (!empty($data->foto)) ? asset($data->foto) : asset('uploads/default.jpg') }}" id="img" width="100%" />
        </div>
        <small>
        *File yang boleh diupload jpg, jpeg, png dan maksimal 2MB.<br>
        *Biarkan jika tidak akan diubah.
        </small>
    </div> -->

    <table id="images" class="table table-bordered">
        <tbody>
            <tr>
                <th style="width: 20%">Foto</th>
                <th>Nama Foto</th>
                <th style="width: 5%">Aksi</th>
            </tr>
            @php    
            $no=1;
            @endphp

            @if(!empty($fotos))
            @foreach($fotos as $foto)
                <tr id="image-row{{ $no }}">
                    <td>
                        <label for="url_foto{{ $no }}">
                            <img id="poto{{ $no }}" width="100%" src="{{ (!empty($foto->url_foto)) ? asset($foto->url_foto) : asset("uploads/default.jpg") }}"/>
                        </label>
                        <input name="foto[{{ $no }}][url_foto]" id="url_foto{{ $no }}" value="{{ public_path($foto->url_foto) }}" onchange="changeImages(this, {{ $no }})" type="file" accept="image/*" style="display: none;"/>
                        <input name="foto[{{ $no }}][backup_url]" value="{{ $foto->url_foto }}" id="backup_url{{ $no }}" type="hidden"/>
                    </td>
                    <td class="text-right"><input type="text" name="foto[{{ $no }}][nama_foto]" value="{{ $foto->nama_foto }}" placeholder="Nama Foto" class="form-control" /></td>
                    <td class="text-left"><button type="button" onclick="$('#image-row{{ $no }}').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="material-icons center">remove</i></button></td>
                </tr>
                
                @php
                    $no++;
                @endphp

            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                </td>
                <td class="text-left">
                    <button data-original-title="Tambah Foto" type="button" onclick="addImage();" data-toggle="tooltip" title="" class="btn btn-primary"><i class="material-icons center">add_a_photo</i></button>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="input-field col s12">
        <!-- <input type="submit" class="btn waves-effect waves-light right" name="simpan" value="Simpan"> -->
        <a href="{{ route('backend::kunjungan.obyek_wisata.index', ['tipe'=>$tipe_wisata]) }}" class="btn waves-effect waves-light left" role="button">Batal
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
            <i class="material-icons right">save</i>
        </button>
    </div>
    <!-- <div class="form-group">
        <input type="submit" class="btn btn-success btn-sm" name="simpan" value="Simpan">
        <a href="{{ route('backend::kunjungan.obyek_wisata.index', ['tipe'=>$tipe_wisata]) }}" class="btn btn-primary btn-sm" role="button">Batal</a>
    </div> -->
</div>

@push('style')
<style>
@media only screen and (max-width: 1024px){
    tfoot {
        display: contents;
    }
}
</style>
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
@endpush

@push('script')
<script>
$(document).ready(function(){
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd"
    });
    tinymce.init({
        selector:'textarea.keterangan',
        width: 900,
        height: 300
    });
});
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
                    dataHtml += "<option value='"+item.id+"'>"+ item.nama +"</option>";
                });
                dataHtml += "</select>";

                $("#kelurahan").html(dataHtml);
            }
        });
    });

    function readURLs(input, id) {
        console.log(input.files);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function changeImages(e, i){
        readURLs(e, '#poto'+i);
    }

    var image_row = {{ $no }};

    function addImage() {
        console.log("nambah");
        html  = '<tr id="image-row' + image_row + '">';
        html += '  <td>';
        html += '   <label for="url_foto' + image_row + '">';
        html += '       <img id="poto' + image_row + '" width="100%" src="{{ asset("uploads/default.jpg") }}"/>';
        html += '   </label>';
        html += '   <input name="foto[' + image_row + '][url_foto]" id="url_foto' + image_row + '" onchange="changeImages(this, ' + image_row + ')" type="file" accept="image/*" style="display: none;"/>';
        html += '  </td>';
        html += '  <td class="text-right"><input type="text" name="foto[' + image_row + '][nama_foto]" value="" placeholder="Nama Foto" class="form-control" /></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="Hapus Foto" class="btn btn-danger"><i class="material-icons center">remove</i></button></td>';
        html += '</tr>';
        
        $('#images tbody').append(html);
        
        image_row++;
    }

</script>
@endpush