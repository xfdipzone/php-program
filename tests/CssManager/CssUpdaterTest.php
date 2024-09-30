<?php declare(strict_types=1);
namespace Tests\CssManager;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-css-updater\CssManager\CssUpdater
 *
 * @author fdipzone
 */
final class CssUpdaterTest extends TestCase
{
    /**
     * @covers \CssManager\CssUpdater::__construct
     */
    public function testConstruct()
    {
        $css_tmpl_path = '/tmp';
        $css_path = '/tmp/css';
        $replace_tags = ['jpg', 'gif'];
        $css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
        $this->assertEquals('CssManager\CssUpdater', get_class($css_updater));
    }

    /**
     * @covers \CssManager\CssUpdater::__construct
     */
    public function testConstructCssTmplPathException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('css updater: css tmpl path not exists');

        $css_tmpl_path = '/tmp/not_exists';
        $css_path = '/tmp/css';
        $replace_tags = ['jpg', 'gif'];
        new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
    }

    /**
     * @covers \CssManager\CssUpdater::__construct
     */
    public function testConstructCssPathException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('css updater: css path is empty');

        $css_tmpl_path = '/tmp';
        $css_path = '';
        $replace_tags = ['jpg', 'gif'];
        new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
    }

    /**
     * @covers \CssManager\CssUpdater::__construct
     */
    public function testConstructReplaceTagsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('css updater: replace tags is empty');

        $css_tmpl_path = '/tmp';
        $css_path = '/tmp/css';
        $replace_tags = [];
        new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
    }

    /**
     * @covers \CssManager\CssUpdater::setLogFile
     * @covers \CssManager\CssUpdater::logFile
     */
    public function testSetAndGetLogFile()
    {
        $css_tmpl_path = '/tmp';
        $css_path = '/tmp/css';
        $replace_tags = ['jpg', 'gif'];
        $css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);

        $log_file = '/tmp/update.log';
        $css_updater->setLogFile($log_file);
        $this->assertEquals($log_file, $css_updater->logFile());
    }

    /**
     * @covers \CssManager\CssUpdater::setLogFile
     */
    public function testSetLogFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('css updater: log file is empty');

        $css_tmpl_path = '/tmp';
        $css_path = '/tmp/css';
        $replace_tags = ['jpg', 'gif'];
        $css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
        $css_updater->setLogFile('');
    }

    /**
     * @covers \CssManager\CssUpdater::update
     */
    public function testUpdate()
    {
        $css_tmpl_path = dirname(__FILE__).'/test_data';
        $css_path = sprintf('/tmp/ut-%s-%s-%d/css', md5(__CLASS__), date('YmdHis'), \Tests\Utils\PHPUnitExtension::sequenceId());
        $replace_tags = ['jpg', 'png', 'gif', 'woff2', 'woff'];

        $log_file = sprintf('/tmp/ut-%s-%s-%d/update.log', md5(__CLASS__), date('YmdHis'), \Tests\Utils\PHPUnitExtension::sequenceId());

        // 不遍历子目录
        $css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
        $success_num = $css_updater->update();
        $this->assertSame(1, $success_num);

        // 遍历子目录
        $css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags, true);
        $css_updater->setLogFile($log_file);
        $success_num = $css_updater->update();
        $this->assertSame(3, $success_num);
    }

    /**
     * @covers \CssManager\CssUpdater::create
     */
    public function testCreate()
    {
        $css_tmpl_path = dirname(__FILE__).'/test_data';
        $css_path = sprintf('/tmp/ut-%s-%s-%d/css', md5(__CLASS__), date('YmdHis'), \Tests\Utils\PHPUnitExtension::sequenceId());
        $replace_tags = ['jpg', 'png', 'gif'];

        $source_file = $css_tmpl_path.'/main.css';
        $dest_file = $css_path.'/main_update.css';

        $css_updater = new \CssManager\CssUpdater($css_tmpl_path, $css_path, $replace_tags);
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($css_updater, 'create', [$source_file, $dest_file]);
        $this->assertTrue($ret);
        $this->assertTrue(file_exists($dest_file));

        $css_content = file_get_contents($dest_file);
        $this->assertTrue(strstr($css_content, 'images/background.jpg?'.date('Ymd'))!==false);
        $this->assertTrue(strstr($css_content, 'images/header.png?'.date('Ymd'))!==false);
        $this->assertTrue(strstr($css_content, 'images/logo.gif?'.date('Ymd'))!==false);
    }
}