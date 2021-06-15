@if ($message = Session('success'))
    <div class="alert alert-success alert-block mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session('error'))
    <div class="alert alert-danger alert-block mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session('warning'))
    <div class="alert alert-warning alert-block mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session('info'))
    <div class="alert alert-info alert-block mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session('top3'))
    <div class="alert alert-info alert-block mt-2">
        <button type="button" class="close" data-dismiss="alert" onclick="{{session()->forget('top3')}}">×</button>
        <strong>{{ $message }}</strong>
        <a href="{{ URL::route('monthly_best_create')}}" class="btn btn-dark">Prejsť na vytváranie</a>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mt-2">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
