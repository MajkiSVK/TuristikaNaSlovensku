@extends('master')

@section('class')
contest_gallery
@stop


@section('container')
    <div class="row justify-content-between ">
        <div class="d-none d-md-block col-md-4 text-break mt-3"><a href="{{URL::to($contest->slug)}}/gallery" class="btn btn-dark text-break">Galéria</a> </div>
        <div class=" col-12 col-md-4 text-center mt-2"> <a href="{{URL::to(route('home'))}}"><img src="{{asset('storage/tns.png')}}" class="w-100"> </a></div>

            <div class="col-12 col-md-4 text-right text-break mt-3"><b><a href="{{URL::to(route('home'))}}">{{session()->get('name')}}</a></b>
                <a href="{{URL::to(route('FbLogout'))}}" class="btn btn-primary text-break">Odhlásiť sa</a></div>
    </div>
    <hr>
   <h3> Nahrávanie súťažných fotiek pre súťaž : <b>{{$contest->name}}</b></h3>
    <hr>
    <div class="row justify-content-center">
        <form method="post" action="{{URL::current()}}/confirm" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="description">Popis fotky</label>
                <input type="text" id="description" name="description" class="form-control" placeholder="Podľa pravidiel súťaže">
            </div>

            <div class="form-group">
                <label for="photo">Súťažná fotografia</label>
                <input type="file" id="photo" name="photo" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-success d-block w-75 mx-auto mb-5">Nahrať</button>
        </form>
    </div>
@stop
