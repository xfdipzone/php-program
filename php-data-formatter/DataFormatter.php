<?php
/**
 * 数据格式化类
 * 支持将数据按 Json, XML, Array, Js Callback 格式输出
 *
 * @author fdipzone
 * @DateTime 2024-07-18 19:45:00
 *
 */
class DataFormatter
{
    /**
     * 原始数据
     *
     * @var array
     */
    private $data;

    /**
     * 初始化
     * 设置输出数据
     *
     * @author fdipzone
     * @DateTime 2024-07-18 20:03:35
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        if(empty($data))
        {
            throw new \Exception('data is empty');
        }

        $this->data = $data;
    }

    /**
     * 输出为 Json 格式
     *
     * @author fdipzone
     * @DateTime 2024-07-18 21:26:50
     *
     * @return string
     */
    public function asJson():string
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }

    /**
     * 输出为数组格式
     *
     * @author fdipzone
     * @DateTime 2024-07-18 21:27:55
     *
     * @return array
     */
    public function asArray():array
    {
        return $this->data;
    }

    /**
     * 输出为 XML 格式
     *
     * @author fdipzone
     * @DateTime 2024-07-18 22:03:47
     *
     * @param string $root_name XML 文档根元素名称
     * @param string $encoding XML 文档编码
     * @return string
     */
    public function asXML(string $root_name='root', string $encoding='utf-8'):string
    {
        // 创建 XML 字符串
        $xml_data = new \SimpleXMLElement('<?xml version="1.0" encoding="'.$encoding.'"?><' . $root_name . '></' . $root_name . '>');
        $this->arrayConvertXML($this->data, $xml_data);

        // 创建 XML 文档
        $doc = new \DOMDocument();
        $doc->loadXML(html_entity_decode($xml_data->asXML()));

        // 格式化 XML
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        return $doc->saveXML();
    }

    /**
     * 输出为 Js Callback 格式
     *
     * @author fdipzone
     * @DateTime 2024-07-19 22:12:17
     *
     * @param string $callback 回调方法名
     * @return string
     */
    public function asJsCallback(string $callback):string
    {
        if(empty($callback))
        {
            throw new \Exception('callback is empty');
        }

        return $callback.'('.json_encode($this->data).');';
    }

    /**
     * 将数组转为 XML
     * 特殊字符使用 CDATA标记，避免被转义
     *
     * @author fdipzone
     * @DateTime 2024-07-18 22:41:30
     *
     * @param array $array 数组
     * @param SimpleXMLElement $xml_data XML 元素对象指针
     * @return void
     */
    private function arrayConvertXML(array $array, SimpleXMLElement &$xml_data)
    {
        foreach($array as $key => $value)
        {
            if(is_array($value))
            {
                if(!is_numeric($key))
                {
                    $subnode = $xml_data->addChild("$key");
                    $this->arrayConvertXML($value, $subnode);
                }
                else
                {
                    $subnode = $xml_data->addChild("item$key");
                    $this->arrayConvertXML($value, $subnode);
                }
            }
            else
            {
                if (is_string($value) && (strpos($value, '<') !== false || strpos($value, '&') !== false))
                {
                    $xml_data->addChild("$key", '<![CDATA['.$value.']]>');
                }
                else
                {
                    $xml_data->addChild("$key", htmlspecialchars("$value"));
                }
            }
        }
    }
}