@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @include('managment.inc.sidebar')
            </div>
            <div class="col-md-8"> Edit Category
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

                <form action="/management/category/{{ $category->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="categoryName">CategoryName</label>
                        <input type="text" class="form-control" name="name" placeholder="Category..."
                            value="{{ $category->name }}">
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>

        </div>

    </div>
    </div>
@endsection
