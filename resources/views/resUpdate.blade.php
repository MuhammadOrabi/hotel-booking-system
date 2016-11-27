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
    @if(isset($success))
        <div class="alert alert-success" role="alert">
            {{$success}}
        </div>
    @endif
    @if(isset($faild))
        <div class="alert alert-danger" role="alert">
            {{$faild}}
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h3 class="panel-title">~Cancel Reservation~</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ url('/update/reservation') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="room_id"  placeholder="Room Number">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="guest_id" placeholder="Guest SSN">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                        <label for="in">Check-in</label>
                        <input type="date" id="in" class="form-control" name="in_date" min="2016-10-31">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Cancel Reservation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection