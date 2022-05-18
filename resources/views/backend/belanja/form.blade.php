{{ csrf_field() }}

<div class="col m12">

    @if(\Auth::user()->hasRole('superadmin'))
    <div class="row">
        <div class="col s12{{ $errors->has('jumlah_kamar') ? ' has-warning' : '' }}">
            <label for="wisata">Desa Wisata</label>
            <select id="wisata" name="wisata" class="browser-default">
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

    <div class="row">
        <div class="col s12{{ $errors->has('jumlah_kamar') ? ' has-warning' : '' }}">
            <label for="kategori">Kategori Belanja</label>
            <select id="kategori" name="kategori" class="browser-default">
            <option value="kuliner"{{ (@$data->kategori_belanja == 'kuliner')? ' selected' : '' }}>Kuliner</option>
            <option value="oleholeh"{{ (@$data->kategori_belanja == 'oleholeh')? ' selected' : '' }}>Oleh-Oleh</option>
            <option value="transportasi"{{ (@$data->kategori_belanja == 'transportasi')? ' selected' : '' }}>Transportasi</option>
            <option value="paketwisata"{{ (@$data->kategori_belanja == 'paketwisata')? ' selected' : '' }}>Paket Wisata</option>
            </select>
            <!-- @if ($errors->has('kecamatan'))
                <div class="form-control-feedback">{{ $errors->first('kecamatan') }}</div>
            @endif -->
        </div>
    </div>

    @if((@$data->kategori_belanja == 'paketwisata'))
    <div class="row" id="cbPaketWisata">
        <div class="col s12">
            <label for="wisata_paket">Paket Wisata</label>
            <select id="wisata_paket" name="wisata_paket" onchange="hitungJumlahPaket(this)" class="browser-default">
                <option value="" disabled selected>Pilih</option>
                @php
                $belanjaWisataPaket = \App\BelanjaWisataPaket::where('belanja_id', $data->id)->first();
                @endphp
                
                @forelse(\App\WisataPaket::where('wisata_id', $data->wisata_id)->get() as $wp)
                <option value='{{ $wp->id }}'{{ ($belanjaWisataPaket->wisata_paket_id==$wp->id) ? ' selected' : '' }}>{{ $wp->nama }} (Rp. {{ $wp->harga }})</option>
                @empty
                <option value=''>Tidak ada paket wisata</option>
                @endforelse
            </select>
        </div>
    </div>
    @else
    <div class="row" id="cbPaketWisata"></div>
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
        <div class="input-field col s12{{ $errors->has('jumlah_orang') ? ' has-warning' : '' }}">
            <input name="jumlah_orang" onchange="changeTotal()" value="{{ (!empty($data->jumlah_orang))? $data->jumlah_orang : old('jumlah_orang') }}" id="jumlah_orang" type="number" min="1" value="1" class="validate">
            <label for="jumlah_orang">Jumlah Orang Belanja</label>
            <!-- @if ($errors->has('jumlah_orang'))
                <div class="form-control-feedback">{{ $errors->first('jumlah_orang') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('total_belanja') ? ' has-warning' : '' }}">
            <input name="total_belanja" value="{{ (!empty($data->total_belanja))? $data->total_belanja : old('total_belanja') }}" id="total_belanja" type="number" min="1" value="1" class="validate">
            <label for="total_belanja">Total Belanja</label>
            <!-- @if ($errors->has('total_belanja'))
                <div class="form-control-feedback">{{ $errors->first('total_belanja') }}</div>
            @endif -->
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
        <a href="{{ route('backend::belanja.index', ['tipe' => $tipe_wisata]) }}" class="btn waves-effect waves-light left" role="button">Batal
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
            <i class="material-icons right">save</i>
        </button>
    </div>
    <!-- <div class="form-group">
        <input type="submit" class="btn btn-success btn-sm" name="simpan" value="Simpan">
        <a href="{{ route('backend::belanja.index', ['tipe' => $tipe_wisata]) }}" class="btn btn-primary btn-sm" role="button">Batal</a>
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

    var wisataId = {{ \App\Wisata::first() ? \App\Wisata::first()->id : 0 }};

    @if(\Auth::user()->hasRole('superadmin'))
    $("select#wisata").change(function(){
        var kat = $(this).children("option:selected").val();

        wisataId=kat;

        if($("select#kategori").val()=='paketwisata'){
            listPaketWisata(wisataId);
        }else{
            $("#cbPaketWisata").html("");
        }
    });
    @endif

    $("select#kategori").change(function(){
        var kat = $(this).children("option:selected").val();

        if(kat=='paketwisata'){
            @if(\Auth::user()->hasRole('operator'))
            listPaketWisata('{{ \Auth::user()->pengelola[0]->wisata->id }}');
            @else
            listPaketWisata(wisataId);
            @endif

            $("#jumlah_orang").val("1");
        }else{
            $("#cbPaketWisata").html("");
        }

    });

    function hitungJumlahPaket(paket){
        teks = paket.options[paket.selectedIndex].text;
        res = teks.match(/[rp.]+\s([\d])+/gi);
        res = (res.length > 0) ? res[0].replace('Rp.', '') : 0;
        // console.log(teks, res);
        $("#total_belanja").val(res*$("#jumlah_orang").val())
    }

    function changeTotal(){
        var jumlah = $("#jumlah_orang");
        var total = $("#total_belanja");
        var wp = $("#wisata_paket");

        teks = wp.text();
        res = teks.match(/[rp.]+\s([\d])+/gi);
        res = (res.length > 0) ? res[0].replace('Rp.', '') : 0;

        // console.log(teks, res);
        total.val(res*jumlah.val())
    }

    function listPaketWisata(idWisata){
        $.ajax({
            type:'GET',
            url:"{{ url('getListPaketWisata') }}/"+idWisata,
            // data:"id=" + propinsi,
            success: function(html){
                dataHtml = "<div class=\"col s12\">";
                dataHtml += "<label for=\"wisata_paket\">Paket Wisata</label>";
                dataHtml += "<select id=\"wisata_paket\" name=\"wisata_paket\" onchange=\"hitungJumlahPaket(this);\" class=\"browser-default\">\"";
                dataHtml += "<option value=\"\" disabled selected>Pilih</option>";
                if(html.length > 0){
                    // console.log(html)
                    html.forEach(function(item, index){
                        dataHtml += "<option value='"+item.id+"'>"+ item.nama +" (Rp. "+ item.harga +")</option>";
                    });
                }else{
                    dataHtml += "<option value=''>Tidak ada paket wisata</option>";
                }
                dataHtml += "</select>";
                dataHtml += "</div>";

                $("#cbPaketWisata").html(dataHtml);
                @if(!empty($data->kamar->hotel->id))
                // selected
                $("#hotel option[value={{ $data->kamar->hotel->id }}]").attr('selected','selected');
                @endif
            }
        });
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