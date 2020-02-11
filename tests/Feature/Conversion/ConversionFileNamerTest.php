<?php

namespace Spatie\Medialibrary\Tests\Feature\Conversion;

use Spatie\Medialibrary\Tests\Support\testfiles\TestConversionFileNamer;
use Spatie\Medialibrary\Tests\TestCase;

class ConversionFileNamerTest extends TestCase
{
    /** @test */
    public function it_can_use_a_custom_conversion_file_namer()
    {
        config()->set('medialibrary.conversion_file_namer', TestConversionFileNamer::class);
        
        $this
            ->testModelWithConversion
            ->addMedia($this->getTestJpg())
            ->toMediaCollection();
        
        $path = $this->testModelWithConversion->refresh()->getFirstMediaPath('default', 'thumb');
        
        $this->assertStringEndsWith('test---thumb.jpg', $path);
        $this->assertFileExists($path);
        
        $this->assertEquals('/media/1/conversions/test---thumb.jpg', $this->testModelWithConversion->getFirstMediaUrl('default', 'thumb'));
    }
}
