<?php

namespace SimpleConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Container;
use SimpleConsole\Utility\Accessor;

/**
 * 
 * @author 
 * @license MIT (see LICENSE.md)
 */
abstract class CommandAbstract extends Command
{

    /**
     * Command info
     *
     * @var array
     */
    protected $commandinfo = array();

    /**
     * start_time
     *
     * @var \DateTime
     */
    protected $time_start = null;
    
    
    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;

    /**
     * Set container
     *
     * @param \Symfony\Component\DependencyInjection\Container $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Get container
     *
     * @return string
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param String $name
     * @return String
     */
    public function getParameter($name)
    {
        if (array_key_exists($name, $this->parameters) === false) {
            $this->parameters[$name] = $this->getContainer()->getParameter($name);
        }
        return $this->parameters[$name];
    }

    /**
     * @param String $name
     * @param String $parameter
     */
    public function setParameter($name, $parameter)
    {
        $this->parameters[$name] = $parameter;
    }


    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setUser(rtrim(shell_exec('whoami')));
        $reflection = new \ReflectionClass($this);
        $this->setPath($reflection->getFileName());
    }

    /**
     * Initializes the command just after the input has been validated.
     *
     * This is mainly useful when a lot of commands extends one main command
     * where some things need to be initialized based on the input arguments and options.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->setTimeStart((new \DateTime())->setTimestamp(time()));
        $this->setArguments($input->getArguments());
        $this->setOptions($input->getOptions());
    }
    
    /**
     * Set user
     *
     * @param string $user
     * @return self
     */
    public function setUser($user)
    {
        $this->commandinfo['user'] = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return string|null
     */
    public function getUser()
    {
        return Accessor::getValue($this->commandinfo, 'user');
    }
    
    /**
     * Set time_start
     *
     * @param \DateTime $start_time
     * @return $this
     */
    public function setTimeStart(\DateTime $start_time)
    {
        $this->time_start = $start_time;
        return $this;
    }


    /**
     * Get time started
     *
     * @return \DateTime
     */
    public function getTimeStart()
    {
        return $this->time_start;
    }
    
    /**
     * Get time current.
     *
     * @return \DateTime
     */
    public function getTimeCurrent()
    {
        return (new \DateTime())->setTimestamp(time());
    }


    /**
     * Get time interval (started - current).
     *
     * @return \DateInterval
     */
    public function getTimeDuration()
    {
        $started = $this->getTimeStart();
        $current = $this->getTimeCurrent();
        return $started->diff($current);
    }

    /**
     * Get environment
     *
     * @return string|null
     */
    public function getEnvironment()
    {
        return $this->getParameter("application.env");
    }
    
    /**
     * Get Host
     *
     * @return string
     */
    public function getHost()
    {
        return gethostname();
    }

    /**
     * Set path
     *
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->commandinfo['path'] = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return Accessor::getValue($this->commandinfo, 'path');
    }
    
    /**
     * Set arguments
     *
     * @param array $arguments
     * @return self
     */
    public function setArguments(array $arguments)
    {
        $this->commandinfo['arguments'] = $arguments;
        return $this;
    }

    /**
     * Get arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return Accessor::getValue($this->commandinfo, 'arguments', array());
    }
    
    /**
     * Set options
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->commandinfo['options'] = $options;
        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return Accessor::getValue($this->commandinfo, 'options', array());
    }

    /**
     * Get command info
     *
     * @return array
     */
    protected function getCommandinfo()
    {
        return $this->commandinfo;
    }

    /**
     * Get memory peak
     *
     * @return string
     */
    protected function getMemoryPeakUsedString()
    {
        $memory_bytes = memory_get_peak_usage(true);

        // Formats bytes into a human readable string if $this->useFormatting is true, otherwise return $bytes as is
        if ($memory_bytes > 1024*1024) {
            return round($memory_bytes/1024/1024, 2).' MB';
        } elseif ($memory_bytes > 1024) {
            return round($memory_bytes/1024, 2).' KB';
        }

        return $memory_bytes . ' B';
    }
    
    /**
     * 
     * @param OutputInterface $output
     * @param array $values
     * @param type $indent
     */
    protected function writelnMulti(OutputInterface $output, array $values, $indent = "")
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $output->writeln($indent . $key);
                $this->writelnMulti($output, $value, $indent . "  ");
            } else {
                $output->writeln($indent . $key . " : " . $value);
            }
        }
    }
}
