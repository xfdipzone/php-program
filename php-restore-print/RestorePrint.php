<?php
/**
 * 将 php print_r 方法执行结果还原为原始数组
 *
 * @author fdipzone
 * @DateTime 2024-05-23 17:53:28
 *
 */
class RestorePrint
{
    /**
     * 保存还原的原始数组
     *
     * @var array
     */
    private $res = [];

    /**
     * 保存标记字典对应的处理方法
     *
     * @var array
     */
    private $dict = [];

    /**
     * 缓冲，用于拼接字符串
     *
     * @var string
     */
    private $buffer = '';

    /**
     * 标记
     *
     * @var string
     */
    private $key = '';

    /**
     * 堆栈，用于处理边界符匹配
     *
     * @var array
     */
    private $stack = [];

    /**
     * print_r 执行结果
     *
     * @var string
     */
    private $tmp_doc;

    /**
     * print_r 执行结果长度
     *
     * @var int
     */
    private $tmp_len;

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2024-05-23 17:54:14
     *
     */
    public function __construct()
    {
        $this->stack[] = & $this->res;
    }

    /**
     * 使用 __call 魔术方法截获未定义方法的调用
     * 如调用了未定义方法，抛出异常
     *
     * @author fdipzone
     * @DateTime 2024-05-23 18:04:41
     *
     * @param string $method 方法
     * @param array $param 参数
     * @return void
     */
    public function __call(string $method, array $param):void
    {
        throw new \Exception(sprintf('%s not defined method: %s param:%s', $this->buffer, $method, implode(',', $param)));
    }

    /**
     * 设置字典关键字的处理方法
     * dict 使用了前缀树（Trie）数据结构存储
     *
     * @author fdipzone
     * @DateTime 2024-05-23 18:10:14
     *
     * @param mixed $word 字典关键字（字符串或数组）
     * @param string $value 处理方法
     * @return RestorePrint
     */
    public function set($word, string $value=''):RestorePrint
    {
        if(is_array($word))
        {
            foreach($word as $k=>$v)
            {
                $this->set($k, $v);
            }
        }

        $p = & $this->dict;
        foreach(str_split($word) as $ch)
        {
            if(!isset($p[$ch]))
            {
                $p[$ch] = [];
            }
            $p = & $p[$ch];
        }

        $p['val'] = $value;

        return $this;
    }

    /**
     * 解析 php print_r 方法执行结果，还原为原始数组
     *
     * @author fdipzone
     * @DateTime 2024-05-23 18:26:17
     *
     * @param string $str print_r 执行后的结果
     * @return array
     */
    public function parse(string $str):array
    {
        $this->tmp_doc = $str;
        $this->tmp_len = strlen($str);

        $i = 0;
        while($i < $this->tmp_len)
        {
            $t = $this->find($this->dict, $i);
            if($t)
            {
                $i = $t;
                $this->buffer = '';
            }
            else
            {
                $this->buffer .= $this->tmp_doc[$i++];
            }
        }

        return $this->res;
    }

    /**
     * 查找字典，调用设置的处理方法
     * 返回已处理的下标
     *
     * @author fdipzone
     * @DateTime 2024-05-23 19:09:32
     *
     * @param mixed $p
     * @param int $i 下标
     * @return int
     */
    private function find(&$p, int $i):int
    {
        if($i >= $this->tmp_len)
        {
            return $i;
        }

        $t = 0;
        $n = $this->tmp_doc[$i];
        if(isset($p[$n]))
        {
            $t = $this->find($p[$n], $i+1);
        }

        if($t)
        {
            return $t;
        }

        if(isset($p['val']))
        {
            $arr = explode(',', $p['val']);
            call_user_func_array(array($this, array_shift($arr)), $arr);
            return $i;
        }

        return $t;
    }

    /**
     * 分组处理
     *
     * @author fdipzone
     * @DateTime 2024-05-23 19:13:19
     *
     * @return void
     */
    private function group():void
    {
        if(!$this->key)
        {
            return;
        }

        $cnt = count($this->stack) - 1;
        $this->stack[$cnt][$this->key] = [];
        $this->stack[] = & $this->stack[$cnt][$this->key];
        $this->key = '';
    }

    /**
     * 边界符处理
     *
     * @author fdipzone
     * @DateTime 2024-05-23 19:13:28
     *
     * @param string $c 边界符
     * @return void
     */
    private function brackets(string $c):void
    {
        $cnt = count($this->stack) - 1;

        switch($c)
        {
            case ')':
                if($this->key)
                {
                    $this->stack[$cnt][$this->key] = trim($this->buffer);
                }
                $this->key = '';
                array_pop($this->stack);
                break;

            case '[':
                if($this->key)
                {
                    $this->stack[$cnt][$this->key] = trim($this->buffer);
                }
                break;

            case ']':
                $this->key = $this->buffer;
                break;
        }

        $this->buffer = '';
    }
}