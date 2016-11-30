@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">Room Types Settings</div>
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
                                    <form class="form-horizontal" method="POST" action="{{ url('/add/type') }}">
                                    <div class="form-group">
                                        <div class="col-sm-5 ">
                                          <input type="text" class="form-control" name="name"  placeholder="Room type name">
                                        </div>
                                    </div>
                                    {{ csrf_field() }}
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
                                        <div class="col-sm-offset-2 col-sm-10">
                                          <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2">
                                @if(isset($types[0]))
                                    <form class="form-horizontal" method="POST" action="{{ url('/update/type') }}">
                                            <div class="form-group">
                                                <div class="col-sm-5">
                                                    <label for="sel1">Select type name</label>
                                                    <select class="form-control" name="type_name" id="sel1">
                                                    @foreach($types as $typ)
                                                        <option value="{{ $typ->name }}">{{ $typ->name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        {{ csrf_field() }}
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
                                            <div class="col-sm-offset-2 col-sm-10">
                                              <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-danger text-center" role="alert">
                                        <h2 class="text-center">No Types to Update!!</h2>
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