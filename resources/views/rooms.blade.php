@extends('layouts.app')

@section('content')
<div class="container">
<?php $types = \App\room_type::get();?>
    @if($types->first() != null)
        <form class="form-horizontal" method="POST" action="{{ url('/type/rooms') }}">
        {{ csrf_field() }}
            <div class="form-group">
                <div class="col-sm-5">
                    @if(isset($dates))
                        <input type="hidden" name="in_date" value="{{ $dates[0] }}">
                        <input type="hidden" name="out_date" value="{{ $dates[1] }}">
                    @endif
                    <label for="sel1">Select room type</label>
                    <select  class="form-control" name="type_name" id="sel1">
                    @foreach($types as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <button type="submit">Get Rooms</button>
        </form>
    @else
        <div class="alert alert-danger text-center" role="alert">
            <h2 class="text-center">there are No rooms avilable!!</h2>
        </div>
    @endif


    @if(isset($rooms))
        @foreach($rooms as $room)
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Room {{ $room->id }}</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        <li>Type: {{ $room->room_type->name }}</li>
                        <li>Floor: {{ $room->floor }}</li>
                        <li>Description:<br><p>{{ $room->room_type->description }}<p></li>
                        <li>Max Occupancy: {{ $room->room_type->max }} </li>
                        <li>Price: {{ $room->room_type->base_price }}</li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <form method="POST" action="{{ url('/book') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $room->id }}">
                        <input type="hidden" name="floor" value="{{ $room->floor }}">
                        <input type="hidden" name="in_date" value="{{ $dates[0] }}">
                        <input type="hidden" name="out_date" value="{{ $dates[1] }}">
                        <button type="submit" class="btn btn-link">Book</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection