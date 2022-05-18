{{ csrf_field() }}

<div class="col m12">

    <div class="row">
        <div class="input-field col s12{{ $errors->has('nama_hotel') ? ' has-warning' : '' }}">
            <input name="nama" value="{{ (!empty($data[0]->nama_hotel))? $data[0]->nama_hotel : $data[0]->nama }}" id="nama" type="text" class="validate" readonly disabled>
            <label for="nama">
            @if($data[0]->nama_hotel)
                Nama Hotel
            @else
                Nama Wisata
            @endif
            </label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('alamat') ? ' has-warning' : '' }}">
            <input name="username" value="{{ (!empty($data[0]->alamat_hotel))? $data[0]->alamat_hotel : $data[0]->alamat }}" readonly disabled id="alamat" type="text" class="validate">
            <label for="alamat">Alamat</label>
        </div>
    </div>

    @if($data[0]->nama_hotel)
    <div class="row">
        <div class="input-field col s12{{ $errors->has('email_hotel') ? ' has-warning' : '' }}">
            <input name="email_hotel" value="{{ $data[0]->email_hotel }}" id="email_hotel" type="text" class="validate" readonly disabled>
            <label for="email_hotel">Email Hotel</label>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="input-field col s12{{ $errors->has('jenis_hotel') ? ' has-warning' : '' }}">
            <input name="email" value="{{ (!empty($data[0]->jenis_hotel))? $data[0]->jenis_hotel : $data[0]->tipe_wisata }}" readonly disabled id="jenis" type="text" class="validate">
            <label for="jenis">
                @if($data[0]->nama_hotel)
                    Jenis Hotel
                @else
                    Tipe Wisata
                @endif
            </label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12{{ $errors->has('tanggal_pengajuan') ? ' has-warning' : '' }}">
            <input name="tanggal_pengajuan" value="{{ $data[0]->tanggal_pengajuan }}" id="tanggal_pengajuan" type="text" class="validate" readonly disabled>
            <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s4">
            <p>
                <a href="{{ route('template_doc.download', ['name'=>$data[0]->path_file_susunan_pengurus]) }}">
                    <i class="material-icons" style="vertical-align: middle;">archive</i> &nbsp <span style="vertical-align: middle;">Dokumen Susunan Pengurus</span>
                </a>
            </p>
        </div>
        <div class="input-field col s4">
            <p>
                <a href="{{ route('template_doc.download', ['name'=>$data[0]->path_file_permohonan_registrasi]) }}">
                    <i class="material-icons" style="vertical-align: middle;">archive</i> &nbsp <span style="vertical-align: middle;">Dokumen Permohonan Registrasi</span>
                </a>
            </p>
        </div>
        <div class="input-field col s4">
            <p>
                <a href="{{ route('template_doc.download', ['name'=>$data[0]->path_file_foto_deskripsi]) }}">
                    <i class="material-icons" style="vertical-align: middle;">archive</i> &nbsp <span style="vertical-align: middle;">Dokumen Foto dan Deskripsi</span>
                </a>
            </p>
        </div>
    </div>

    <div class="form-group" id="wisata"></div>

    <div class="input-field col s12">
        <a href="{{ route('backend::approval.index') }}" class="btn waves-effect waves-light left" role="button">Kembali
            <i class="material-icons left">arrow_back</i>
        </a>
        <button class="btn waves-effect waves-light right" type="submit" name="action">Approve
            <i class="material-icons right">check_circle</i>
        </button>
    </div>
</div>

@push('script')
<script src="{{ asset('vendors/formatter/jquery.formatter.min.js') }}"></script>
<script>

</script>
@endpush