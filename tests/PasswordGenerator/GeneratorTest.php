<?php declare(strict_types=1);
namespace Tests\PasswordGenerator;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-password-generator\PasswordGenerator\Generator
 *
 * @author fdipzone
 */
final class GeneratorTest extends TestCase
{
    /**
     * @covers \PasswordGenerator\Generator::generate
     */
    public function testGenerate()
    {
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $passwords = \PasswordGenerator\Generator::generate($rule, 2);
        $this->assertSame(2, count($passwords));
        $this->assertTrue($passwords[0]!='');
        $this->assertTrue($passwords[1]!='');
    }

    /**
     * @covers \PasswordGenerator\Generator::generate
     */
    public function testGenerateNumLowerLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator: the number of passwords generate must be between 1 and 100');

        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);

        \PasswordGenerator\Generator::generate($rule, 0);
    }

    /**
     * @covers \PasswordGenerator\Generator::generate
     */
    public function testGenerateNumUpperLimitException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator: the number of passwords generate must be between 1 and 100');

        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);

        \PasswordGenerator\Generator::generate($rule, 101);
    }

    /**
     * @covers \PasswordGenerator\Generator::generate
     */
    public function testGenerateRuleNotSettingException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator: rule not setting any options');

        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $rule->setHasUppercase(false);
        $rule->setHasLowercase(false);
        $rule->setHasNumber(false);
        $rule->setHasSpecialCharacter(false);

        \PasswordGenerator\Generator::generate($rule, 1);
    }

    /**
     * @covers \PasswordGenerator\Generator::generate
     */
    public function testGenerateRuleSpecialCharacterException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('password generator: rule required special character but not setting special characters');

        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $rule->setHasSpecialCharacter(true);

        // 设置可用的特殊字符集合为空
        \Tests\Utils\PHPUnitExtension::setVariable($rule, 'special_characters', '');
        $this->assertEquals('', $rule->specialCharacters());

        \PasswordGenerator\Generator::generate($rule, 1);
    }

    /**
     * @covers \PasswordGenerator\Generator::create
     */
    public function testCreate()
    {
        $upper_letter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower_letter = 'abcdefghijklmnopqrstuvwxyz';
        $number = '1234567890';

        // 只有大写字母
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $rule->setHasUppercase(true);
        $rule->setHasLowercase(false);
        $rule->setHasNumber(false);
        $rule->setHasSpecialCharacter(false);

        $password = \Tests\Utils\PHPUnitExtension::callStaticMethod('\PasswordGenerator\Generator', 'create', [$rule]);
        $this->assertEquals($length, strlen($password));
        $this->assertTrue(\Tests\Utils\PHPUnitExtension::containInString($password, $upper_letter));

        // 只有小写字母
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $rule->setHasUppercase(false);
        $rule->setHasLowercase(true);
        $rule->setHasNumber(false);
        $rule->setHasSpecialCharacter(false);

        $password = \Tests\Utils\PHPUnitExtension::callStaticMethod('\PasswordGenerator\Generator', 'create', [$rule]);
        $this->assertEquals($length, strlen($password));
        $this->assertTrue(\Tests\Utils\PHPUnitExtension::containInString($password, $lower_letter));

        // 只有数字
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $rule->setHasUppercase(false);
        $rule->setHasLowercase(false);
        $rule->setHasNumber(true);
        $rule->setHasSpecialCharacter(false);

        $password = \Tests\Utils\PHPUnitExtension::callStaticMethod('\PasswordGenerator\Generator', 'create', [$rule]);
        $this->assertEquals($length, strlen($password));
        $this->assertTrue(\Tests\Utils\PHPUnitExtension::containInString($password, $number));

        // 只有特殊字符
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $rule->setHasUppercase(false);
        $rule->setHasLowercase(false);
        $rule->setHasNumber(false);
        $rule->setHasSpecialCharacter(true);
        $rule->setSpecialCharacters('!@#$');

        $password = \Tests\Utils\PHPUnitExtension::callStaticMethod('\PasswordGenerator\Generator', 'create', [$rule]);
        $this->assertEquals($length, strlen($password));
        $this->assertTrue(\Tests\Utils\PHPUnitExtension::containInString($password, '!@#$'));

        // 包含四种字符
        $length = 8;
        $rule = new \PasswordGenerator\Rule($length);
        $rule->setHasUppercase(true);
        $rule->setHasLowercase(true);
        $rule->setHasNumber(true);
        $rule->setHasSpecialCharacter(true);
        $rule->setSpecialCharacters('!@#$');

        $password = \Tests\Utils\PHPUnitExtension::callStaticMethod('\PasswordGenerator\Generator', 'create', [$rule]);
        $this->assertEquals($length, strlen($password));

        $strings = $upper_letter.$lower_letter.$number.'!@#$';
        $this->assertTrue(\Tests\Utils\PHPUnitExtension::containInString($password, $strings));
    }
}