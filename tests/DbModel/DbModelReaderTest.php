<?php declare(strict_types=1);
namespace Tests\DbModel;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-db-model\DbModel\DbModelReader
 *
 * @author fdipzone
 */
final class DbModelReaderTest extends TestCase
{
    /**
     * @covers \DbModel\DbModelReader::generateCreateTableSql
     */
    public function testGenerateCreateTableSql()
    {
        // 测试生成配置表SQL
        $config = new \Tests\DbModel\TestModel\Config;
        $config_sql = \DbModel\DbModelReader::generateCreateTableSql($config);
        $expected_config_sql = <<<TXT
CREATE TABLE `test_common`.`config` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置id',
`content` text NOT NULL COMMENT '配置内容',
PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '配置表';
TXT;
        $this->assertEquals($expected_config_sql, $config_sql);

        // 测试生成用户表SQL
        $user = new \Tests\DbModel\TestModel\User;
        $user_sql = \DbModel\DbModelReader::generateCreateTableSql($user);
        $expected_user_sql = <<<TXT
CREATE TABLE `test_user`.`user` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
`phone` varchar(11) NOT NULL COMMENT '电话号码',
`name` varchar(11) NOT NULL DEFAULT '' COMMENT '姓名',
`age` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '年龄',
`remark` text NOT NULL COMMENT '备注',
UNIQUE INDEX `phone` (`phone` ASC),
INDEX `age` (`age` ASC),
PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT '用户表';
TXT;
        $this->assertEquals($expected_user_sql, $user_sql);
    }

    /**
     * @covers \DbModel\DbModelReader::primaryKeySql
     */
    public function testPrimaryKeySql()
    {
        $cases = array(
            array(
                'pk' => 'id',
                'expected_primary_key_sql' => '`id`',
            ),
            array(
                'pk' => 'id,create_time',
                'expected_primary_key_sql' => '`id`,`create_time`',
            ),
        );

        foreach($cases as $case)
        {
            $primary_key_sql = \Tests\Utils\PHPUnitExtension::callStaticMethod('\DbModel\DbModelReader', 'primaryKeySql', [$case['pk']]);
            $this->assertEquals($case['expected_primary_key_sql'], $primary_key_sql);
        }
    }

    /**
     * @covers \DbModel\DbModelReader::autoIncrementSql
     */
    public function testAutoIncrementSql()
    {
        $cases = array(
            array(
                'auto_increment' => 100,
                'expected_auto_increment_sql' => 'AUTO_INCREMENT=100',
            ),
            array(
                'auto_increment' => \DbModel\Constants::NO_AUTO_INCREMENT,
                'expected_auto_increment_sql' => '',
            ),
        );

        foreach($cases as $case)
        {
            $auto_increment_sql = \Tests\Utils\PHPUnitExtension::callStaticMethod('\DbModel\DbModelReader', 'autoIncrementSql', [$case['auto_increment']]);
            $this->assertEquals($case['expected_auto_increment_sql'], $auto_increment_sql);
        }
    }
}