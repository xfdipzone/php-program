<?php
/**
 * php html标记属性过滤器
 *
 * @author terry
 * @DateTime 2023-04-19 21:34:44
 *
 * Description:
 * php实现对html标记中属性进行过滤
 *
 * Func:
 * public  strip             过滤属性
 * public  setAllow          设置允许的属性
 * public  setException      设置特例
 * public  setIgnore         设置忽略的标记
 * private findElements      搜寻需要处理的元素
 * private findAttributes    搜寻属性
 * private removeAttributes  移除属性
 * private isException       判断是否特例
 * private createAttributes  创建属性
 * private protect           特殊字符转义
 */
class HtmlAttribFilter{

    /**
     * 源字符串
     *
     * @var string
     */
    private $_str = '';

    /**
     * 允许保留的属性
     * 例如:array('id','class','title')
     *
     * @var array
     */
    private $_allow = array();

    /**
     * 特例
     * 例如:array('a'=>array('href','class'),'span'=>array('class'))
     *
     * @var array
     */
    private $_exception = array();

    /**
     * 忽略过滤的标记
     * 例如:array('span','img')
     *
     * @var array
     */
    private $_ignore = array();

    /**
     * 处理HTML,过滤不保留的属性
     *
     * @author terry
     * @DateTime 2023-04-19 21:38:41
     *
     * @param string $str
     * @return string
     */
    public function strip(string $str):string{
        $this->_str = $str;

        if(is_string($this->_str) && strlen($this->_str)>0){ // 判断字符串

            $this->_str = strtolower($this->_str); // 转成小写

            $res = $this->findElements();
            if(is_string($res)){
                return $res;
            }
            $nodes = $this->findAttributes($res);
            $this->removeAttributes($nodes);
        }

        return $this->_str;
    }

    /**
     * 设置允许的属性
     *
     * @author terry
     * @DateTime 2023-04-19 21:43:23
     *
     * @param array $param 允许的属性
     * @return void
     */
    public function setAllow(array $param):void{
        if(!$param){
            throw new \Exception('set allow error');
        }
        $this->_allow = $param;
    }

    /**
     * 设置特例标记属性
     *
     * @author terry
     * @DateTime 2023-04-19 21:46:15
     *
     * @param array $param 特例标记属性
     * @return void
     */
    public function setException(array $param):void{
        if(!$param){
            throw new \Exception('set exception error');
        }
        $this->_exception = $param;
    }

    /**
     * 设置忽略的标记
     *
     * @author terry
     * @DateTime 2023-04-19 21:47:46
     *
     * @param array $param 忽略的标记
     * @return void
     */
    public function setIgnore(array $param):void{
        if(!$param){
            throw new \Exception('set ignore error');
        }
        $this->_ignore = $param;
    }

    /**
     * 遍历需要处理的元素
     *
     * @author terry
     * @DateTime 2023-04-19 21:48:28
     *
     * @return array
     */
    private function findElements():array{
        $nodes = array();
        preg_match_all("/<([^ !\/\>\n]+)([^>]*)>/i", $this->_str, $elements);
        foreach($elements[1] as $el_key => $element){
            if($elements[2][$el_key]){
                $literal = $elements[0][$el_key];
                $element_name = $elements[1][$el_key];
                $attributes = $elements[2][$el_key];
                if(is_array($this->_ignore) && !in_array($element_name, $this->_ignore)){
                    $nodes[] = array('literal'=>$literal, 'name'=>$element_name, 'attributes'=>$attributes);
                }
            }
        }

        if(!$nodes[0]){
            return $this->_str;
        }else{
            return $nodes;
        }
    }

    /**
     * 搜索需要处理的属性
     *
     * @author terry
     * @DateTime 2023-04-19 21:49:02
     *
     * @param array $nodes 需要处理的元素
     * @return array
     */
    private function findAttributes(array $nodes):array{
        foreach($nodes as &$node){
            preg_match_all("/([^ =]+)\s*=\s*[\"|']{0,1}([^\"']*)[\"|']{0,1}/i", $node['attributes'], $attributes);
            if($attributes[1]){
                foreach($attributes[1] as $att_key=>$att){
                    $literal = $attributes[0][$att_key];
                    $attribute_name = $attributes[1][$att_key];
                    $value = $attributes[2][$att_key];
                    $attribs[] = array('literal'=>$literal, 'name'=>$attribute_name, 'value'=>$value);
                }
            }else{
                $node['attributes'] = null;
            }
            $node['attributes'] = $attribs;
            unset($attribs);
        }
        return $nodes;
    }

    /**
     * 移除属性
     *
     * @author terry
     * @DateTime 2023-04-19 21:54:02
     *
     * @param array $nodes 需要处理的元素
     * @return void
     */
    private function removeAttributes(array $nodes):void{
        foreach($nodes as $node){
            $node_name = $node['name'];
            $new_attributes = '';
            if(is_array($node['attributes'])){
                foreach($node['attributes'] as $attribute){
                    if((is_array($this->_allow) && in_array($attribute['name'], $this->_allow)) || $this->isException($node_name, $attribute['name'])){
                        $new_attributes .= ($new_attributes==''? '' : ' ') . $this->createAttributes($attribute['name'], $attribute['value']);
                    }
                }
            }
            $replacement = ($new_attributes) ? "<$node_name $new_attributes>" : "<$node_name>";
            $this->_str = preg_replace('/'.$this->protect($node['literal']).'/', $replacement, $this->_str);
        }
    }

    /**
     * 判断是否特例
     *
     * @author terry
     * @DateTime 2023-04-19 21:56:04
     *
     * @param string $element_name   元素名称
     * @param string $attribute_name 属性名称
     * @return boolean
     */
    private function isException(string $element_name, string $attribute_name):bool{
        if(array_key_exists($element_name, $this->_exception)){
            if(in_array($attribute_name, $this->_exception[$element_name])){
                return true;
            }
        }
        return false;
    }

    /**
     * 根据设置重新创建标记属性
     *
     * @author terry
     * @DateTime 2023-04-19 22:04:23
     *
     * @param string $name  属性名称
     * @param string $value 属性值
     * @return string
     */
    private function createAttributes(string $name, string $value):string{
        return "$name=\"$value\"";
    }

    /**
     * 特殊字符转义
     *
     * @author terry
     * @DateTime 2023-04-19 22:01:00
     *
     * @param string $str
     * @return string
     */
    private function protect(string $str):string{
        $conversions = array(
            "^" => "\^",
            "[" => "\[",
            "." => "\.",
            "$" => "\$",
            "{" => "\{",
            "*" => "\*",
            "(" => "\(",
            "\\" => "\\\\",
            "/" => "\/",
            "+" => "\+",
            ")" => "\)",
            "|" => "\|",
            "?" => "\?",
            "<" => "\<",
            ">" => "\>"
        );
        return strtr($str, $conversions);
    }

}