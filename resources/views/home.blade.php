@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="list-group">
                        <a href="{{ url('/room/add') }}" class="list-group-item">Add Room</a>
                        <a href="{{ url('/room/update') }}" class="list-group-item">Update room</a>
                        <a href="{{ url('/reservation/update') }}" class="list-group-item">Cancel Reservations</a>
                        <a href="{{ url('/available/rooms') }}" class="list-group-item">list available rooms</a>
                        <a href="{{ url('/not_available/rooms') }}" class="list-group-item">list not available rooms</a>
                        <a href="{{ url('/register') }}" class="list-group-item">Add Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
