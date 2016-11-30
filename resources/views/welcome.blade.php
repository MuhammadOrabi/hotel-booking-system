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
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h3 class="panel-title">~Welcome and Please make a reservation~</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" method="POST" action="{{ url('/rooms') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="in">Check-In</label>
                    <input type="date" id="in" class="form-control" name="in_date" min="2016-10-31">
                    <label for="out">Check-Out</label>
                    <input type="date" id="out" class="form-control" name="out_date" min="2016-10-31">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Make Reservation</button>
                </div>
            </form>  
        </div>
    </div>
</div>
@endsection