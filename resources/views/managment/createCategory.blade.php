@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @include('managment.inc.sidebar')
            </div>
            <div class="col-md-8"> Create a Category
                <hr>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/management/category" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="categoryName">CategoryName</label>
                        <input type="text" class="form-control" name="name" placeholder="Category...">
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>

        </div>

    </div>
    </div>
@endsection
