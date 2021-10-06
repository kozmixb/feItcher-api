<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\StringHelper;

class StringHelperTest extends TestCase
{
    /**
     * @var array
     */
    private $examples = [
        '  Hello [sdkjskds] World  ' => 'Hello World',
        '<span> new world 9374hf3235</span> test' => 'test',
        '& this isn\'t working "' => '&amp; this isn\'t working'
    ];

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        foreach ($this->examples as $key => $value) {
            $string = StringHelper::getSafeString($key);
            $this->assertSame($value, $string);
        }
    }
}
