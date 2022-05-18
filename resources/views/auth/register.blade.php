@extends('layouts.auth')

@section('content')
<div id="login-page" class="row">
    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8" style="margin-top: 20%; font-size: 11px !important;">
        <form class="login-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <div class="row">
                <div class="input-field col s12">
                <h5 class="ml-4"></h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                <h5 class="ml-4">Daftar Akun</h5>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('kategori_akun') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">place</i>
                <select id="kategori_akun" name="kategori_akun" class="validate" onchange="select_kategori(this)">
                    <option value="deswita">Destinasi Wisata</option>
                    <option value="hotel">Hotel</option>
                </select>
                <label for="kategori_akun" class="center-align">Kategori Akun</label>
                @if ($errors->has('kategori_akun'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('kategori_akun') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin" id="field_tipe_wisata">
                <div class="input-field col s12 {{ $errors->has('tipe_wisata') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">spa</i>
                <select id="tipe_wisata" name="tipe_wisata" class="validate">
                    <option value="obyek">Obyek Wisata</option>
                    <option value="desa">Desa Wisata</option>
                </select>
                <label for="tipe_wisata" class="center-align">Tipe Wisata</label>
                </div>
            </div>
            <div class="row margin" id="field_kecamatan">
                <div class="input-field col s12 {{ $errors->has('kecamatan') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">gps_not_fixed</i>
                <select id="kecamatan" name="kecamatan" class="validate" onchange="select_kecamatan(this)">
                    <option value=""></option>
                    @foreach(\App\Kecamatan::get() as $kecamatan)
                        <option value="{{ $kecamatan->id }}"{{ (@$data->kelurahan->kecamatan->id == $kecamatan->id)? ' selected' : '' }}>{{ ucwords($kecamatan->nama) }}</option>
                    @endforeach
                </select>
                <label for="kecamatan" class="center-align">Kecamatan</label>
                @if ($errors->has('kecamatan'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('kecamatan') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin" id="field_kelurahan">
                <!-- <div class="input-field col s12" id="">
                    <i class="material-icons prefix pt-2">gps_fixed</i>
                    <select id="kelurahan" name="kelurahan" class="validate">
                    </select>
                    <label for="kelurahan" class="center-align">Kelurahan</label>
                </div> -->
            </div>
            <div class="row margin" style="display: none" id="field_hotel">
                <div class="input-field col s12 {{ $errors->has('jenis') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">hotel</i>
                <select id="jenis" name="jenis" class="validate">
                    <option value="bintang">Bintang</option>
                    <option value="nonbintang">Non Bintang</option>
                </select>
                <label for="jenis" class="center-align">Jenis Hotel</label>
                @if ($errors->has('jenis'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('jenis') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('nama_destinasi') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">hotel</i>
                <input id="nama_destinasi" value="{{ old('nama_destinasi') }}" name="nama_destinasi" type="text" class="validate">
                <label for="nama_destinasi" class="center-align">Nama Destinasi/Hotel</label>
                @if ($errors->has('nama_destinasi'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('nama_destinasi') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('username') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">person_outline</i>
                <input id="username" value="{{ old('username') }}" name="username" type="text" class="validate">
                <label for="username" class="center-align">Username</label>
                @if ($errors->has('username'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('username') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('name') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">person_outline</i>
                <input id="name" name="name" value="{{ old('name') }}" type="text" class="validate">
                <label for="name" class="center-align">Nama</label>
                @if ($errors->has('name'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('name') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('alamat') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">directions</i>
                <input id="alamat" name="alamat" value="{{ old('alamat') }}" type="text" class="validate">
                <label for="alamat" class="center-align">Alamat</label>
                @if ($errors->has('name'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('alamat') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('email') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">email</i>
                <input id="email" name="email" value="{{ old('email') }}" type="text" class="validate">
                <label for="email" class="center-align">Email</label>
                @if ($errors->has('email'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('email') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('password') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">lock_outline</i>
                <input id="password" name="password" type="password" class="validate">
                <label for="password" data-error="wrong" data-success="right">Password</label>
                @if ($errors->has('password'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('password') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">lock_outline</i>
                <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                <label for="password_confirmation" data-error="wrong" data-success="right">Ulangi Password</label>
                @if ($errors->has('password_confirmation'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('password_confirmation') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                </div>
            </div>

            <div class="row margin">
                <div class="col s12">
                    <div class="card-alert card orange lighten-5">
                        <div class="card-content orange-text">
                            <p style="font-weight: 600;">Syarat Password:</p>
                            <p>* Jumlah karakter minimal 8 karakter.</p>
                            <p>* Memuat kombinasi huruf besar kecil, angka, dan karakter.</p>
                        </div>
                        <button type="button" class="close orange-text" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12 m12 l12">
                    <p class="margin left-align medium-small"><a href="{{ route('template_doc.index') }}">Belum punya template dokumen? Download template dokumen</a></p>
                </div>
            </div><br>

            <!-- UPLOAD DOC SUSUNAN PENGURUS -->
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('doc_susunan_pengurus') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">insert_drive_file</i>
                <label for="doc_susunan_pengurus" class="center-align" style="margin-top: -6%; color: #8b8594;">Dokumen Susunan Pengurus</label>
                @if ($errors->has('doc_susunan_pengurus'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('doc_susunan_pengurus') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                <input type="file" name="doc_susunan_pengurus" class="form-control" id="doc_susunan_pengurus">
                </div>
            </div><br>

            <!-- UPLOAD DOC PERMOHONAN REGISTRASI -->
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('doc_permohonan_registrasi') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">insert_drive_file</i>
                <label for="doc_permohonan_registrasi" class="center-align" style="margin-top: -6%; color: #8b8594;">Dokumen Permohonan Registrasi</label>
                @if ($errors->has('doc_permohonan_registrasi'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('doc_permohonan_registrasi') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                <input type="file" name="doc_permohonan_registrasi" class="form-control" id="doc_permohonan_registrasi">
                </div>
            </div><br>

            <!-- UPLOAD DOC FOTO DESKRIPSI -->
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('doc_foto_deskripsi') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">insert_drive_file</i>
                <label for="doc_foto_deskripsi" class="center-align" style="margin-top: -6%; color: #8b8594;">Dokumen Foto dan Deskripsi</label>
                @if ($errors->has('doc_foto_deskripsi'))
                <div class="card-alert card gradient-45deg-amber-amber">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">warning</i> {{ $errors->first('doc_foto_deskripsi') }}</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                <input type="file" name="doc_foto_deskripsi" class="form-control" id="doc_foto_deskripsi">
                </div>
            </div>

            <br>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('captcha') ? ' has-error' : '' }}">
                    <div class="captcha" style="margin-top: 15px;">
                        <span>{!! captcha_img() !!}</span>
                        <button type="button" class="btn btn-success btn-refresh" onclick="refreshCaptcha()" style="    margin-top: -6%; margin-left: 3%; background-color: #feb200;">
                            <i class="material-icons prefix pt-2" style="font-size: x-large; width: auto; position: static;">refresh</i>
                        </button>
                    </div>
                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                    <label for="captcha" data-error="wrong" data-success="right" style="font-size: large;">Captcha</label>
                    @if ($errors->has('captcha'))
                    <div class="card-alert card gradient-45deg-amber-amber">
                        <div class="card-content white-text">
                            <p>
                                <i class="material-icons">warning</i> {{ $errors->first('captcha') }}</p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="input-field col s12">
                    <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">
                        Daftar
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <p class="margin center-align medium-small"><a href="{{ route('login') }}">Saya sudah punya akun</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    
    function select_kategori(e) {
        var selected = e.value

        if (selected == 'hotel') {
            $("#field_hotel").show()
            $("#field_tipe_wisata").hide()
            $("#field_kecamatan").hide()
            $("#field_kelurahan").hide()
        } else {
            $("#field_hotel").hide()
            $("#field_tipe_wisata").show()
            $("#field_kecamatan").show()
            $("#field_kelurahan").show()
        }
    }

    function select_kecamatan(e) {
        var kecamatanId = e.value

        $.ajax({
            type:'GET',
            url:"{{ url('getKelurahan') }}/"+kecamatanId,
            // data:"id=" + propinsi,
            success: function(html){
                dataHtml = "<div class=\"input-field col s12\"><div class=\"\">";
                dataHtml += "<i class=\"material-icons prefix pt-2\">gps_fixed</i><label for=\"kelurahan\">Kelurahan</label>";
                dataHtml += "<select id=\"kelurahan\" name=\"kelurahan\" class=\"browser-default\" style=\"margin-left: 9%; width: 91%;\">\"";
                html.forEach(function(item, index){
                    dataHtml += "<option value='"+item.id+"'>"+ item.nama +"</option>";
                });
                dataHtml += "</select></div></div>";

                $("#field_kelurahan").html(dataHtml)
            }
        });
    }

    function refreshCaptcha() {
        $.ajax({
            type:'GET',
            url:"{{ url('refresh_captcha') }}",
            success:function(data){
                $(".captcha span").html(data.captcha);
            }
        });
    }

</script>

