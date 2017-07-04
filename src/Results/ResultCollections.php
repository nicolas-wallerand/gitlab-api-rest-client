<?php

namespace ApiClientGitlab\Results;

/**
 * Class ResultCollections
 *
 * @package ApiClientGitlab\Results
 */
class ResultCollections extends Resultset implements ResultsetInterface
{
    /**
     * @param $header
     *
     * @return array
     */
    private function get($header)
    {
        $header = $this->response->getHeader($header);

        if (isset($header[0])) {
            return $header[0];
        }

        return $header;
    }

    /**
     * @return int
     */
    public function countTotalOfItem()
    {
        $header = $this->response->getHeader('X-Total');

        if (isset($header[0])) {
            return $header[0];
        }

        return $header;
    }

    public function countTotalOfPages()
    {
        return $this->get('X-Total-Pages');
    }

    /**
     * @return array
     */
    public function countItemPerPage()
    {
        return $this->get('X-Per-Page');
    }

    /**
     * @return array
     */
    public function getIndexCurrentPage()
    {
        return $this->get('X-Page');
    }

    /**
     * @return array
     */
    public function getIndexOfNextPage()
    {
        return $this->get('X-Next-Page');
    }

    /**
     * @return array
     */
    public function getIndexOfPrevPage()
    {
        return $this->get('X-Prev-Page');
    }
}