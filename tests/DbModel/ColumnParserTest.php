<?php declare(strict_types=1);
namespace Tests\DbModel;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-db-model\DbModel\ColumnParser
 *
 * @author fdipzone
 */
final class ColumnParserTest extends TestCase
{
    /**
     * @covers \DbModel\ColumnParser::convertToColumnSql
     */
    public function testConvertToColumnSql()
    {
        $cases = array(
            array(
                'column_setting' => "name=id type=int length=11 is_null=0 is_unsigned=1 auto_increment=1 comment=用户id",
                'expected_sql' => "`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id'",
            ),
            array(
                'column_setting' => "name=phone type=varchar length=11 is_null=0 comment=电话号码",
                'expected_sql' => "`phone` varchar(11) NOT NULL COMMENT '电话号码'",
            ),
            array(
                'column_setting' => "name=name type=varchar length=11 is_null=0 default='' comment=姓名",
                'expected_sql' => "`name` varchar(11) NOT NULL DEFAULT '' COMMENT '姓名'",
            ),
            array(
                'column_setting' => "name=age type=tinyint length=3 is_null=0 is_unsigned=1 default=0 comment=年龄",
                'expected_sql' => "`age` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '年龄'",
            ),
            array(
                'column_setting' => "name=remark type=text is_null=0 comment=备注",
                'expected_sql' => "`remark` text NOT NULL COMMENT '备注'",
            ),
        );

        foreach($cases as $case)
        {
            $column_sql = \Tests\Utils\PHPUnitExtension::callStaticMethod('\DbModel\ColumnParser', 'convertToColumnSql', [$case['column_setting']]);
            $this->assertEquals($case['expected_sql'], $column_sql);
        }
    }

    /**
     * @covers \DbModel\ColumnParser::convertToColumnSql
     */
    public function testConvertToColumnSqlNameException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('db model column parser: column name cannot be null');

        $column_setting = "type=int length=11 is_null=0 is_unsigned=1 auto_increment=1 comment=用户id";
        \Tests\Utils\PHPUnitExtension::callStaticMethod('\DbModel\ColumnParser', 'convertToColumnSql', [$column_setting]);
    }

    /**
     * @covers \DbModel\ColumnParser::convertToColumnSql
     */
    public function testConvertToColumnSqlTypeException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('db model column parser: column type cannot be null');

        $column_setting = "name=id length=11 is_null=0 is_unsigned=1 auto_increment=1 comment=用户id";
        \Tests\Utils\PHPUnitExtension::callStaticMethod('\DbModel\ColumnParser', 'convertToColumnSql', [$column_setting]);
    }

    /**
     * @covers \DbModel\ColumnParser::parseColumnSetting
     */
    public function testParseColumnSetting()
    {
        $cases = array(
            array(
                'column_setting' => "name=id type=int length=11 is_null=0 is_unsigned=1 auto_increment=1 comment=用户id",
                'expected_column_kv_setting' => [
                    'name'=>'id', 'type'=>'int', 'length'=>11, 'is_null'=>0, 'is_unsigned'=>1, 'auto_increment'=>1, 'comment'=>'用户id'
                ],
            ),
            array(
                'column_setting' => "name=phone type=varchar length=11 is_null=0 comment=电话号码",
                'expected_column_kv_setting' => [
                    'name'=>'phone', 'type'=>'varchar', 'length'=>11, 'is_null'=>0, 'comment'=>'电话号码'
                ],
            ),
            array(
                'column_setting' => "name=name type=varchar length=11 is_null=0 default='' comment=姓名",
                'expected_column_kv_setting' => [
                    'name'=>'name', 'type'=>'varchar', 'length'=>11, 'is_null'=>0, 'default'=>"''", 'comment'=>'姓名'
                ],
            ),
            array(
                'column_setting' => "name=age type=tinyint length=3 is_null=0 is_unsigned=1 default=0 comment=年龄",
                'expected_column_kv_setting' => [
                    'name'=>'age', 'type'=>'tinyint', 'length'=>3, 'is_null'=>0, 'is_unsigned'=>1, 'default'=>0, 'comment'=>'年龄'
                ],
            ),
            array(
                'column_setting' => "name=remark type=text is_null=0 comment=备注",
                'expected_column_kv_setting' => [
                    'name'=>'remark', 'type'=>'text', 'is_null'=>0, 'comment'=>'备注'
                ],
            ),
        );

        foreach($cases as $case)
        {
            $column_kv_setting = \Tests\Utils\PHPUnitExtension::callStaticMethod('\DbModel\ColumnParser', 'parseColumnSetting', [$case['column_setting']]);
            $this->assertEquals($case['expected_column_kv_setting'], $column_kv_setting);
        }
    }
}