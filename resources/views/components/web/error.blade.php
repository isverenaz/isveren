@if (Session::get('errors'))
    @if(!empty(Session::get('errors')) && is_array(json_decode(Session::get('errors'), true)))
        @foreach(json_decode(Session::get('errors'), true) as $key=>$error)
            <div class="col-12 mt-1">
                <div class="alert alert-danger" role="alert">
                    <div class="alert-body">{{ $error[0] }}</div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12 mt-1">
            <div class="alert alert-danger" role="alert">
                <div class="alert-body">{{ Session::get('errors') }}</div>
            </div>
        </div>
    @endif
@endif
@if (Session::get('success'))
    <div class="col-12 mt-1">
        <div class="alert alert-success" role="alert">
            <div class="alert-body">{{ Session::get('success') }}</div>
        </div>
    </div>
@endif
