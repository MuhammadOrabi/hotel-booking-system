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
					<div class="panel-title">Reservations</div>
				</div>
  				<form class="form-inline col-sm-offset-3">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" value="{{ $now }}">
                    </div>
                    <button type="submit" class="btn btn-default">Go</button>
                </form>
                <div class="panel-body">
                    <div class="table-responsive">
	  					<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Rendering engine</th>
									<th>Browser</th>
									<th>Platform(s)</th>
									<th>Engine version</th>
									<th>CSS grade</th>
								</tr>
							</thead>
							<tbody>
								<tr class="odd gradeX">
									<td>Trident</td>
									<td>Internet Explorer 4.0</td>
									<td>Win 95+</td>
									<td class="center"> 4</td>
									<td class="center">X</td>
								</tr>
							</tbody>
						</table>
					</div>
  				</div>
  			</div>
        </div>
    </div>
@stop