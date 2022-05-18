@extends('layouts.auth')

@section('content')
<div id="login-page" class="row">
    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="input-field col s12">
                <h5 class="ml-4">Masuk</h5>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12 {{ $errors->has('email') ? ' has-error' : '' }}">
                <i class="material-icons prefix pt-2">person_outline</i>
                <input id="username" name="usem" type="text" class="validate">
                <label for="username" class="center-align">Username</label>
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
            <!-- <div class="row">
                <div class="col s12 m12 l12 ml-2 mt-1">
                <p>
                    <label>
                    <input type="checkbox" {{ old('remember') ? 'checked' : '' }} name="remember"/>
                    <span>Remember Me</span>
                    </label>
                </p>
                </div>
            </div> -->
            <div class="row">
                <div class="input-field col s12">
                    <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">
                        Masuk
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                <p class="margin center-align medium-small"><a href="{{ route('register') }}">Daftar Akun</a></p>
                </div>
                <div class="input-field col s12 m12 l12">
                <p class="margin center-align medium-small"><a href="{{ route('password.request') }}">Lupa password ?</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
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
