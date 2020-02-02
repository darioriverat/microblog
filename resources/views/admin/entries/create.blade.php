@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('admin.entries.store') }}" method="post" autocomplete="off">
            @csrf
            @include('admin.entries.__form', ['createUrl' => true])
            <button class="btn btn-primary" type="submit">
                {{ __('forms.actions.save') }}
            </button>
        </form>
    </div>
@endsection
