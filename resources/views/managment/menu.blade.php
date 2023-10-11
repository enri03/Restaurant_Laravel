@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @include('managment.inc.sidebar')
            </div>
            <div class="col-md-8"><i class="fa-solid fa-burger"></i>Menu
                <a href="/management/menu/create" class="btn btn-success btn-sm" style="float:right"><i class="fa fa-plus"
                        aria-hidden="true"></i>Create Menu</a>
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
                            <th>Name</th>
                            <th>Price</th>
                            <th>Picture</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->price }}</td>
                                <td style="width:120px; height:120px"><img
                                        src="{{ asset('menu_image') }}/{{ $menu->image }}" alt="{{ $menu->name }}"
                                        class="img-thumbnail"></td>
                                <td>{{ $menu->description }}</td>
                                <td>{{ $menu->category->name }}</td>
                                <td><a href="/management/menu/{{ $menu->id }}/edit" class="btn btn-warning">Edit</a>
                                </td>
                                <td>
                                    <form action="/management/menu/{{ $menu->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="DELETE" class="btn btn-danger" />
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    </div>
@endsection
