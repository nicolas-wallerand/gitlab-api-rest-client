<?php

namespace ApiClientGitlab\Results;

/**
 * Class Resultset
 *
 * @package ApiClientGitlab\Results
 */
abstract class Resultset implements ResultsetInterface
{
    /**
     * @var array $rows
     */
    protected $rows = [];

    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

    /**
     * Resultset constructor.
     *
     * @param $response
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->response = $response;
        $this->rows = json_decode($response->getBody(), true);;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->rows;
    }

    /**
     * @return bool
     */
    public function success()
    {
        if ($this->response->getStatusCode() === 200) {
            return true;
        }

        return false;
    }

    /**
     * @param $result
     */
    public function setResults($result)
    {
        $this->rows = $result;
    }

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

}