<?php

namespace ApiClientGitlab\Services;

use ApiClientGitlab\Results\ResultCollections;
use ApiClientGitlab\Results\ResultsetError;
use ApiClientGitlab\Results\ResultSimple;
use ApiClientGitlab\Services;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Projects
 *
 * @package ApiClientGitlab\Services
 */
class Projects extends Services
{
    /**
     * @param $id
     *
     * @return ResultsetError|ResultSimple
     * @throws \Exception
     */
    public function get($id)
    {
        try {
            $response = $this->getClient()->get('projects/' . $id);
            $result = new ResultSimple($response);
        } catch (RequestException $e) {

            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 404) {

                $result = new ResultsetError($e->getResponse());
            } else {
                throw new \Exception($e->getResponse());
            }
        }

        return $result;
    }

    /**
     * @return ResultCollections
     */
    public function getAll()
    {
        $response = $this->getClient()->get('projects', [
            'private_token' => 'Hy-XoDMsoWmzBhivSX3N',
        ]);

        $result = new ResultCollections($response);

        return $result;
    }
}