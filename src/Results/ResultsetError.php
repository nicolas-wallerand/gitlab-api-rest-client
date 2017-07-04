<?php

namespace ApiClientGitlab\Results;

/**
 * Class ResultsetError
 *
 * @package ApiServer\Core\Api\Resultsets
 */
class ResultsetError extends Resultset implements ResultsetInterface
{
    /**
     * string STATUS
     */
    const STATUS = 'ERROR';

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->rows['message'];
    }
}