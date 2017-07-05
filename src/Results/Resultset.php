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
     * @param \GuzzleHttp\Psr7\Response $response
     * @throws \Exception
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->response = $response;

        if($response->getHeader('Content-Type')[0] === 'application/json') {
            $this->rows = json_decode($response->getBody(), true);;
        } else {
            throw new \Exception('Response content-Type not found');
        }
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