<?php

namespace ApiClientGitlab;

/**
 * Class Services
 *
 * @package ApiClientGitlab
 */
class Services
{
    /**
     * @var ApiClient $client
     */
    private $client;

    /**
     * Service constructor.
     *
     * @param ApiClient $client
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return ApiClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ApiClient $client
     *
     * @return static
     */
    public static function createService(ApiClient $client)
    {
        return new static($client);
    }
}