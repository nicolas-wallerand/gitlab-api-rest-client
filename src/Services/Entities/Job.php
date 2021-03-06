<?php

namespace ApiClientGitlab\Services\Entities;

use ApiClientGitlab\Entity;

/**
 * Class Project
 *
 * @package ApiClientGitlab\Services\Entities
 */
class Job extends Entity
{
    /**
     *  Status Jobs failed
     */
    const STATUS_FAILLED = 'failed';

    /**
     * Status Jobs Passed
     */
    const STATUS_PASSED = 'success';

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}