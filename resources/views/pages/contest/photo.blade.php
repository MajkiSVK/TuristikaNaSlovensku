@extends('master')

@section('class')
    contest_photo
@stop


@section('container')
<div id="photo_body" class="row justify-content-center vh-100">
    <span class="col-10 col-md-2 text-break mt-3"><small>Fotografia od</small><br><b>{{$photo['Author']}}</b></span>
    <span class="col-12 col-md-8 text-center text-break mt-3"><h2>{{$photo['Description']}}</h2></span>
    <div class="col-2 order-first order-md-0 col-md-2 text-right mt-3"> <span class="btn btn-success">Lajk 1000</span></div>

    <div class="col-12 text-center"> <img src="https://localhost/turistika/{{$photo['URL']}}" class="w-75"></div>
{{var_dump($request->photo_id)}}
{{var_dump($request->contest)}}</div>
</div>
@stop
