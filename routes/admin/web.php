<?php

Route::resource('entries', 'EntriesController')
    ->only(['create', 'store', 'edit', 'update']);
