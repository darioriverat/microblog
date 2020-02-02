@extends('layouts.app')

@section('content')
    <div class="container">
        <nav class="nav">
            <a class="nav-link btn btn-primary" href="{{ route('entries.index') }}">
                <i class="fas fa-quote-left"></i> Entries
            </a>
            <div class="ml-auto">
                @auth
                    @if ($entry->author->id == \Illuminate\Support\Facades\Auth::id())
                        <small><a class="nav-link btn btn-primary" href="{{ route('admin.entries.edit', $entry->id) }}"><i class="fas fa-edit"></i> Edit</a></small>
                    @endif
                @endauth
            </div>
        </nav><br />
        <article>
            <header>
                <h1 itemprop="headline">{{ $entry->title }}</h1>
                <h3><small>{{ $entry->description }}</small></h3>
                <p>
                    <span class="badge badge-success">
                        <time itemprop="datePublished" datetime="{{ $entry->created_at }}">{{ $entry->created_at }}</time>
                    </span>
                </p>
            </header>
            <p>{{ $entry->content }}</p>
        </article>
    </div>
@endsection
