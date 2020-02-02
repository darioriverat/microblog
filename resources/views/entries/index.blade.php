@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse ($entries as $entry)
            <article>
                <h2>
                    @guest
                        <a href="{{ route('entries.showBySlug', [$entry->created_by, $entry->friendly_url]) }}">
                            {{ $entry->title }}
                        </a>
                    @else
                        <a href="{{ route('entries.show', $entry->id) }}">
                            {{ $entry->title }}
                        </a>
                    @endguest

                    @auth
                        @if ($entry->author->id == \Illuminate\Support\Facades\Auth::id())
                            <small><a href="{{ route('admin.entries.edit', $entry->id) }}" class="text-dark"><i class="fas fa-edit"></i></a></small>
                        @endif
                    @endauth
                </h2>
                <div>
                    <span class="badge badge-success">{{ $entry->created_at }}</span>
                </div>
                <p class="text-justify">
                    {{ substr($entry->content, 0, 256) . '...' }}
                </p>
                <footer class="pt-2">
                    <span class="text-muted">-- {{ $entry->author->name }}</span>
                </footer>
            </article><br /><br />
        @empty
            <p>No entries</p>
        @endforelse
    </div>
@endsection
