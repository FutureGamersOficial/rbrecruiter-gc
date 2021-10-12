<?php declare(strict_types=1);


namespace App\Helpers;

/**
 * Class DigitalStorageHelper
 *
 * The digital storage helper class helps you convert bytes into several other units.
 * It should be used whenever you need to display a file's size in a human readable way.
 *
 * It's framework agnostic, meaning you can take it out of context and it'll still work; However, you'll have to instantiate it first.
 * @package App\Helpers
 */
class DigitalStorageHelper
{

    /**
     * The digital storage value to be manipulated.
     * @var $value
     */
    protected $value;


    /**
     * Sets the digital storage value for manipulation.
     *
     * @param int $value The digital storage value in bytes
     * @return $this The current instance
     */
    public function setValue(int $value): DigitalStorageHelper
    {
        $this->value = $value;
        return $this;
    }


    /**
     * Converts the digital storage value to kilobytes.
     *
     * @return float|int
     */
    public function toKilobytes(): float
    {
        return $this->value / 1000;
    }


    /**
     * Converts the digital storage value to megabytes.
     *
     * @return float|int
     */
    public function toMegabytes(): float
    {
        return $this->value / (1 * pow(10, 6)); // 1 times 10 to the power of 6
    }


    /**
     * Convert the digital storage value to gigabytes. Might be an approximation
     *
     * @return float
     */
    public function toGigabytes(): float
    {
        return $this->value / (1 * pow(10, 9));
    }


    /**
     * Convert the digital storage value to terabytes.
     *
     * @return float
     */
    public function toTerabytes(): float
    {
        return $this->value / (1 * pow(10, 12));
    }


    /**
     * Format the digital storage value to one of the units: b, kb, mb, gb and tb.
     * The method has been adapted to use both MiB and MB values.
     *
     * @param int $precision The rounding precision
     * @param bool $si Use international system units. Defaults to false
     * @return string The human readable digital storage value, in either, for instance, MB or MiB
     * @see https://stackoverflow.com/a/2510459/11540218 StackOverflow question regarding unit conversion
     * @since 7.3.23
     */
    public function formatBytes($precision = 2, $si = false): string
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];
        if ($si)
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($this->value, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(($si) ? 1000 : 1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(($si) ? 1000 : 1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

}
