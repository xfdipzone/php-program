<?php
namespace FileParser;

/**
 * XML 文件解析器
 * 解析 XML 格式的文件
 *
 * @author fdipzone
 * @DateTime 2024-08-31 18:59:39
 *
 */
class XmlParser implements \FileParser\IFileParser
{
    /**
     * 解析文件
     *
     * @author fdipzone
     * @DateTime 2024-08-31 18:55:56
     *
     * @param string $file 文件路径
     * @return \FileParser\Response
     */
    public function parseFromFile(string $file):\FileParser\Response
    {
        // 检查文件是否存在
        if(!file_exists($file))
        {
            throw new \Exception('xml parser: file not exists');
        }

        // 检查文件内容是否为 XML 格式
        $content = file_get_contents($file);

        if(!$this->validate($content))
        {
            $response = new \FileParser\Response(false);
            return $response;
        }

        // 解析
        $data = $this->parse($content);

        $response = new \FileParser\Response(true, $data);
        return $response;
    }

    /**
     * 解析文件内容字符串
     *
     * @author fdipzone
     * @DateTime 2024-08-31 18:56:13
     *
     * @param string $str 文件内容字符串
     * @return \FileParser\Response
     */
    public function parseFromString(string $str):\FileParser\Response
    {
        // 检查字符串是否为 XML 格式
        if(!$this->validate($str))
        {
            $response = new \FileParser\Response(false);
            return $response;
        }

        // 解析
        $data = $this->parse($str);

        $response = new \FileParser\Response(true, $data);
        return $response;

    }

    /**
     * 验证字符串是否 XML 格式
     *
     * @author fdipzone
     * @DateTime 2024-08-31 21:35:27
     *
     * @param string $xml_string XML 字符串
     * @return boolean
     */
    private function validate(string $xml_string):bool
    {
        $xml_parser_obj = xml_parser_create();
        if(xml_parse_into_struct($xml_parser_obj, $xml_string, $values, $index)===1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 解析 XML 字符串为数组
     *
     * @author fdipzone
     * @DateTime 2024-08-31 21:38:05
     *
     * @param string $xml_string XML 字符串
     * @return array
     */
    private function parse(string $xml_string):array
    {
        try
        {
            // xml to object
            $obj = simplexml_load_string($xml_string, 'SimpleXMLElement', LIBXML_NOCDATA);

            // object to array
            $this->objectToArray($obj);

            return (array)$obj;
        }
        catch(\Throwable $e)
        {
            return [];
        }
    }

    /**
     * 将 XML 元素对象转为数组
     *
     * @author fdipzone
     * @DateTime 2024-08-31 21:52:36
     *
     * @param \SimpleXMLElement $object XML 元素对象指针
     * @return void
     */
    private function objectToArray(\SimpleXMLElement &$object):void
    {
        $object = (array)$object;

        foreach($object as $key=>$value)
        {
            if($value=='')
            {
                $object[$key] = '';
            }
            else
            {
                if(is_object($value) || is_array($value))
                {
                    $this->objectToArray($value);
                    $object[$key] = $value;
                }
            }
        }
    }
}