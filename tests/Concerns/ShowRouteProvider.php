<?php

namespace Tests\Concerns;

trait ShowRouteProvider
{
    public function showRoutes()
    {
        $resource = function ($entry) {
            return route('entries.show', $entry);
        };

        $friendly = function ($entry) {
            return route('entries.showBySlug', [$entry->author->id, $entry->friendly_url]);
        };

        return [
            'Resource URL' => [$resource],
            'Friendly URL' => [$friendly],
        ];
    }
}
