{{ csrf_field() }}

<div class="col m12">
    @if(\Auth::user()->hasRole('superadmin'))
    <div class="row">
        <div class="col s12">
            <label for="jenis_hotel">Jenis Hotel</label>
            <select id="jenis_hotel" name="jenis_hotel" class="browser-default">
                <option value="" disabled selected>Pilih</option>
                <option value="bintang"{{ (!empty(@$data->kamar->hotel->jenis_hotel=='bintang'))? ' selected' : '' }}>Bintang</option>
                <option value="nonbintang"{{ (!empty(@$data->kamar->hotel->jenis_hotel=='nonbintang'))? ' selected' : '' }}>Non Bintang</option>
            </select>
            <!-- @if ($errors->has('kecamatan'))
                <div class="form-control-feedback">{{ $errors->first('kecamatan') }}</div>
            @endif -->
        </div>
    </div>

    <div class="row" id="cbHotel"></div>
    @endif

    <div class="row" id="cbKamar"></div>

    <div class="row" id="fieldTanggal" style="display:none;">
        <div class="input-field col s12{{ $errors->has('tanggal') ? ' has-warning' : '' }}">
            <input name="tanggal" value="{{ (!empty($data->tanggal))? $data->tanggal : old('tanggal') }}" id="tanggal" type="text" class="validate datepicker">
            <label for="tanggal">Tanggal</label>
            <!-- @if ($errors->has('tanggal'))
                <div class="form-control-feedback">{{ $errors->first('tanggal') }}</div>
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

    <div class="input-field col s12">
        <!-- <input type="submit" class="btn waves-effect waves-light right" name="simpan" value="Simpan"> -->
        <a href="{{ route('backend::menginap_hotel.index', ['tipe'=>$tipe_wisata]) }}" class="btn waves-effect waves-light left" role="button">Batal
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Simpan
            <i class="material-icons right">save</i>
        </button>
    </div>
</div>

@push('script')
<script>

$(document).ready(function(){
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd"
    });

    // $("#fieldTanggal").hide();
    // $("#fieldLama").hide();
    // $("#fieldTotal").hide();
    @if(\Auth::user()->hasRole('superadmin'))
        @if(!empty(@$data->kamar->hotel->jenis_hotel))
        ambilHotel("{{ $data->kamar->hotel->jenis_hotel }}");
        ambilKamar("{{ $data->kamar->hotel->id }}");
        @endif
    @elseif(\Auth::user()->hasRole('operator_hotel'))
        ambilKamar("{{ \Auth::user()->hotel->id }}");
    @endif

    @if(!empty(@$data->kamar->hotel->jenis_hotel))
        var lama = $("#lama_menginap");
        var total = $("#total");
        $("#fieldTanggal").show();
        $("#fieldLama").show();
        $("#fieldJumlah").show();
        $("#fieldTotal").show();
    @endif
});

    $("select#jenis_hotel").change(function(){
        var jenis = $(this).children("option:selected").val();

        ambilHotel(jenis);
    });

    function ambilHotel(jenis){
        $.ajax({
            type:'GET',
            url:"{{ url('getHotelByJenis') }}/"+jenis,
            // data:"id=" + propinsi,
            success: function(html){
                dataHtml = "<div class=\"col s12\">";
                dataHtml += "<label for=\"hotel\">Hotel</label>";
                dataHtml += "<select id=\"hotel\" onchange=\"changeKamar(this.value)\" name=\"hotel\" class=\"browser-default\">\"";
                dataHtml += "<option value=\"\" disabled selected>Pilih</option>";
                if(html.length > 0){
                    // console.log(html)
                    html.forEach(function(item, index){
                        dataHtml += "<option value='"+item.id+"'>"+ item.nama_hotel +"</option>";
                    });
                }else{
                    dataHtml += "<option value=''>Tidak ada hotel</option>";
                }
                dataHtml += "</select>";
                dataHtml += "</div>";

                $("#cbHotel").html(dataHtml);
                @if(!empty($data->kamar->hotel->id))
                // selected
                $("#hotel option[value={{ $data->kamar->hotel->id }}]").attr('selected','selected');
                @endif
            }
        });
    }

    function changeKamar(idHotel){
        ambilKamar(idHotel);
    }

    function ambilKamar(hotelId){
        $.ajax({
            type:'GET',
            url:"{{ url('getKamarHotel') }}/"+hotelId,
            // data:"id=" + propinsi,
            success: function(html){
                dataHtml = "<div class=\"col s12\">";
                dataHtml += "<label for=\"kamar\">Jenis Kamar</label>";
                dataHtml += "<select id=\"kamar\" name=\"kamar\" class=\"browser-default\" onchange=\"pilihKamar(this);\">\"";
                dataHtml += "<option value=\"\" disabled selected>Pilih</option>";
                if(html.length > 0){
                    // console.log(html)
                    html.forEach(function(item, index){
                        dataHtml += "<option value='"+item.id+"'>"+ item.jenis_kamar +" (Rp. "+ item.harga_permalam +")</option>";
                    });
                }else{
                    dataHtml += "<option value=''>Tidak ada kamar</option>";
                }
                dataHtml += "</select>";
                dataHtml += "</div>";

                $("#cbKamar").html(dataHtml);
                @if(!empty($data->kamar->id))
                // selected
                $("#kamar option[value={{ $data->kamar->id }}]").attr('selected','selected');
                @endif
            }
        });
    }

    function pilihKamar(sel){
        var lama = $("#lama_menginap");
        var jumlah = $("#jumlah_menginap");
        var total = $("#total");
        $("#fieldTanggal").show();
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
        var kamar = $("#kamar");

        teks = kamar.text();
        res = teks.match(/[rp.]+\s([\d])+/gi);
        res = (res.length > 0) ? res[0].replace('Rp.', '') : 0;

        // console.log(teks, res);
        total.val(res*lama.val())
    }
</script>
@endpush