@extends('master')

@section('class')
facebook_login
@stop


@section('container')

    <div id="login_body" class="login_body row align-items-center justify-content-center vh-100">

        {{-- Facebook group logo--}}
        <img src="{{asset('storage/tns.png')}}" width="60%" class="m-0">

        <p class="col-12 text-center">
            Vitajte na stránkach
                <b>
                    Facebook skupiny Turistika na Slovensku
                </b>
            <br>
            Aby ste sa mohli zúčastniť našich súťaží, musíte sa prihlásiť
        </p>

        {{-- Facebook login button--}}
        <a href="{{URL::to('/facebook/redirect')}}">
            <span id="login_button" class="btn btn-info text-light p-3 rounded-pill">
               Prihlásiť sa cez Facebook
            </span>
        </a>

    </div>

@stop
