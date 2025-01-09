<?php declare(strict_types=1);
namespace Tests\Csrf;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-csrf\Csrf\Factory
 *
 * @author fdipzone
 */
final class FactoryResponseTest extends TestCase
{
    /**
     * @covers \Csrf\Factory::getTokenClass
     */
    public function testGetTokenClass()
    {
        $type = \Csrf\Type::INTERNAL_CSRF;
        $token_class = \Csrf\Factory::getTokenClass($type);
        $this->assertEquals('\Csrf\InternalCsrf', $token_class);

        $type = \Csrf\Type::GOOGLE_RECAPTCHA_V2;
        $token_class = \Csrf\Factory::getTokenClass($type);
        $this->assertEquals('\Csrf\GoogleRecaptchaV2', $token_class);
    }

    /**
     * @covers \Csrf\Factory::getTokenClass
     */
    public function testGetTokenClassException()
    {
        $this->expectException(\Csrf\Exception\TypeException::class);
        $this->expectExceptionMessage('csrf type not exists');

        $type = 'not_exists_type';
        \Csrf\Factory::getTokenClass($type);
    }

    /**
     * @covers \Csrf\Factory::make
     */
    public function testMake()
    {
        $secret = 'abc123';

        $type = \Csrf\Type::INTERNAL_CSRF;
        $config = new \Csrf\Config\InternalCsrfConfig($secret);
        $csrf = \Csrf\Factory::make($type, $config);
        $this->assertEquals('Csrf\InternalCsrf', get_class($csrf));
        $this->assertInstanceOf(\Csrf\ICsrf::class, $csrf);

        $type = \Csrf\Type::GOOGLE_RECAPTCHA_V2;
        $config = new \Csrf\Config\GoogleRecaptchaV2Config($secret);
        $csrf = \Csrf\Factory::make($type, $config);
        $this->assertEquals('Csrf\GoogleRecaptchaV2', get_class($csrf));
        $this->assertInstanceOf(\Csrf\ICsrf::class, $csrf);
    }

    /**
     * @covers \Csrf\Factory::make
     */
    public function testMakeException()
    {
        $this->expectException(\Csrf\Exception\FactoryException::class);
        $this->expectExceptionMessage('csrf type not exists');

        $type = 'not_exists_type';
        $secret = 'abc123';
        $config = new \Csrf\Config\InternalCsrfConfig($secret);
        \Csrf\Factory::make($type, $config);
    }
}