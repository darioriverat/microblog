@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2>{{ $user->name }} <small class="text-muted">entries</small> </h2><br />

                @include('entries.__list')
            </div>
            <div class="col-4">
                <h5 class="text-primary">Latest tweets</h5><br />

                @isset($tweets['errors'])
                    @include('common.__alert', ['type' => 'danger', 'message' => $tweets['errors'][0]['message']])
                @endisset

                @if (count($tweets) && !isset($tweets['errors']))
                    @foreach ($tweets as $tweet)
                        <div class="media">
                            <img src="{{ $tweet['user']['profile_image_url'] }}" class="align-self-start mr-3" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0">
                                    {{ $tweet['user']['name'] }}
                                    <small class="text-muted">
                                        <a href="https://twitter.com/{{ $user->twitter_user }}" target="_blank">
                                            {{ '@'.$user->twitter_user }}
                                        </a>
                                    </small>
                                </h5>
                                <small class="text-muted"><time itemprop="datePublished" datetime="{{ $tweet['created_at'] }}">{{ $tweet['created_at'] }}</time></small><br/>
                                <p class="mt-2">{{ $tweet['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
