@extends('layouts.app');
@section('content')
    ;
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @include('managment.inc.sidebar')
            </div>
            <div class="col-md-8"><i
                class="fa-solid fa-burger"></i> Edit Menu
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

                <form action="/management/menu/{{$menu->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="menuName">Menu Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Menu name..." value="{{$menu->name}}">
                    </div>
                    <div class="form-group">
                        <label for="menuPrice">Menu Price</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" value="{{$menu->price}}">
                            <span class="input-group-text">.00</span>
                          </div>
                    </div>
                    <div class="form-group">
                        <label for="menuImage">Menu Image</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" name="image" >
                          </div>
                    </div>
                    <div class="form-group">
                        <label for="menuName">Menu Description</label>
                        <input type="text" class="form-control" name="description"  value="{{$menu->description}}">
                    </div>
                    <div class="form-group mt-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Categories</label>
                            <select class="form-select" id="inputGroupSelect01" name="category_id">
                              <option selected value="{{$menu->category->id}}">{{$menu->category->name}} </option>
                              @foreach ($categories as $category)
                              <option value="{{$category->id}}">{{$category->name}}</option>

                              @endforeach
                            </select>
                          </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>

        </div>

    </div>
    </div>
@endsection
