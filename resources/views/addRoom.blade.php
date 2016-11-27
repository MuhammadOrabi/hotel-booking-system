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
    @if(isset($room))
        <div class="alert alert-success" role="alert">
            Room is created
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h3 class="panel-title">~ADD Room~</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ url('/add/rooms') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="id"  placeholder="Room Number">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="name" placeholder="name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="max" placeholder="Max Occupancy">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="price" placeholder="Price">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                        <textarea class="form-control" rows="3" name="description" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5">
                        <label class="radio-inline">
                            <input type="radio" name="status" id="inlineRadio1" value="1"> Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" id="inlineRadio2" value="0"> Not Active
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Add Room</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection