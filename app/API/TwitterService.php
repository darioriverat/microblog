<?php

namespace App\API;

use App\API\Contracts\TwitterServiceContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use TwitterAPIExchange;

class TwitterService implements TwitterServiceContract
{
    public const OAUTH_ACCESS_TOKEN = 'oauth_access_token';
    public const OAUTH_ACCESS_TOKEN_SECRET = 'oauth_access_token_secret';
    public const CONSUMER_KEY = 'consumer_key';
    public const CONSUMER_SECRET = 'consumer_secret';

    /**
     * @var string
     */
    protected $oAuthAccessToken;

    /**
     * @var string
     */
    protected $oAuthAccessTokenSecret;

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
    public function getOAuthAccessToken(): string
    {
        return $this->oAuthAccessToken;
    }

    /**
     * @return string
     */
    public function getOAuthAccessTokenSecret(): string
    {
        return $this->oAuthAccessTokenSecret;
    }

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
     * @param string $oAuthAccessToken
     */
    public function setOAuthAccessToken(string $oAuthAccessToken): void
    {
        $this->oAuthAccessToken = $oAuthAccessToken;
    }

    /**
     * @param string $oAuthAccessTokenSecret
     */
    public function setOAuthAccessTokenSecret(string $oAuthAccessTokenSecret): void
    {
        $this->oAuthAccessTokenSecret = $oAuthAccessTokenSecret;
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

    public function getTweetsByUser(string $user)
    {
        if (!Cache::has($this->tag($user))) {
            $twitter = new TwitterAPIExchange($this->buildCredentials());

            $response = $twitter
                ->setGetfield('?screen_name=' . $user . '&count=7')
                ->buildOauth(config('twitter.api_search_url'), 'GET')
                ->performRequest();

            $json = json_decode($response, true);

            if (!Arr::has($json ?? [], 'errors')) {
                Cache::put($this->tag($user), $json, 60 * 60 * 24);
            } else {
                return $json;
            }
        }

        return Cache::get($this->tag($user));
    }

    private function buildCredentials(): array
    {
        return [
            self::OAUTH_ACCESS_TOKEN => $this->oAuthAccessToken,
            self::OAUTH_ACCESS_TOKEN_SECRET => $this->oAuthAccessTokenSecret,
            self::CONSUMER_KEY => $this->consumerKey,
            self::CONSUMER_SECRET => $this->secretKey,
        ];
    }

    private function tag($user)
    {
        return $user . '-tweets';
    }
}
