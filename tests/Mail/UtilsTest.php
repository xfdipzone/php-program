<?php declare(strict_types=1);
namespace Tests\Mail;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-mailer\Mail\Utils
 *
 * @author fdipzone
 */
final class UtilsTest extends TestCase
{
    /**
     * @covers \Mail\Utils::validateEmail
     */
    public function testValidateEmail()
    {
        $email = 'technology@zone.com';
        $ret = \Mail\Utils::validateEmail($email);
        $this->assertTrue($ret);

        $email = 'good@good';
        $ret = \Mail\Utils::validateEmail($email);
        $this->assertFalse($ret);
    }
}