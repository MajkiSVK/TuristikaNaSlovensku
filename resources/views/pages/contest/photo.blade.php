@extends('master')

@section('class')
    contest_photo
@stop


@section('container')
<div id="photo_body" class="vh-100">
<center>
    <div id="carouselExampleControls" class="carousel w-90" >
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img class="d-block w-100" src="https://localhost/turistika/{{$photo->resized_path}}" alt="First slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="{{$prev_id}}" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="{{$next_id}}" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>
    <span class=" "><b>{{$photo->description}}</b></span>

</center>
    <div id="photo_header" class="row justify-content-between">
        <span class="col-8 text-break"><small><u>Autor: </u></small><b>{{$photo->user->name}}</b></span>
        <div class="col-4 text-right"> <span class="btn btn-success">Lajk 1000</span></div>
    </div>
</div>



@stop
