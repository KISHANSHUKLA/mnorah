@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card-group" style="background: #fff;border-radius: 10px;
        box-shadow: 10px 10px 10px 10px #ccc;">
          <div class="col-md-7" style="padding-left:0px;">
                    <div class="loginImage">
                        <img src="{{ asset('image/loginbg.jpg') }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card-body">
                        @if(\Session::has('message'))
                            <p class="alert alert-info">
                                {{ \Session::get('message') }}
                            </p>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="loginLogo">
                            <img src="{{ asset('image/ic_logo_bottom.png') }}">
                        </div>
                            {{-- <h1>{{ env('APP_NAME', 'Permissions Manager') }}
</h1> --}}
                            <h4 class="text-muted loginText">Log In</h4>
    
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                <input name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="Email" value="{{ old('email', null) }}">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
    
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="Password">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
    
                            {{-- <div class="input-group mb-4">
                                <div class="form-check checkbox">
                                    <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                                    <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                        Remember me
                                    </label>
                                </div>
                            </div> --}}
    
                            <div class="row">
                                <div class="col-12">
                                    <button  style="width:100%" type="submit" class="btn btn-primary px-4 loginBtn">
                                        Login
                                    </button>
                                </div>
                                <div class="col-12 text-left">
                                    <a  style="color:#000;"class="btn btn-link px-0" href="{{ route('password.request') }}">
                                        Forgot your password?
                                    </a>
    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
        </div>
    </div>
</div>
@endsection
