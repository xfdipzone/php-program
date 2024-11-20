<?php declare(strict_types=1);
namespace Tests\PasswordGenerator;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-password-generator\PasswordGenerator\Rule
 *
 * @author fdipzone
 */
final class RuleTest extends TestCase
{
    /**
     * @covers \PasswordGenerator\Rule::__construct
     */
    public function testConstruct()
    {
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $this->assertEquals('PasswordGenerator\Rule', get_class($rule));
    }

    /**
     * @covers \PasswordGenerator\Rule::__construct
     */
    public function testConstructLengthLowerLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator rule: password length must be between 4 and 64');

        $length = 3;
        new \PasswordGenerator\Rule($length);
    }

    /**
     * @covers \PasswordGenerator\Rule::__construct
     */
    public function testConstructLengthUpperLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator rule: password length must be between 4 and 64');

        $length = 65;
        new \PasswordGenerator\Rule($length);
    }

    /**
     * @covers \PasswordGenerator\Rule::length
     * @covers \PasswordGenerator\Rule::setHasUppercase
     * @covers \PasswordGenerator\Rule::hasUppercase
     * @covers \PasswordGenerator\Rule::setHasLowercase
     * @covers \PasswordGenerator\Rule::hasLowercase
     * @covers \PasswordGenerator\Rule::setHasNumber
     * @covers \PasswordGenerator\Rule::hasNumber
     * @covers \PasswordGenerator\Rule::setHasSpecialCharacter
     * @covers \PasswordGenerator\Rule::hasSpecialCharacter
     */
    public function testSetGet()
    {
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);

        $rule->setHasUppercase(true);
        $rule->setHasLowercase(false);
        $rule->setHasNumber(true);
        $rule->setHasSpecialCharacter(false);

        $this->assertEquals($length, $rule->length());
        $this->assertTrue($rule->hasUppercase());
        $this->assertFalse($rule->hasLowercase());
        $this->assertTrue($rule->hasNumber());
        $this->assertFalse($rule->hasSpecialCharacter());
    }

    /**
     * @covers \PasswordGenerator\Rule::setSpecialCharacters
     * @covers \PasswordGenerator\Rule::specialCharacters
     */
    public function testSpecialCharacters()
    {
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);

        $special_characters = '!@#$';
        $rule->setSpecialCharacters($special_characters);
        $this->assertEquals($special_characters, $rule->specialCharacters());
    }

    /**
     * @covers \PasswordGenerator\Rule::setSpecialCharacters
     */
    public function testSpecialCharactersEmptyException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator rule: special characters is empty');

        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);

        $special_characters = '';
        $rule->setSpecialCharacters($special_characters);
    }

    /**
     * @covers \PasswordGenerator\Rule::setSpecialCharacters
     */
    public function testSpecialCharactersInvalidException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator rule: special characters can not include letter and number');

        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);

        $special_characters = '!@#$A';
        $rule->setSpecialCharacters($special_characters);
    }

    /**
     * @covers \PasswordGenerator\Rule::validateSpecialCharacters
     */
    public function testValidateSpecialCharacters()
    {
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);

        $special_characters = '!@#$';
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($rule, 'validateSpecialCharacters', [$special_characters]);
        $this->assertTrue($ret);

        $special_characters = '!@#$A';
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($rule, 'validateSpecialCharacters', [$special_characters]);
        $this->assertFalse($ret);
    }
}