<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function testSomething(): void
    {
        $chiffre = 4;
        $this->assertSame(4, $chiffre);
        // $this->assertEquals(4, $chiffre);

    }
}
