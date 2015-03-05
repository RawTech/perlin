<?php

namespace RawTech\Perlin\Tests;

use RawTech\Perlin\Noise;

/**
 * Class NoiseTest
 *
 * @package RawTech/Perlin/Test
 */
class NoiseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Noise
     */
    protected $noise;

    /**
     * Setup the test.
     */
    public function setup()
    {
        $this->noise = new Noise(1, 1, 1);
    }

    /**
     * Tests noise generation.
     *
     * Assumes default seed.
     */
    public function testNoise()
    {
        $this->assertSame(
            -0.966383549384772777557373046875,
            $this->noise->noise(1, 1)
        );
        $this->assertSame(
            0.125139863230288028717041015625,
            $this->noise->noise(1, 2)
        );
        $this->assertSame(
            0.528616565279662609100341796875,
            $this->noise->noise(1, 3)
        );
    }

    /**
     * Test alpha interpolation.
     *
     * Assumes default seed.
     */
    public function testInterpolation()
    {
        $this->assertSame(1.0, $this->noise->interpolate(1, 1, 1.0));
        $this->assertSame(1.0, $this->noise->interpolate(1, 1, 0.1));

        $this->assertSame(
            1.195491502812526363186407252214848995208740234375,
            $this->noise->interpolate(1.1, 2.1, 0.2)
        );
        $this->assertSame(
            1.000000024674010834502269062795676290988922119140625,
            $this->noise->interpolate(1, 2, 0.0001)
        );
    }
}
