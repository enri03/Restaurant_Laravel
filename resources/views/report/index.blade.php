@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Main Functions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reports</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <form action="/report/show" method="GET">
                <div class="col-md-12">
                    <div class="container">
                        <div class='col-md-5'>
                            <div class="form-group">
                                <div class='input-group date' id='dayStart' data-target-input="nearest">
                                    Start Date
                                    <input type='text' class="form-control datetimepicker-input" data-target="#dayStart" name="dayStart" />
                                    <div class="input-group-append" data-target="#dayStart" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-5'>
                            <div class="form-group">
                                <div class='input-group date' id='dayFinish' data-target-input="nearest">
                                    End Date
                                    <input type='text' class="form-control datetimepicker-input" data-target="#dayFinish" name="dayFinish" />
                                    <div class="input-group-append" data-target="#dayFinish" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Show Report">
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
        <script type="text/javascript">
            $(function () {
                $('#dayStart').datetimepicker({
                    format: 'YYYY-MM-DD',
                    icons: {
                        time: "fas fa-clock",
                        date: "fas fa-calendar",
                        up: "fas fa-chevron-up",
                        down: "fas fa-chevron-down"
                    }
                });
                $('#dayFinish').datetimepicker({
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    icons: {
                        time: "fas fa-clock",
                        date: "fas fa-calendar",
                        up: "fas fa-chevron-up",
                        down: "fas fa-chevron-down"
                    }
                });
                $("#dayStart").on("change.datetimepicker", function (e) {
                    $('#dayFinish').datetimepicker('minDate', e.date);
                });
                $("#dayFinish").on("change.datetimepicker", function (e) {
                    $('#dayStart').datetimepicker('maxDate', e.date);
                });
            });
        </script>
    @endpush
@endsection
