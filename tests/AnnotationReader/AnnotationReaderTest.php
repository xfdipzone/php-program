<?php declare(strict_types=1);
namespace Tests\AnnotationReader;

use PHPUnit\Framework\TestCase;

/**
 * 测试 php-annotation-reader\AnnotationReader\AnnotationReader
 *
 * @author fdipzone
 */
final class AnnotationReaderTest extends TestCase
{
    /**
     * @covers \AnnotationReader\AnnotationReader::__construct
     */
    public function testConstruct()
    {
        $user = new \Tests\AnnotationReader\User('fdipzone', 18, 'programmer');
        $annotation_reader = new \AnnotationReader\AnnotationReader($user);
        $this->assertEquals('AnnotationReader\AnnotationReader', get_class($annotation_reader));
    }

    /**
     * @covers \AnnotationReader\AnnotationReader::__construct
     */
    public function testConstructException()
    {
        $this->expectException(\Exception::class);

        $obj = '123';
        new \AnnotationReader\AnnotationReader($obj);
    }

    /**
     * @covers \AnnotationReader\AnnotationReader::classAnnotation
     * @covers \AnnotationReader\AnnotationReader::propertiesAnnotation
     * @covers \AnnotationReader\AnnotationReader::methodsAnnotation
     */
    public function testGetAnnotation()
    {
        $user = new \Tests\AnnotationReader\User('fdipzone', 18, 'programmer');
        $annotation_reader = new \AnnotationReader\AnnotationReader($user);

        $class_tags = new \AnnotationReader\AnnotationTags(['@description']);
        $class_annotations = $annotation_reader->classAnnotation($class_tags);
        $this->assertSame(2, count($class_annotations['@description']));
        $this->assertEquals('用户类', $class_annotations['@description'][0]);
        $this->assertEquals('用于测试', $class_annotations['@description'][1]);

        $properties_tags = new \AnnotationReader\AnnotationTags(['@Column', '@Tag']);
        $properties_annotations = $annotation_reader->propertiesAnnotation($properties_tags);
        $this->assertSame(1, count($properties_annotations['name']['@Column']));
        $this->assertEquals('name', $properties_annotations['name']['@Column'][0]);
        $this->assertSame(2, count($properties_annotations['name']['@Tag']));
        $this->assertEquals('Name', $properties_annotations['name']['@Tag'][0]);
        $this->assertEquals('中文姓名', $properties_annotations['name']['@Tag'][1]);

        $this->assertSame(1, count($properties_annotations['age']['@Column']));
        $this->assertEquals('age', $properties_annotations['age']['@Column'][0]);
        $this->assertSame(1, count($properties_annotations['age']['@Tag']));
        $this->assertEquals('Age', $properties_annotations['age']['@Tag'][0]);

        $this->assertSame(1, count($properties_annotations['profession']['@Column']));
        $this->assertEquals('profession', $properties_annotations['profession']['@Column'][0]);
        $this->assertSame(1, count($properties_annotations['profession']['@Tag']));
        $this->assertEquals('Profession', $properties_annotations['profession']['@Tag'][0]);

        $methods_tags = new \AnnotationReader\AnnotationTags(['@description']);
        $methods_annotations = $annotation_reader->methodsAnnotation($methods_tags);
        $this->assertSame(2, count($methods_annotations['name']['@description']));
        $this->assertEquals('获取姓名', $methods_annotations['name']['@description'][0]);
        $this->assertEquals('获取中文姓名', $methods_annotations['name']['@description'][1]);

        $this->assertSame(1, count($methods_annotations['age']['@description']));
        $this->assertEquals('获取年龄', $methods_annotations['age']['@description'][0]);

        $this->assertSame(1, count($methods_annotations['profession']['@description']));
        $this->assertEquals('获取职业', $methods_annotations['profession']['@description'][0]);
    }

    /**
     * @covers \AnnotationReader\AnnotationReader::parseAnnotationTags
     */
    public function testParseAnnotationTags()
    {
        $user = new \Tests\AnnotationReader\User('fdipzone', 18, 'programmer');
        $annotation_reader = new \AnnotationReader\AnnotationReader($user);

        $doc_comment = <<<TXT
/**
 * @param name
 * @param age
 * @param profession
 * @tag name
 * @tag age
 * @tag profession
 */
TXT;
        $annotation_tags = new \AnnotationReader\AnnotationTags(['@param', '@tag']);
        $ret = \Tests\Utils\PHPUnitExtension::callMethod($annotation_reader, 'parseAnnotationTags', [$doc_comment, $annotation_tags]);
        $this->assertSame(3, count($ret['@param']));
        $this->assertEquals('name', $ret['@param'][0]);
        $this->assertEquals('age', $ret['@param'][1]);
        $this->assertEquals('profession', $ret['@param'][2]);
        $this->assertSame(3, count($ret['@tag']));
        $this->assertEquals('name', $ret['@tag'][0]);
        $this->assertEquals('age', $ret['@tag'][1]);
        $this->assertEquals('profession', $ret['@tag'][2]);
    }
}