@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @include('managment.inc.sidebar')
            </div>
            <div class="col-md-8"> Edit Table
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

                <form action="/management/table/{{ $table->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tableName">Table Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Table..."
                            value="{{ $table->name }}">
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>

        </div>

    </div>
    </div>
@endsection
