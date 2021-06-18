@extends('master')

@section('class')
home
@stop


@section('container')
    <center>
        <img src="{{asset('storage/tns.png')}}" width="40%" class="m-0">
        <hr>
        <h1>
            <u>
                Tvoj profil
            </u>
        </h1>

        {{-- form body (empty divs just for new "row" xD--}}
        <div id="profile_body" class="row justify-content-center">
            {{--form header--}}
            <form method="post" action="{{URL::route('save_profile')}}">
                @csrf

                {{--Membership information--}}
                @if(Session::get("user")->member)
                <label for="user_name" class="col-3 text-right mb-3">
                    <b>
                        Členstvo
                    </b>
                </label>
                <input name="user_name" type="text" class="col-5 mb-3" value="Si členom FB skupiny Turistika na Slovensku" disabled>
                @else
                    <label for="user_name" class="col-3 text-right mb-3">
                        <b>
                            Členstvo
                        </b>
                        <a href="https://www.facebook.com/groups/82618591890" class="btn btn-outline-secondary" target="_blank">
                            Stať sa členom
                        </a>
                    </label>
                    <input name="user_name" type="text" class="col-5 mb-3" value="Niesi členom FB skupiny Turistika na Slovensku" disabled>
                @endif
                <div id="empty" class="col-12"></div>

                {{--user name input--}}
                <label for="user_name" class="col-3 text-right mb-3">
                    <b>
                        Meno
                    </b>
                </label>
                <input name="user_name" type="text" class="col-5 mb-3" value="{{$user['name']}}" disabled>

                <div id="empty" class="col-12"></div>

                {{--user mail input--}}
                <label for="user_mail" class="col-3 text-right mb-3">
                    <i>
                        (facebook)
                    </i>
                    <b>
                        E-mail
                    </b>
                </label>
                <input name="user_mail" type="text" class="col-5 mb-3" value="{{$user['email']}}" disabled>

                <div id="empty" class="col-12"></div>

                {{--contact mail input (custom mail for contact--}}
                <label for="contact_mail" class="col-3 text-right mb-3">
                    <b>
                        Kontaktný E-mail
                    </b>
                </label>
                <input name="contact_mail" type="email" class="col-5 mb-3" value="{{$user->settings()->where('type', 'contact_mail')->first()->value ?? ''}}">

                <div id="empty" class="col-12 text-center">
                    <i>
                        Telefónne číslo zadávajte bez znaku
                        <b>+</b> .
                        Napríklad 421 900 000 000, alebo 420 000 000 000
                    </i>
                </div>

                {{--user phone for contact--}}
                <label for="user_phone" class="col-3 text-right mb-3">
                    <b>
                        Telefónne číslo: +
                    </b>
                </label>
                <input name="user_phone" type="tel" class="col-5 mb-3" pattern="[0-9]{12}" value="{{$user['phone_number']}}">

                {{--info text--}}
                <div id="info" class="col-12 text-center">
                    <i>
                        Zmeniť je možné len biele polia (kontaktné údaje),
                        ostatné sú prevzaté z facebooku. Výherca súťaže je vždy kontaktovaný prioritne cez telefón
                    </i>
                </div>

                {{--Buttons--}}
                <input type="submit" class="btn btn-success col-3 " value="Uložiť">
                <a href="#" onclick="deleteContact()">
                    <span id="delete_contact" class="btn btn-danger col-3">
                        Vymazať kontaktné údaje
                    </span>
                </a>
                <a href="#" onclick="deleteProfile()">
                    <span id="delete_profile" class="btn btn-dark col-3">
                        Vymazať celý profil
                    </span>
                </a>
                <a href="{{URL::route('FbLogout')}}">
                    <span id="logout" class="btn btn-primary text-break col-2">
                        Odhlásiť sa
                    </span>
                </a>
            </form>

        </div>
        <hr>

        <h3>Prebiehajúce súťaže</h3>
        @forelse($active_contests as $contest)
            <a href="{{URL::current()}}/{{$contest->slug}}/gallery">
                {{$contest->name}}
                <br>
            </a>

            @empty

        @endforelse
    </center>



    <script>

        /*
        * Confirmation text for deleting contact information
        */
        function deleteContact() {
            if(confirm("Naozaj chceš vymazať svoje kontaktné údaje? V prípade že si zapojený/á do súťaže a " +
                "vyhráš, nebuemožné ťa kontaktovať a výhra prepadne ďalšiemu v poradí.")){
                window.location.href="{{ URL::route('delete_contact') }}";
            }
        }

        /*
        * Confirmation text for deleting user profile
         */
        function deleteProfile() {
            if(confirm("Naozaj chceš vymazať svoj profil? V prípade že si zapojený/á do súťaže, " +
                "budeš z nej automaticky vyradený/á")){
                window.location.href="{{ URL::route('delete_profile') }}";
            }
        }
    </script>
@stop
