@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($rooms as $room)
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Room {{ $room->id }}</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>Type: {{ $room->name }}</li>
                    <li>Description:<br><p>{{ $room->description }}<p></li>
                    <li>Max Occupancy: {{ $room->max }} </li>
                    <li>Price: {{ $room->base_price }}</li>
                </ul>
            </div>
            @if(isset($dates))
                <div class="panel-footer">
                    <form method="POST" action="{{ url('/book') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $room->id }}">
                        <input type="hidden" name="in_date" value="{{ $dates[0] }}">
                        <input type="hidden" name="out_date" value="{{ $dates[1] }}">
                        <button type="submit" class="btn btn-link">Book</button>
                    </form>
                </div>
            @elseif($room->reservations != null)
                @foreach($room->reservations as $res)
                        <hr>
                        <ul>
                            <li>Check-In: {{ $res->in_day }} / {{ $res->in_month }} / {{ $res->in_year }} </li>
                            <li>Check-out: {{ $res->out_day }} / {{ $res->out_month }} / {{ $res->out_year }} </li>
                            <li>Guest SSN: {{ $res->guest->id }}</li>
                            <li>Guest Name: {{ $res->guest->name }}</li>
                            <li>Guest E-mail: {{ $res->guest->email }}</li>
                        </ul>
                    
                @endforeach
            @endif
        </div>
    @endforeach
</div>
@endsection