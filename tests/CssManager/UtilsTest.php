<?php declare(strict_types=1);
namespace Tests\CssManager;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-css-updater\CssManager\Utils
 *
 * @author fdipzone
 */
final class UtilsTest extends TestCase
{
    /**
     * @covers \CssManager\Utils::checkExtension
     */
    public function testCheckExtension()
    {
        $file = '/tmp/test.jpg';
        $ret = \CssManager\Utils::checkExtension($file, ['jpg', 'gif', 'png']);
        $this->assertTrue($ret);

        $ret = \CssManager\Utils::checkExtension($file, ['js', 'css']);
        $this->assertFalse($ret);
    }

    /**
     * @covers \CssManager\Utils::createDirs
     */
    public function testCreateDirs()
    {
        $path = '/tmp/'.date('YmdHis').'-'.mt_rand(100,999).'/test';
        $ret = \CssManager\Utils::createDirs($path);
        $this->assertTrue($ret);
        $this->assertTrue(is_dir($path));

        // 再次创建
        $ret = \CssManager\Utils::createDirs($path);
        $this->assertTrue($ret);
        $this->assertTrue(is_dir($path));
    }

    /**
     * @covers \CssManager\Utils::log
     */
    public function testLog()
    {
        $log_file = '/tmp/'.date('YmdHis').'-'.mt_rand(100,999).'/log/test.log';
        $content = 'my log content';

        \CssManager\Utils::log($log_file, $content);
        $this->assertTrue(strstr(file_get_contents($log_file), $content)!==false);
    }

    /**
     * @covers \CssManager\Utils::traversing
     */
    public function testTraversing()
    {
        $path = dirname(dirname(__FILE__));

        // 不遍历子目录，此目录中没有任何文件
        $result1 = [];
        \CssManager\Utils::traversing($path, $result1);
        $this->assertTrue(count($result1)==0);

        // 遍历子目录
        $result2 = [];
        \CssManager\Utils::traversing($path, $result2, true);
        $this->assertTrue(count($result2)>0);
    }
}