<?php

namespace ApiClientGitlab\Commands;

use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * Class UsersCommand
 *
 * @package ApiClientGitlab\Command
 *
 * ex : php mattermost.php jobs:status 2882660 20995515
 */
class Command extends SymfonyCommand
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Command constructor.
     *
     * @param array $config
     * @param null  $name
     */
    public function __construct(array $config, $name = null)
    {
        $this->config = $config;

        parent::__construct($name);
    }

    /**
     * @param null $key
     *
     * @return array|mixed
     */
    public function getConfiguration($key = null)
    {
        if (!is_null($key) && is_string($key) && array_key_exists($key,$this->config)) {
            return $this->config[$key];
        }

        return $this->config;
    }
}