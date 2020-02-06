<?php declare(strict_types = 1);

namespace App\Command;

use App\Scraper\Videx;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

class VidexCrawlerCommand extends Command
{
    /**
     * @var Videx
     */
    private $videxScraper;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    protected static $defaultName = 'crawler:videx';

    public function __construct(string $name = null, Videx $videxScraper, SerializerInterface $serializer)
    {
        parent::__construct($name);
        $this->videxScraper = $videxScraper;
        $this->serializer = $serializer;
    }

    protected function configure()
    {
        $this->setDescription('Crawls the Videx website for packages');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $packages = $this->videxScraper->scrape();
        echo $this->serializer->serialize($packages, 'json');
        return 0;
    }
}
