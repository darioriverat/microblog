<?php

namespace Tests\Concerns;

trait WrongStoreEntryDataProvider
{
    public function wrongEntryData()
    {
        $emptyString = function ($faker) {
            return '';
        };

        $longString = function ($faker) {
            return $faker->text(500);
        };

        return [
            'Title is missing' => [$emptyString, 'title'],
            'Title is too long' => [$longString, 'title'],
            'Description is too long' => [$longString, 'description'],
            'Content is missing' => [$emptyString, 'content'],
            'Friendly URL is missing' => [$emptyString, 'friendly_url'],
            'Friendly URL is too long' => [$longString, 'friendly_url'],
        ];
    }
}
