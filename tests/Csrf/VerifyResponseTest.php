<?php declare(strict_types=1);
namespace Tests\Csrf;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\VerifyResponse
 *
 * @author fdipzone
 */
final class VerifyResponseTest extends TestCase
{
    /**
     * @covers \Csrf\VerifyResponse::setSuccess
     * @covers \Csrf\VerifyResponse::success
     */
    public function testSetAndGetSuccess()
    {
        $response = new \Csrf\VerifyResponse;
        $this->assertTrue($response->success());

        $response->setSuccess(false);
        $this->assertFalse($response->success());

        $response->setSuccess(true);
        $this->assertTrue($response->success());
    }

    /**
     * @covers \Csrf\VerifyResponse::setErrors
     * @covers \Csrf\VerifyResponse::errors
     */
    public function testSetAndGetErrors()
    {
        $response = new \Csrf\VerifyResponse;
        $this->assertEmpty($response->errors());

        $response->setErrors(array('error1', 'error2', 'error3'));
        $errors = $response->errors();
        $this->assertSame(3, count($errors));
        $this->assertSame('error1', $errors[0]);
        $this->assertSame('error2', $errors[1]);
        $this->assertSame('error3', $errors[2]);

        $response->setErrors(array('new error'));
        $errors = $response->errors();
        $this->assertSame(1, count($errors));
        $this->assertSame('new error', $errors[0]);
    }
}