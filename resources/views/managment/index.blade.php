@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @include('managment.inc.sidebar')
            </div>
            <div class="col-md-4">Content</div>
        </div>
    </div>
@endsection
