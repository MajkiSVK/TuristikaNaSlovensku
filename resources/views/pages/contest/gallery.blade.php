@extends('master')

@section('class')
contest_gallery
@stop


@section('container')

    <div class="row justify-content-between ">
        <div class="col-12 col-md-4 text-break mt-3">
            <a href="{{URL::current()}}/upload" class="btn btn-dark text-break">
                Nahrať fotku
            </a>
        </div>
       <div class="col-12 col-md-4 text-center mt-2">
           <a href="{{URL::to(route('home'))}}">
               <img src="{{asset('storage/tns.png')}}" class="w-100">
           </a>
       </div>
        {{--If the user is logged in, show the Logout button, else show the Login button--}}
        @if(Session::get("user"))
            <div class="col-12 col-md-4 text-right text-break mt-3">
                <b>
                    <a href="{{URL::to(route('home'))}}">
                        {{Session::get("user")->name}}
                    </a>
                </b>
                <a href="{{URL::to(route('FbLogout'))}}" class="btn btn-primary text-break">
                    Odhlásiť sa
                </a>
            </div>
        @else
            <div class="col-12 col-md-4 text-right text-break mt-3">
                <a href="{{URL::to(route('FbLogin'))}}" class="btn btn-primary text-break">
                    Prihlásiť sa
                </a>
            </div>
        @endif

    </div>

    <hr>
    <h1 class="text-center">{{$contest->name}}</h1>
    <hr>
    {{--show gallery photos--}}
    <div id="gallery_body" class="row ">
        @forelse($contest->photos as $photo)
            <div class="col-12 col-md-3 mb-2 img-thumbnail gallery_img_div text-center ">
                <a href="{{URL::current()}}/photo/{{$photo->id}}">
                    <img src="{{URL::asset($photo->thumb_path)}}" class="gallery_img">
                </a>
            </div>
            @empty Nič tu niejeeeeeee

        @endforelse
    </div>
@stop
