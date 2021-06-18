@extends('master')

@section('class')
    contest_photo
@stop


@section('container')
<div id="photo_body" class="min-vh-100">

<center>
    <a href="{{URL::to(route('home'))}}/{{Request::segment(1)}}/gallery">
        <span class="btn-secondary rounded float-right p-1 mt-3">X</span>
    </a>

    <div id="carouselExampleControls" class="carousel w-90" >
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block max-width-100 max-height-90 mt-3" src="{{URL::asset($photo->resized_path)}}" alt="First slide">
            </div>
        </div>
        {{--If the previous image is existing--}}
        @if($photo->prev)
            <a class="carousel-control-prev bg-dark" href="{{$photo->prev}}" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">
                    Previous
                </span>
            </a>
        @endif

        {{--If the next image is existing--}}
        @if($photo->next)
            <a class="carousel-control-next bg-dark" href="{{$photo->next}}" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">
                    Next
                </span>
            </a>
        @endif
    </div>
    <span class=" "><b>{{$photo->description}}</b></span>

</center>
    <div id="photo_header" class="row justify-content-between">
        <span class="col-8 text-break">
            <small>
                <u>Autor: </u>
            </small>
            <b>
                {{$photo->user->name}}
            </b>
        </span>

        {{--button for adding like, if the user did not vote yet--}}
        @if(empty($like))
            <div class="col-4 text-right">
                <a href="{{URL::to(route('home'))}}/like/add/{{Request::segment(1)}}/{{$photo->id}}">
                    <span class="btn btn-success">
                        <img src="{{URL::asset('storage/like.png')}}" class="w-25"> {{$like_number}}
                    </span>
                </a>
            </div>

        {{--button for deleting like, if the user already voted --}}
        @else
            <div class="col-4 text-right">
                <a href="{{URL::to(route('home'))}}/like/delete/{{Request::segment(1)}}/{{$photo->id}}">
                    <span class="btn btn-success"><img src="{{URL::asset('storage/liked.png')}}" class="w-25"> {{$like_number}}
                    </span>
                </a>
            </div>
        @endif
    </div>
</div>



@stop
