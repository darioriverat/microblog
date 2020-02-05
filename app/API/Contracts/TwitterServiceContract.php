<?php

namespace App\API\Contracts;

interface TwitterServiceContract
{
    public function getTweetsByUser(string $user);
}
