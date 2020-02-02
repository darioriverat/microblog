@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $user->name }} <small class="text-muted">entries</small> </h2><br />

        @include('entries.__list')
    </div>
@endsection
