<?php

Route::resource('entries', 'EntriesController')
    ->only(['create', 'store', 'edit', 'update']);

Route::resource('tweets', 'TweetsController')
    ->only(['store', 'destroy']);
