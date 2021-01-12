@extends('master')

@section('class')
home
@stop


@section('container')
    <center>
        <img src="{{asset('storage/tns.png')}}" width="40%" class="m-0">
        <hr>
        <h1><u>Tvoj profil</u> </h1>

        {{----}}
        <div id="profile_body" class="row justify-content-center">
            <form method="post" action="{{URL::route('save_profile')}}"> @csrf
                <label for="user_name" class="col-3 text-right mb-3"><b>Meno</b></label>
                <input name="user_name" type="text" class="col-5 mb-3" value="{{$user['name']}}" disabled>

                <div id="empty" class="col-12"></div>

                <label for="user_mail" class="col-3 text-right mb-3"><i>(facebook)</i><b> E-mail</b></label>
                <input name="user_mail" type="text" class="col-5 mb-3" value="{{$user['email']}}" disabled>

                <div id="empty" class="col-12"></div>

                <label for="contact_mail" class="col-3 text-right mb-3"><b>Kontaktný E-mail</b></label>
                <input name="contact_mail" type="email" class="col-5 mb-3" value="{{$user['email']}}">

                <div id="empty" class="col-12 text-center"><i>Telefónne číslo zadávajte bez znaku <b>+</b> . Napríklad 421 900 000 000, alebo 420 000 000 000 </i></div>

                <label for="user_phone" class="col-3 text-right mb-3"><b>Telefónne číslo: +</b></label>
                <input name="user_phone" type="tel" class="col-5 mb-3" pattern="[0-9]{12}" value="{{$user['phone_number']}}">

                <div id="info" class="col-12 text-center"><i>Zmeniť je možné len biele polia (kontaktné údaje),
                        ostatné sú prevzaté z facebooku. Pri výherca súťaže je vždy kontaktovaný prioritne cez telefón</i></div>

                <input type="submit" class="btn btn-success col-3 " value="Uložiť">
                <a href="{{ URL::route('delete_contact') }}"><span id="delete_contact" class="btn btn-danger col-3">Vymazať kontaktné údaje</span></a>
                <a href="{{URL::route('delete_profile')}}"><span id="delete_profile" class="btn btn-dark col-3">Vymazať celý profil</span></a>
                <a href="{{URL::route('FbLogout')}}"><span id="logout" class="btn btn-primary text-break col-2">Odhlásiť sa</span></a>
            </form>

        </div>
    </center>
@stop
