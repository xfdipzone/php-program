<?php declare(strict_types=1);
namespace Tests\FileParser;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-file-parser\FileParser\XmlParser
 *
 * @author fdipzone
 */
final class XmlParserTest extends TestCase
{
    // 定义用例用到的测试文件
    // XML 格式文件
    private static $xml_file = '/tmp/xml_file.xml';

    // 非 XML 格式文件
    private static $not_xml_file = '/tmp/not_xml_file.xml';

    // XML 字符串
    private static $xml_string = '<?xml version="1.0" encoding="utf-8"?>
<xmlroot>
<status>1000</status>
<info></info>
<result><id>100</id>
<name>fdipzone</name>
<gender>male</gender>
<age>28</age>
</result>
</xmlroot>';

    // 初始化测试文件
    public static function setUpBeforeClass()
    {
        file_put_contents(self::$xml_file, self::$xml_string);

        $xml_error_data = 'abc';
        file_put_contents(self::$not_xml_file, $xml_error_data);
    }

    // 删除测试文件
    public static function tearDownAfterClass()
    {
        if(file_exists(self::$xml_file))
        {
            unlink(self::$xml_file);
        }

        if(file_exists(self::$not_xml_file))
        {
            unlink(self::$not_xml_file);
        }
    }

    /**
     * @covers \FileParser\XmlParser::parseFromFile
     */
    public function testParseFromFile()
    {
        $xml_parser = new \FileParser\XmlParser;
        $response = $xml_parser->parseFromFile(self::$xml_file);
        $this->assertSame(true, $response->status());

        $data = $response->data();
        $this->assertEquals(1000, $data['status']);
        $this->assertEquals('', $data['info']);
        $this->assertEquals(100, $data['result']['id']);
        $this->assertEquals('fdipzone', $data['result']['name']);
        $this->assertEquals('male', $data['result']['gender']);
        $this->assertEquals(28, $data['result']['age']);
    }

    /**
     * @covers \FileParser\XmlParser::parseFromFile
     */
    public function testParseFromFileNotXmlFile()
    {
        $xml_parser = new \FileParser\XmlParser;
        $response = $xml_parser->parseFromFile(self::$not_xml_file);
        $this->assertSame(false, $response->status());
        $this->assertEmpty($response->data());
    }

    /**
     * @covers \FileParser\XmlParser::parseFromFile
     */
    public function testParseFromFileException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('xml parser: file not exists');

        $xml_parser = new \FileParser\XmlParser;
        $xml_parser->parseFromFile('/tmp/not_exists_file.xml');
    }

    /**
     * @covers \FileParser\XmlParser::parseFromString
     */
    public function testParseFromString()
    {
        $xml_parser = new \FileParser\XmlParser;
        $response = $xml_parser->parseFromString(self::$xml_string);
        $this->assertSame(true, $response->status());

        $data = $response->data();
        $this->assertEquals(1000, $data['status']);
        $this->assertEquals('', $data['info']);
        $this->assertEquals(100, $data['result']['id']);
        $this->assertEquals('fdipzone', $data['result']['name']);
        $this->assertEquals('male', $data['result']['gender']);
        $this->assertEquals(28, $data['result']['age']);
    }

    /**
     * @covers \FileParser\XmlParser::parseFromString
     */
    public function testParseFromStringNotXmlString()
    {
        $xml_string = 'abc';

        $xml_parser = new \FileParser\XmlParser;
        $response = $xml_parser->parseFromString($xml_string);
        $this->assertSame(false, $response->status());
        $this->assertEmpty($response->data());
    }

    /**
     * @covers \FileParser\XmlParser::validate
     */
    public function testValidate()
    {
        $xml_parser = new \FileParser\XmlParser;
        $resp = \Tests\Utils\PHPUnitExtension::callMethod($xml_parser, 'validate', [self::$xml_string]);
        $this->assertSame(true, $resp);

        $xml_string = 'abc';
        $resp = \Tests\Utils\PHPUnitExtension::callMethod($xml_parser, 'validate', [$xml_string]);
        $this->assertSame(false, $resp);
    }

    /**
     * @covers \FileParser\XmlParser::parse
     */
    public function testParse()
    {
        $xml_parser = new \FileParser\XmlParser;
        $resp = \Tests\Utils\PHPUnitExtension::callMethod($xml_parser, 'parse', [self::$xml_string]);
        $this->assertEquals(1000, $resp['status']);
        $this->assertEquals('', $resp['info']);
        $this->assertEquals(100, $resp['result']['id']);
        $this->assertEquals('fdipzone', $resp['result']['name']);
        $this->assertEquals('male', $resp['result']['gender']);
        $this->assertEquals(28, $resp['result']['age']);
    }

    /**
     * @covers \FileParser\XmlParser::parse
     */
    public function testParseFail()
    {
        $xml_string = 'abc';
        $xml_parser = new \FileParser\XmlParser;
        $resp = \Tests\Utils\PHPUnitExtension::callMethod($xml_parser, 'parse', [$xml_string]);
        $this->assertEmpty($resp);
    }

    /**
     * @covers \FileParser\XmlParser::objectToArray
     */
    public function testObjectToArray()
    {
        $xml_parser = new \FileParser\XmlParser;

        $xml_obj = simplexml_load_string(self::$xml_string, 'SimpleXMLElement', LIBXML_NOCDATA);
        \Tests\Utils\PHPUnitExtension::callMethod($xml_parser, 'objectToArray', [&$xml_obj]);

        $this->assertEquals(1000, $xml_obj['status']);
        $this->assertEquals('', $xml_obj['info']);
        $this->assertEquals(100, $xml_obj['result']['id']);
        $this->assertEquals('fdipzone', $xml_obj['result']['name']);
        $this->assertEquals('male', $xml_obj['result']['gender']);
        $this->assertEquals(28, $xml_obj['result']['age']);
    }
}