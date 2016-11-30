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
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">Rooms Settings</div>
                </div>
                <div class="panel-body">
                    <div id="rootwizard">
                        <div class="navbar">
                          <div class="navbar-inner">
                            <div class="container">
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#tab1" data-toggle="tab">Add</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Update</a></li>
                                </ul>
                            </div>
                          </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                @if(isset($types[0]))
                                    <form class="form-horizontal" method="POST" action="{{ url('/add/rooms') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-3">
                                                <label for="sel1">Select room type</label>
                                                <select class="form-control" name="type_name" id="sel1">
                                                @foreach($types as $type)
                                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-3">
                                              <input type="text" class="form-control" name="no"  placeholder="Number Of Rooms">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-3">
                                              <input type="text" class="form-control" name="floor"  placeholder="Floor Number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-3">
                                              <input type="text" class="form-control" name="active" placeholder="How many active rooms? (example 20)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-10">
                                              <button type="submit" class="btn btn-primary">Add Room</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-danger text-center" role="alert">
                                        <a href="{{ url('/types/settings') }}"><h2 class="text-center">Add Types First!!</h2></a>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane" id="tab2">
                                <?php $rooms = App\room::get(); ?>
                                @if(isset($rooms[0]))
                                    <form class="form-horizontal" method="POST" action="{{ url('/update/rooms') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="sel1">Select room type</label>
                                                <select class="form-control" name="type_name" id="sel1">
                                                @foreach($types as $type)
                                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                              <input type="text" class="form-control" name="floor"  placeholder="Floor Number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                              <input type="text" class="form-control" name="id"  placeholder="Room Number">
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
                                              <button type="submit" class="btn btn-default">Update Room</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-danger text-center" role="alert">
                                        <h2 class="text-center">there are No rooms!!</h2>
                                    </div>
                                @endif
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection