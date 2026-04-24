<?php declare(strict_types=1);
namespace Tests\OldPhoto;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-oldphoto\OldPhotoEffect\Generator
 *
 * @author fdipzone
 */
final class GeneratorTest extends TestCase
{
    /**
     * @covers \OldPhotoEffect\Generator::generate
     */
    public function testGenerate()
    {
        $source = __DIR__ . '/test_data/source.jpg';
        $dest = '/tmp/old_photo_effect_dest.jpg';

        $is_generated = \OldPhotoEffect\Generator::generate($source, $dest);
        $this->assertTrue($is_generated);
        $this->assertTrue(file_exists($dest));
    }

    /**
     * @covers \OldPhotoEffect\Generator::generate
     */
    public function testGenerateSourceNotExistsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('source file not exists');

        $source = 'not_exists_file';
        $dest = '/tmp/old_photo_effect_dest.jpg';
        \OldPhotoEffect\Generator::generate($source, $dest);
    }
}