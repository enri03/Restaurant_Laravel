@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">
                        <div class="col-md-4">
                            <a href="/managment">
                            <h4>Managment</h4>
                            <img src="{{asset('images/manage.png')}}"  style="width: 50px !important;">
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="/cashier">
                            <h4>Cashier</h4>
                            <img src="{{asset('images/cashier.png')}}" style="width: 50px !important;">
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="/report">
                            <h4>Reports</h4>
                            <img src="{{asset('images/report.png')}}" style="width: 50px !important;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
