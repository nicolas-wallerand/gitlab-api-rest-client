<?php

namespace ApiClientGitlab;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Class ApiClient
 *
 * @package ApiClientGitlab
 */
class ApiClient
{
    /**
     *
     */
    const AUTH_URL_TOKEN = 'url_token';

    /**
     *
     */
    const AUTH_HTTP_TOKEN = 'http_token';

    /**
     *
     */
    const AUTH_OAUTH_TOKEN = 'oauth_token';

    /**
     * @var ApiClient
     */
    protected static $default;

    /**
     * Contain key of the current application
     *
     * @var string
     */
    private $typeAccessToken = null;

    /**
     * Contain secret of the current application
     *
     * @var string
     */
    private $token = null;

    /**
     * @var null
     */
    private $endpoint = null;

    /**
     * @var array
     */
    private $allowedMethods = ['get', 'post', 'put', 'delete'];

    /**
     * @var Client|null
     */
    private $httpClient = null;

    /**
     * ApiClient constructor.
     *
     * @param             $endpoint
     * @param             $token
     * @param             $typeAccessToken
     * @param Client|null $httpClient
     *
     * @throws Exceptions\InvalidParameterException
     * @internal param $applicationSecret
     */
    public function __construct($endpoint, $token, $typeAccessToken, Client $httpClient = null)
    {

        if (!isset($token)) {
            throw new Exceptions\InvalidParameterException("Application token parameter is empty");
        }

        if (!isset($endpoint)) {
            throw new Exceptions\InvalidParameterException("Endpoint parameter is empty");
        }

        if (!isset($httpClient)) {
            $httpClient = new Client([
                'timeout'         => 600,
                'connect_timeout' => 5,
            ]);
        }

        $this->typeAccessToken = $typeAccessToken;
        $this->token = $token;
        $this->httpClient = $httpClient;
        $this->endpoint = $endpoint;

        self::$default = $this;
    }

    /**
     * @return ApiClient
     */
    public static function getDefault()
    {
        return self::$default;
    }

    /**
     * @param      $path
     * @param null $content
     * @param null $headers
     *
     * @return mixed
     */
    public function get($path, $content = null, $headers = null)
    {
        return $this->api("GET", $path, $content, $headers);
    }

    /**
     * @param      $path
     * @param null $content
     * @param null $headers
     *
     * @return mixed
     */
    public function post($path, $content = null, $headers = null)
    {
        return $this->api("POST", $path, $content, $headers);
    }

    /**
     * @param      $path
     * @param      $content
     * @param null $headers
     *
     * @return mixed
     */
    public function put($path, $content, $headers = null)
    {
        return $this->api("PUT", $path, $content, $headers);
    }

    /**
     * @param      $path
     * @param null $content
     * @param null $headers
     *
     * @return mixed
     */
    public function delete($path, $content = null, $headers = null)
    {
        return $this->api("DELETE", $path, $content, $headers);
    }

    /**
     * @param      $method
     * @param      $path
     * @param null $content
     * @param null $headers
     *
     * @return Response
     */
    public function api($method, $path, $content = null, $headers = null)
    {
        $this->allowedMethods($method);

        $url = $this->endpoint . $path;

        if ($this->typeAccessToken === self::AUTH_HTTP_TOKEN) {
            $content = array_merge(['private_token' => $this->token], (array)$content);
        }

        if (isset($content) && $method == 'GET') {
            $request = new Request($method, $url);

            $query_string = $request->getUri()->getQuery();
            $query = [];
            if (!empty($query_string)) {
                $queries = explode('&', $query_string);
                foreach ($queries as $element) {
                    $key_value_query = explode('=', $element, 2);
                    $query[$key_value_query[0]] = $key_value_query[1];
                }
            }
            $query = array_merge($query, (array)$content);
            // rewrite query args to properly dump true/false parameters
            foreach ($query as $key => $value) {
                if ($value === false) {
                    $query[$key] = "false";
                } else {
                    if ($value === true) {
                        $query[$key] = "true";
                    }
                }
            }
            $query = \GuzzleHttp\Psr7\build_query($query);
            $url = $request->getUri()->withQuery($query);
            $request = $request->withUri($url);
        } else {
            if (is_array($content) && array_key_exists('multipart', $content)) {
                $multipart = new MultipartStream($content['multipart']);
                $request = new Request($method, $url, [], $multipart);
            } else {
                $request = new Request($method, $url);
                $body = \GuzzleHttp\json_encode($content);
                $request->getBody()->write($body);
            }
        }


        if (!is_array($headers)) {
            $headers = [];
        }

        /*if ($this->typeAccessToken === self::AUTH_HTTP_TOKEN) {
            $headers['Authorization'] = 'PRIVATE-TOKEN ' . $this->token;
        }*/


        /** @var Response $response */
        $response = $this->httpClient->send($request, ['headers' => $headers]);

        return $response;
    }

    /**
     * @param string $method
     *
     * @return bool
     * @throws Exceptions\InvalidParameterException
     */
    protected function allowedMethods($method)
    {
        $method = strtolower($method);
        if (!in_array($method, $this->allowedMethods, true)) {
            throw new Exceptions\InvalidParameterException("The method $method is not allowed.");
        }

        return true;
    }

    /**
     * @return Client|null
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }
}