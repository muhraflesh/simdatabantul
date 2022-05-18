{{ csrf_field() }}

<div class="col m12">

    @if(\Auth::user()->hasRole('superadmin'))
    <div class="row">
        <div class="col s12{{ $errors->has('jumlah_kamar') ? ' has-warning' : '' }}">
            <label for="desa_wisata">Desa Wisata</label>
            <select id="desa_wisata" name="desa_wisata" class="browser-default">
                <option value="" disabled selected>Pilih</option>
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

    @if(!empty($data->akomodasi))
    <div class="row" id="akomodasi">
        <div class="col s12">
            <label for="akomodasi">Akomodasi</label>
            <select id="akomodasii" name="akomodasi" class="browser-default" onchange="pilihAkomodasi(this);">
                <option value="" disabled selected>Pilih</option>
            @foreach(\App\Akomodasi::where('wisata_id', $data->akomodasi->wisata->id)->get() as $akomodasi)
                <option value="{{ $akomodasi->id }}"{{ ($data->akomodasi_id == $akomodasi->id)? ' selected' : '' }}>{{ $akomodasi->nama_pemilik }} (Rp. {{ ucwords($akomodasi->harga_kamar) }})</option>
            @endforeach
            </select>
            <!-- @if ($errors->has('kecamatan'))
                <div class="form-control-feedback">{{ $errors->first('kecamatan') }}</div>
            @endif -->
        </div>
    </div>
    @else
    <div class="row" id="akomodasi"></div>
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
        <div class="input-field col s12{{ $errors->has('asal_kota_wisatawan') ? ' has-warning' : '' }}">
            <input name="asal_kota_wisatawan" value="{{ (!empty($data->asal_kota_wisatawan))? $data->asal_kota_wisatawan : old('asal_kota_wisatawan') }}" id="asal_kota_wisatawan" type="text" class="validate">
            <label for="asal_kota_wisatawan">Asal Kota Wisatawan</label>
            <!-- @if ($errors->has('asal_kota_wisatawan'))
                <div class="form-control-feedback">{{ $errors->first('asal_kota_wisatawan') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row" id="fieldLama" style="display:none;">
        <div class="input-field col s12{{ $errors->has('lama_menginap') ? ' has-warning' : '' }}">
            <input name="lama_menginap" onchange="changeTotal()" value="{{ !empty(old('lama_menginap')) ? old('lama_menginap') : (!empty($data->lama_menginap)) ? $data->lama_menginap : 1 }}" id="lama_menginap" type="number" class="validate">
            <label for="lama_menginap">Lama Menginap</label>
            <!-- @if ($errors->has('lama_menginap'))
                <div class="form-control-feedback">{{ $errors->first('lama_menginap') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row" id="fieldJumlah" style="display:none;">
        <div class="input-field col s12{{ $errors->has('jumlah_menginap') ? ' has-warning' : '' }}">
            <input name="jumlah_menginap" onchange="changeTotal()" value="{{ !empty(old('jumlah_menginap')) ? old('jumlah_menginap') : (!empty($data->jumlah_menginap)) ? $data->jumlah_menginap : 1 }}" min="1" id="jumlah_menginap" type="number" class="validate">
            <label for="jumlah_menginap">Jumlah Orang Menginap</label>
            <!-- @if ($errors->has('jumlah_menginap'))
                <div class="form-control-feedback">{{ $errors->first('jumlah_menginap') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row" id="fieldTotal" style="display:none;">
        <div class="input-field col s12{{ $errors->has('total') ? ' has-warning' : '' }}">
            <input readonly name="total" value="{{ !empty(old('total')) ? old('total') : (!empty($data->total)) ? $data->total : 0 }}" id="total" type="number" class="validate">
            <label for="total">Total Harga</label>
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
        <a href="{{ route('backend::menginap.index', ['tipe'=>$tipe_wisata]) }}" class="btn waves-effect waves-light left" role="button">Batal
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
            <i class="material-icons right">save</i>
        </button>
    </div>
    <!-- <div class="form-group">
        <input type="submit" class="btn btn-success btn-sm" name="simpan" value="Simpan">
        <a href="{{ route('backend::menginap.index', ['tipe'=>$tipe_wisata]) }}" class="btn btn-primary btn-sm" role="button">Batal</a>
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
@endpush

@push('script')
<script>
$(document).ready(function(){
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd"
    });

    @if(\Auth::user()->hasRole('operator'))
        ambilAkomodasi({{\Auth::user()->pengelola[0]->wisata_id}});
    @endif

    @if(!empty(@$data->akomodasi))
        var lama = $("#lama_menginap");
        var total = $("#total");
        $("#fieldLama").show();
        $("#fieldJumlah").show();
        $("#fieldTotal").show();
        changeTotal();
    @endif
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

    $("select#desa_wisata").change(function(){
        var desaWisataId = $(this).children("option:selected").val();

        ambilAkomodasi(desaWisataId);
    });

    function ambilAkomodasi(idWisata){
        $.ajax({
            type:'GET',
            url:"{{ url('getAkomodasi') }}/"+idWisata,
            // data:"id=" + propinsi,
            success: function(html){
                dataHtml = "<div class=\"col s12\">";
                dataHtml += "<label for=\"akomodasi\">Akomodasi</label>";
                dataHtml += "<select id=\"akomodasii\" name=\"akomodasi\" class=\"browser-default\" onchange=\"pilihAkomodasi(this);\">\"";
                if(html.length > 0){
                    // console.log(html)
                        dataHtml += "<option value=\"\" disabled selected>Pilih</option>";
                    html.forEach(function(item, index){
                        dataHtml += "<option value='"+item.id+"'>"+ item.nama_pemilik +" (Rp. "+ item.harga_kamar +"/hari)</option>";
                    });
                }else{
                    dataHtml += "<option value=''>Tidak ada akomodasi</option>";
                }
                dataHtml += "</select>";
                dataHtml += "</div>";

                $("#akomodasi").html(dataHtml);
            }
        });
    }

    function pilihAkomodasi(sel){
        var lama = $("#lama_menginap");
        var jumlah = $("#jumlah_menginap");
        var total = $("#total");
        $("#fieldLama").show();
        $("#fieldJumlah").show();
        $("#fieldTotal").show();

        teks = sel.options[sel.selectedIndex].text;
        res = teks.match(/[rp.]+\s([\d])+/gi);
        res = (res.length > 0) ? res[0].replace('Rp.', '') : 0;
        // console.log(teks, res);
        total.val(res*lama.val())
    }

    function changeTotal(){
        var lama = $("#lama_menginap");
        var jumlah = $("#jumlah_menginap");
        var total = $("#total");
        var akomodasi = $("#akomodasii");

        teks = akomodasi.text();
        res = teks.match(/[rp.]+\s([\d])+/gi);
        res = (res.length > 0) ? res[0].replace('Rp.', '') : 0;

        // console.log(teks, res);
        total.val(res*lama.val())
    }

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