<?php

namespace RawTech\Perlin;

/**
 * Generates Perlin noise.
 *
 * @package RawTech\Perlin
 */
class Noise
{
    /**
     * Seed 1.
     *
     * @var integer
     */
    private $r1;

    /**
     * Seed 2.
     *
     * @var integer
     */
    private $r2;

    /**
     * Seed 3.
     *
     * @var integer
     */
    private $r3;

    /**
     * @var float
     */
    private $persistence = 0.15;

    /**
     * @var integer
     */
    private $octaves = 1;

    /**
     * Construct.
     *
     * @param integer|null $r1
     * @param integer|null $r2
     * @param integer|null $r3
     */
    public function __construct($r1 = null, $r2 = null, $r3 = null)
    {
        if (!$r1) {
            $this->r1 = rand(1000, 10000);
        } else {
            $this->r1 = (int) $r1;
        }

        if (!$r2) {
            $this->r2 = rand(100000, 1000000);
        } else {
            $this->r2 = (int) $r2;
        }

        if (!$r3) {
            $this->r3 = rand(1000000000, 2000000000);
        } else {
            $this->r3 = (int) $r3;
        }
    }

    /**
     * Gets noise for a 2D vector.
     *
     * @param float $x
     * @param float $y
     *
     * @return float
     */
    public function noise2D($x, $y)
    {
        $total = 0;

        for ($i = 0; $i < $this->octaves; $i++){
            $frequency = pow(2, $i);
            $amplitude = pow($this->persistence, $i);
            $total = $total + $this->interpolatedNoise($x * $frequency, $y * $frequency) * $amplitude;
        }

        return -$total;
    }

    /**
     * Interpolate noise for a 2D vector.
     *
     * @param float $x
     * @param float $y
     *
     * @return float
     */
    public function interpolatedNoise($x, $y)
    {
        $integerX    = (int) $x;
        $fractionalX = $x - $integerX;

        $integerY    = (int) $y;
        $fractionalY = $y - $integerY;

        $v1 = $this->smoothedNoise($integerX,     $integerY);
        $v2 = $this->smoothedNoise($integerX + 1, $integerY);
        $v3 = $this->smoothedNoise($integerX,     $integerY + 1);
        $v4 = $this->smoothedNoise($integerX + 1, $integerY + 1);

        $i1 = $this->interpolate($v1 , $v2 , $fractionalX);
        $i2 = $this->interpolate($v3 , $v4 , $fractionalX);

        return $this->interpolate($i1 , $i2 , $fractionalY);
    }

    /**
     * Smooth noise for a 2D vector.
     *
     * @param float $x
     * @param float $y
     *
     * @return float
     */
    public function smoothedNoise($x, $y)
    {
        $corners = ($this->noise($x - 1, $y - 1) + $this->noise($x + 1, $y - 1) + $this->noise($x - 1, $y + 1) + $this->noise($x + 1, $y + 1)) / 16;
        $sides   = ($this->noise($x - 1, $y) + $this->noise($x + 1, $y) + $this->noise($x, $y - 1) + $this->noise($x, $y + 1)) /  8;
        $center  =  $this->noise($x, $y) / 4;

        return $corners + $sides + $center;
    }

    /**
     * Get noise for a 2D vector.
     *
     * @param float $x
     * @param float $y
     *
     * @return float
     */
    public function noise($x, $y)
    {
        $x = (int) $x;
        $y = (int) $y;
        $n = $x + $y * 57;
        $xl = ($n << 13) ^ $n;
        $x2 = (int) ($xl * $xl * $this->r1 + $this->r2);
        $t1 = (int) ($xl * $x2);
        $t2 = (int) ($t1 + $this->r3);
        $t3 = $t2 & 0x7fffffff; // max 32 bit integer value.

        return 1 - ($t3 / 1073741824.0);
    }

    /**
     * Interpolates an alpha with a 2D vector.
     *
     * @param float $x
     * @param float $y
     * @param float $a
     *
     * @return float
     */
    public function interpolate($x, $y, $a)
    {
        $val = (1 - cos($a * pi())) * 0.5;

        return $x * (1 - $val) + $y * $val;
    }
}
