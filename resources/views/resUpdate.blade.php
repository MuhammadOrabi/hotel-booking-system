@extends('layouts.admin')

@section('content')
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
    <div class="col-md-12 panel-info">
        <div class="content-box-header panel-heading text-center">
            <div class="panel-title ">Cancel reservation </div>
        </div>
        <div class="content-box-large box-with-header">
            <form class="form-horizontal" method="POST" action="{{ url('/update/reservation') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-5 col-sm-offset-3">
                      <input type="text" class="form-control" name="room_id"  placeholder="Room Number">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 col-sm-offset-3">
                      <input type="text" class="form-control" name="floor"  placeholder="Floor Number">
                    </div>
                </div><div class="form-group">
                    <div class="col-sm-5 col-sm-offset-3">
                      <input type="text" class="form-control" name="guest_id" placeholder="Guest SSN">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 col-sm-offset-3">
                        <label for="in">Check-in</label>
                        <input type="date" id="in" class="form-control" name="in_date" min="2016-10-31">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-10">
                      <button type="submit" class="btn btn-primary">Cancel Reservation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection