@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @include('managment.inc.sidebar')
            </div>
            <div class="col-md-8"> <i class="fa-solid fa-chair"></i>Table
                <a href="/management/table/create" class="btn btn-success btn-sm" style="float:right"><i class="fa fa-plus"
                        aria-hidden="true"></i>Create Table</a>
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
                            <th>Table</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tables as $table)
                        <tr>
                            <td>{{$table->id}}</td>
                            <td>{{$table->name}}</td>
                            <td>{{$table->status}}</td>
                            <td><a href="/management/table/{{ $table->id }}/edit" class="btn btn-warning">Edit</a></td>
                            <td>
                                <form action="/management/table/{{ $table->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="DELETE" class="btn btn-danger"/>
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
