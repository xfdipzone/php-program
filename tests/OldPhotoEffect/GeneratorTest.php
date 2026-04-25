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
    // 定义用例用到的测试文件
    private static $source = __DIR__ . '/test_data/source.jpg';
    private static $dest = '/tmp/old_photo_effect_dest.jpg';

    /**
     * @covers \OldPhotoEffect\Generator::generate
     */
    public function testGenerate()
    {
        $is_generated = \OldPhotoEffect\Generator::generate(self::$source, self::$dest);
        $this->assertTrue($is_generated);
        $this->assertTrue(file_exists(self::$dest));
    }

    /**
     * @covers \OldPhotoEffect\Generator::generate
     */
    public function testGenerateSourceNotExistsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('source file not exists');

        $source = 'not_exists_file';
        \OldPhotoEffect\Generator::generate($source, self::$dest);
    }

    // 删除测试文件
    protected function tearDown():void
    {
        if(file_exists(self::$dest))
        {
            unlink(self::$dest);
        }
    }
}