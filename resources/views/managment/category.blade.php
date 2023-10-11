@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                    @include('managment.inc.sidebar')
            </div>
            <div class="col-md-8"> <i class="fa-solid fa-bars"></i>Category
                <a href="/management/category/create" class="btn btn-success btn-sm" style="float:right"><i
                        class="fa fa-plus" aria-hidden="true"></i>Create Category</a>
                <hr>
                @if (Session()->has('status'))
                    <div class="alert alert-success">
                        {{ Session()->get('status') }}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="/management/category/{{ $category->id }}/edit" class="btn btn-warning">Edit</a>
                                </td>
                                <td>
                                    <form action="/management/category/{{ $category->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="DELETE" class="btn btn-danger"/>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    @if ($categories->currentPage() > 1)
                        <a href="{{ $categories->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                    @endif
            
                    @if ($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="btn btn-primary">Next</a>
                    @endif
                </div>
            </div>

        </div>

    </div>
    </div>
@endsection
