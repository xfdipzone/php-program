<?php
/**
 * 遍历文件夹及子文件夹文件，清除utf8+bom头（0xEF 0xBB 0xBF）
 *
 * @author fdipzone
 * @DateTime 2023-08-01 16:47:12
 *
 */
class UnsetUtf8Bom extends AbstractFindFile
{
    /**
     * 设置要处理的文件类型
     *
     * @var array
     */
    private $file_type = [];

    /**
     * 已处理的文件
     *
     * @var array
     */
    private $files = [];

    /**
     * 初始化，设置需要处理的文件类型
     *
     * @author fdipzone
     * @DateTime 2023-08-01 16:56:51
     *
     * @param array $file_type
     */
    public function __construct(array $file_type=[])
    {
        if($file_type)
        {
            $this->file_type = $file_type;
        }
    }

    /**
     * 输出已执行处理的文件列表
     *
     * @author fdipzone
     * @DateTime 2023-08-01 17:40:29
     *
     * @return array
     */
    public function response():array
    {
        return $this->files;
    }

    /**
     * 对文件执行处理
     * 实现父类的抽象方法
     *
     * @author fdipzone
     * @DateTime 2023-08-01 16:49:05
     *
     * @param string $file 文件
     * @return void
     */
    protected function process(string $file):void
    {
        // 检查文件类型及是否包含utf8+Bom
        if($this->checkFileExtension($file) && $this->checkUtf8Bom($file))
        {
            // 清除文件的utf8+Bom
            $this->clearUtf8Bom($file);

            // 记录到已处理文件列表
            $this->files[] = $file;
        }
    }

    /**
     * 检查文件是否带有utf8+bom头
     *
     * @author fdipzone
     * @DateTime 2023-08-01 16:59:19
     *
     * @param string $file 文件
     * @return boolean
     */
    private function checkUtf8Bom(string $file):bool
    {
        $is_utf8_bom = false;

        // 读取文件头三个字节
        $fp = fopen($file, 'rb');
        if($fp)
        {
            if(filesize($file)>=3)
            {
                $file_header = fread($fp, 3);
                if(ord(substr($file_header,0,1))===0xEF && ord(substr($file_header,1,1))===0xBB && ord(substr($file_header,2,1))===0xBF)
                {
                    $is_utf8_bom = true;
                }
            }
            fclose($fp);
        }

        return $is_utf8_bom;
    }

    /**
     * 清除文件utf8+bom头
     *
     * @author fdipzone
     * @DateTime 2023-08-01 17:00:38
     *
     * @param string $file 带有utf8+bom头的文件
     * @return void
     */
    private function clearUtf8Bom(string $file):void
    {
        $fp = fopen($file, 'r+b');
        if($fp)
        {
            // 将文件指针移动到文件开头
            fseek($fp, 3);

            // 读取文件指针当前位置之后的内容
            $content = fread($fp, filesize($file)-3);

            // 将文件指针重置到文件开头
            fseek($fp, 0);

            // 写入文件
            fwrite($fp, $content);

            // 在当前位置截断
            ftruncate($fp, ftell($fp));

            // 关闭文件
            fclose($fp);
        }
        else
        {
            throw new \Exception(sprintf('file: %s can not open', $file));
        }
    }

    /**
     * 检查是否需要处理的文件类型
     *
     * @author fdipzone
     * @DateTime 2023-08-01 17:17:01
     *
     * @param string $file 文件
     * @return boolean
     */
    private function checkFileExtension(string $file):bool
    {
        $extension = strtolower(substr($file, strrpos($file, '.')+1));
        return in_array($extension, $this->file_type)? true : false;
    }
}