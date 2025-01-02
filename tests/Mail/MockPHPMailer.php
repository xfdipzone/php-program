<?php declare(strict_types=1);
namespace Tests\Mail;

/**
 * Mock PHP Mailer 用于单元测试
 *
 * @author fdipzone
 * @DateTime 2025-01-02 18:58:30
 *
 */
class MockPHPMailer extends \Mail\Core\PHPMailer
{
    /**
     * Mock 发送方法
     *
     * @author fdipzone
     * @DateTime 2025-01-02 18:59:14
     *
     * @return boolean
     */
    public function send()
    {
        return true;
    }
}