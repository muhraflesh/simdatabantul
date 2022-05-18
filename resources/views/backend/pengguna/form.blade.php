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

    @if(empty($data->name))
    <div class="form-group{{ $errors->has('role') ? ' has-warning' : '' }}" id="rolenaa">
        <label class="form-control-label">Role</label>
        <select id="role" name="role" class="browser-default"{{ ($data->name)? ' readonly disabled' : '' }} data-style="form-control btn-secondary">
        @foreach($role as $role)
            @if($role->name!='operator_hotel')
            <option value="{{ $role->id }}"{{ ($data->hasRole($role->name))? ' selected' : '' }}>{{ ucwords($role->display_name) }}</option>
            @endif
        @endforeach
        </select>
        <!-- @if ($errors->has('role'))
            <div class="form-control-feedback">{{ $errors->first('role') }}</div>
        @endif -->
    </div>
    @endif

    @if(!empty(\Request::get('tipe')))
    <input type="hidden" name="tipe_pengelola" value="{{ \Request::get('tipe') }}" />
    @endif

    <div class="form-group" id="tipe">
        <label class="form-control-label">Pilih Tipe Wisata</label>
        <select id="tipeWisata" name="tipe" class="browser-default" data-style="form-control btn-secondary">
            <option value="obyek"{{ ($data->pengelola) ? (@$data->pengelola[0]->wisata->tipe_wisata=='obyek') ? ' selected' : '' : '' }}>Obyek Wisata</option>
            <option value="desa"{{ ($data->pengelola) ? (@$data->pengelola[0]->wisata->tipe_wisata=='desa') ? ' selected' : '' : '' }}>Desa Wisata</option>
        </select>
    </div>

    <div class="form-group" id="wisata"></div>

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
@if($data->hasRole('operator'))
    $("#tipe").show();
    showWisata('{{ @$data->pengelola[0]->wisata->tipe_wisata }}');
@else
    $("#tipe").hide();
    $("#wisata").html("");
@endif

@if(!empty(\Request::get('tipe')))

    $("#role").val("2").change();

    $("#tipe").show();

    @if(\Request::get('tipe')=='obyek_wisata')
    $("#tipeWisata").val("obyek").change();
    showWisata('obyek');
    @else
    $("#tipeWisata").val("desa").change();
    showWisata('desa');
    @endif
@endif

});

function showWisata(tipe){
    $.ajax({
        type:'GET',
        url:"{{ url('getWisata') }}/"+tipe,
        // data:"id=" + propinsi,
        success: function(html){
            dataHtml = "<label class=\"form-control-label\" for=\"wisatana\">Wisata</label>";
            dataHtml += "<select id=\"wisatana\" name=\"wisata\" class=\"browser-default\">\"";
            
            if(html.length>0){
            html.forEach(function(item, index){
                dataHtml += "<option value='"+item.id+"'>"+ item.nama +"</option>";
            });

            // @if($data->hasRole('operator') && empty($data->pengelola))
            //     dataHtml += "<option selected value='{{ @$data->pengelola[0]->wisata->id }}'>{{ @$data->pengelola[0]->wisata->nama }}</option>";
            // @endif
            
            }else{
                dataHtml += "<option value=''>Tidak ada wisata</option>";
            }
            
            dataHtml += "</select>";

            $("#wisata").html(dataHtml);

            $("#wisatana").val({{@$data->pengelola[0]->wisata->id}}).change();
        }
    });
}

$("select#role").change(function(){
    var roleSelect = $(this).children("option:selected").html();

    if(roleSelect=='Operator Wisata'){
        $("#tipe").show();

        showWisata('obyek');
    }else{
        $("#tipe").hide();
        $("#wisata").html("");
    }
});

$("select#tipe").change(function(){
    var tipeSelect = $(this).children("option:selected").val();

    showWisata(tipeSelect);
});
</script>
@endpush