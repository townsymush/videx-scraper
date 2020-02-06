<?php declare(strict_types = 1);

namespace App\Entity;

class Package
{
    public const FREQUENCY_MONTHLY = 'monthly';
    public const FREQUENCY_ANNUALLY = 'annually';
    /**
     * @var string
     */
    private $optionTitle;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $discount;

    /**
     * @var string
     */
    private $paymentFrequency;
    /**
     * @return string
     */
    public function getOptionTitle(): string
    {
        return $this->optionTitle;
    }

    /**
     * @param string $optionTitle
     */
    public function setOptionTitle(string $optionTitle): void
    {
        $this->optionTitle = $optionTitle;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return '£' . number_format($this->price, 2);
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     */
    public function setDiscount(string $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return string
     */
    public function getPaymentFrequency(): string
    {
        return $this->paymentFrequency;
    }

    /**
     * @param string $paymentFrequency
     */
    public function setPaymentFrequency(string $paymentFrequency): void
    {
        $this->paymentFrequency = $paymentFrequency;
    }

    /**
     * Get the annual price of package
     *
     * Checks frequency and multiplies by 12 months if necessary
     * @return float
     */
    public function getAnnualPrice(): float
    {
        $price = self::parsePrice($this->getPrice());
        if ($this->getPaymentFrequency() == self::FREQUENCY_MONTHLY) {
            $price = $price * 12;
        }
        return $price;
    }

    /**
     * Helper function to parse string price to float
     * @param string $price
     * @return float
     */
    public static function parsePrice(string $price): float
    {
        return (float) preg_replace('/[^0-9\.]/ui','',$price);
    }
}