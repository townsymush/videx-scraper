<?php declare(strict_types = 1);

namespace App\Tests\Scraper;

use App\Scraper\Videx;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class VidexTest extends KernelTestCase
{
    public function testScrape()
    {
        $mockClient = new MockHttpClient([new MockResponse(file_get_contents(__DIR__ . '/data/videx.html'))]);
        $scraper = new Videx($mockClient);
        $packages = $scraper->scrape();

        $expectedResults = [
            ['optionTitle' => 'Option 300 Mins'],
            ['optionTitle' => 'Option 3600 Mins'],
            ['optionTitle' => 'Option 160 Mins'],
            ['optionTitle' => 'Option 2000 Mins'],
            ['optionTitle' => 'Option 40 Mins'],
            ['optionTitle' => 'Option 480 Mins'],
        ];

        foreach ($packages as $key => $package) {
            $this->assertEquals($expectedResults[$key]['optionTitle'], $package->getOptionTitle());
        }
    }
}