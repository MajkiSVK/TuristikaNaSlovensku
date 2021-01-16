@extends('master')

@section('class')
contest_gallery
@stop


@section('container')

<div class="row justify-content-between ">
    <div class="d-none d-md-block col-md-4 text-break mt-3"></div>
   <div class=" col-12 col-md-4 text-center mt-2"> <img src="{{asset('storage/tns.png')}}" class="w-100"> </div>
    @if(session()->get('name'))
        <div class="col-12 col-md-4 text-right text-break mt-3"><b>{{session()->get('name')}}</b>
        <a href="{{URL::to(route('FbLogout'))}}" class="btn btn-primary text-break">Odhlásiť sa</a></div>
    @else
        <div class="col-12 col-md-4 text-right text-break mt-3">
            <a href="{{URL::to(route('FbLogin'))}}" class="btn btn-primary text-break">Prihlásiť sa</a></div>
    @endif

</div>

<hr>
<h1 class="text-center">{{$name}}</h1>
<hr>

<div id="gallery_body" class="row ">
    @forelse($images as $image)
        <div class="col-12 col-md-3 mb-2 img-thumbnail gallery_img_div text-center "><img src="https://localhost/turistika/{{$image}}" class="gallery_img"></div>
        @empty Nič tu niejeeeeeee

    @endforelse
</div>
@stop
