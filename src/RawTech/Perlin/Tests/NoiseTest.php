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
        $this->noise = new Noise();
    }

    public function testOne()
    {
        $this->assertSame(1,1);
    }
}