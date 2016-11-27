@extends('layouts.app')

@section('content')
<div class="container">
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h3 class="panel-title">~ADD Room~</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ url('/res') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="id"  placeholder="SSN(Social Security Number)">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="name" placeholder="name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="email" class="form-control" name="email" placeholder="email">
                    </div>
                </div>
                <input type="hidden" name="room_id" value="{{ $dates[0] }}">
                <input type="hidden" name="in_date" value="{{ $dates[1] }}">
                <input type="hidden" name="out_date" value="{{ $dates[2] }}">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Book</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection