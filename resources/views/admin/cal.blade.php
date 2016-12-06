@extends('layouts.admin')


@section('content')
<script src="https://cdn.jsdelivr.net/vue.resource/1.0.3/vue-resource.min.js"></script>

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
    <?php $types = App\room_type::has('rooms')->get();?>
    @foreach($types as $type)
        <Cal date = "{{ $now }}" type="{{ $type->name }}">Loading...</Cal>
    @endforeach
    </div>
@stop