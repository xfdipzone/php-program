<?php declare(strict_types=1);
namespace Tests\SharedData;

use PHPUnit\Framework\TestCase;

/**
 * 共享内存单元测试用例父类
 * 用于提供共享内存单元测试公用方法
 *
 * @author fdipzone
 */
abstract class AbstractSharedMemoryTestCase extends TestCase
{
    // 初始化测试用例设置
    protected function setUp()
    {
        // 设置 Warning 级别处理方法
        set_error_handler([$this, 'handleWarningAsIgnore'], E_WARNING);
    }

    // 清理测试用例设置
    protected function tearDown()
    {
        restore_error_handler();
    }

    // 忽略 Warning 处理
    public function handleWarningAsIgnore($err_no, $err_str, $err_file, $err_line)
    {
        // 忽略警告
    }

    // 生成共享数据标识，用于测试
    protected function generateSharedKey():string
    {
        return sprintf('ut-%s-sm-key-%s-%d', md5(__CLASS__), date('YmdHis'), \Tests\Utils\PHPUnitExtension::sequenceId());
    }
}