<?php declare(strict_types=1);
namespace Tests\DbModel;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-db-model\DbModel\AbstractDbModel
 *
 * @covers \DbModel\AbstractDbModel
 * @author fdipzone
 */
final class AbstractDbModelTest extends TestCase
{
    public function testAbstractDbModel()
    {
        $config = new \Tests\DbModel\TestModel\Config;
        $this->assertEquals('test_common', $config->dbName());
        $this->assertEquals('config', $config->tableName());
        $this->assertEquals('配置表', $config->tableComment());
        $this->assertEquals('InnoDB', $config->engine());
        $this->assertEquals('utf8mb4', $config->defaultCharset());
        $this->assertEquals('utf8mb4_unicode_ci', $config->collate());
        $this->assertEquals('id', $config->primaryKey());
        $this->assertEquals('1', $config->autoIncrement());
        $this->assertEquals('', $config->tableIndex());

        $user = new \Tests\DbModel\TestModel\User;
        $this->assertEquals('test_user', $user->dbName());
        $this->assertEquals('user', $user->tableName());
        $this->assertEquals('用户表', $user->tableComment());
        $this->assertEquals('InnoDB', $user->engine());
        $this->assertEquals('utf8mb4', $user->defaultCharset());
        $this->assertEquals('utf8mb4_unicode_ci', $user->collate());
        $this->assertEquals('id', $user->primaryKey());
        $this->assertEquals('1001', $user->autoIncrement());
        $this->assertEquals('UNIQUE INDEX `phone` (`phone` ASC),'.PHP_EOL.'INDEX `age` (`age` ASC)', $user->tableIndex());
    }
}