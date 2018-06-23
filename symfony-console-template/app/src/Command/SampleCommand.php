<?php
namespace SimpleConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 *
 * @author 
 * @license MIT (see LICENSE.md)
 */
class SampleCommand extends CommandAbstract
{

    /**
     * Command configuration
     */
    protected function configure()
    {
        $this->setName('simple_console:sample'); //名前
        $this->setDescription('Sample Command. (Search wikipedia page info from wikipedia API)');
        $this->addOption('title', null, InputOption::VALUE_OPTIONAL, 'Title', "dog");
    }

    /**
     * Command processing
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(array("", "-- [ command info ] --"));
        $this->writelnMulti($output, array(
            "user" => $this->getUser(),
            "environment" => $this->getEnvironment(),
            "host" => $this->getHost(),
            "path" => $this->getPath(),
            "arguments" => $this->getArguments(),
            "options" => $this->getOptions()
        ));

        $output->writeln(array("", "-- [ processing ] --"));
        
        // Get parameter
        $title  = $input->getOption('title');
 
        /* @var $api_client \SimpleConsole\Service\ApiClient\ApiClientWikipedia */
        $api_client = $this->getContainer()->get("api_client.wikipedia");

        $output->writeln("wikipedia api url : " . $this->getContainer()->getParameter("wikipedia_api.config.base_url"));
        $this->writelnMulti($output, $api_client->findOnePageinfo($title));

        
        // Output processing times
        $output->writeln(array("", "-- [ finish ] --"));
        $this->writelnMulti($output, array(
            "   start" => $this->getTimeStart()->format("Y-m-d H:i:s"),
            "  finish" => $this->getTimeCurrent()->format("Y-m-d H:i:s"),
            "duration" => $this->getTimeDuration()->format("%h:%i:%s"),
        ));

        $output->writeln("");
    }
}
