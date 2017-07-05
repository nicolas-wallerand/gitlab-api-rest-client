<?php

namespace ApiClientGitlab\Services;

use ApiClientGitlab\Results\ResultsetError;
use ApiClientGitlab\Results\ResultSimple;
use ApiClientGitlab\Services;
use GuzzleHttp\Exception\RequestException;
use ApiClientGitlab\Services\Entities\Job;

/**
 * Class Projects
 *
 * @package ApiClientGitlab\Services
 */
class Jobs extends Services
{
    /**
     * @param $idProject
     * @param $idJob
     *
     * @return ResultsetError|ResultSimple
     * @throws \Exception
     */
    public function get($idProject, $idJob)
    {
        try {
            $response = $this->getClient()->get('projects/' . $idProject . '/jobs/' . $idJob);
            $result = new ResultSimple($response);

            $job = new Job();
            $job->hydrate($result->current());

            $result->setResults($job);
        } catch (RequestException $e) {

            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 404) {

                $result = new ResultsetError($e->getResponse());
            } else {
                throw new \Exception($e->getResponse());
            }
        }

        return $result;
    }
}
