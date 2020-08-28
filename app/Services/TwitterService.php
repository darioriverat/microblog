<?php

namespace App\Services;

use App\API\Contracts\TwitterServiceContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Pleets\HttpClient\Clients\Constants\Client;
use Pleets\HttpClient\Standard;

class TwitterService implements TwitterServiceContract
{
    public const CONSUMER_KEY = 'consumer_key';
    public const CONSUMER_SECRET = 'consumer_secret';

    /**
     * @var string
     */
    protected $consumerKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @return string
     */
    public function getConsumerKey(): string
    {
        return $this->consumerKey;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @param string $consumerKey
     */
    public function setConsumerKey(string $consumerKey): void
    {
        $this->consumerKey = $consumerKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey(string $secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    public function getBearerToken(): string
    {
        if (!Cache::has($this->tokenTag())) {
            $login = config('twitter.api_key');
            $password = config('twitter.api_secret_key');
            $url = config('twitter.api_token_url');

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($ch, CURLOPT_USERPWD, $login . ':' . $password);

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                \Log::info('Error getting token', ['curl_error' => curl_error($ch)]);

                return '';
            }

            curl_close($ch);

            $json = json_decode($result, true);

            if (!$json) {
                \Log::info('Response could not be parsed', ['json' => $result]);

                return '';
            }

            if (!Arr::has($json ?? [], 'errors')) {
                Cache::put($this->tokenTag(), $json['access_token'], 60 * 60 * 24);

                return $json['access_token'];
            }

            return '';
        } else {
            return Cache::get($this->tokenTag());
        }
    }

    public function getTweetsByUser(string $user)
    {
        if (!Cache::has($this->tag($user))) {
            $client = new Standard(Client::GUZZLE);

            $client->prepareRequest('GET', config('twitter.api_search_url') . '?screen_name=darioriverat&count=7');
            $token = $this->getBearerToken();
            $client->setHeader('Authorization', 'Bearer ' . $token);
            $json = $client->execute()->response();

            if (!Arr::has($json ?? [], 'errors')) {
                Cache::put($this->tag($user), $json, 60 * 60 * 24);
            } else {
                return $json;
            }
        }

        return Cache::get($this->tag($user));
    }

    private function tag($user)
    {
        return $user . '-tweets';
    }

    private function tokenTag()
    {
        return 'token';
    }
}
