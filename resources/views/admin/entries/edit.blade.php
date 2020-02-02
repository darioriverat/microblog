@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('admin.entries.update', $entry->id) }}" method="post" autocomplete="off">
            @method('PUT')
            @csrf
            @include('admin.entries.__form')
            <button class="btn btn-primary" type="submit">
                {{ __('forms.actions.save') }}
            </button>
        </form>
    </div>
@endsection
