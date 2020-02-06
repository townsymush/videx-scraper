<?php declare(strict_types = 1);

namespace App\Scraper;

use App\Entity\Package;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Videx
{
    /**
     * @var HttpClientInterface
     */
    private $videxClient;

    /**
     * @var HttpBrowser
     */
    private $browser;

    public function __construct(HttpClientInterface $videxClient)
    {
        $this->videxClient = $videxClient;
        $this->browser = new HttpBrowser($videxClient);
    }

    /**
     * Scrapes the videx website and returns an array: Package[]
     * @return Package[]
     */
    public function scrape(): array
    {
        $crawler = $this->browser->request('GET', 'https://videx.comesconnected.com');
        $packages = [];

        // Get subscription blocks and iterate through
        $crawler->filter('#subscriptions')->each(function (Crawler $nodeCrawler) use (&$packages) {
            // Get the payment frequency based on section title
            if (strpos(strtolower($nodeCrawler->filterXPath('//h2')->text()), Package::FREQUENCY_MONTHLY) !== false) {
                $frequency = Package::FREQUENCY_MONTHLY;
            } else {
                $frequency = Package::FREQUENCY_ANNUALLY;
            }

            // Iterate through each package block to build a package object
            $nodeCrawler->filter('.package')->each(function (Crawler $nodeCrawler) use (&$packages, $frequency) {
                $package = new Package();
                $package->setPaymentFrequency($frequency);
                $package->setOptionTitle($nodeCrawler->filter('.header')->text());
                $package->setDescription($nodeCrawler->filter('.package-features')->text());
                $package->setPrice(Package::parsePrice($nodeCrawler->filter('.package-features .price-big')->text()));
                $package->setDiscount($nodeCrawler->filter('.package-price')->children()->last()->text());
                $packages[] = $package;
            });
        });
        return $this->orderByAnnualPrice($packages);
    }

    /**
     * Order packages by their annual price
     * @param Package[] $packages
     * @return array
     */
    private function orderByAnnualPrice(array $packages): array
    {
        usort($packages, function (Package $a, Package $b) {
            return $b->getAnnualPrice() > $a->getAnnualPrice() ? 1 : -1;
        });
        return $packages;
    }
}
