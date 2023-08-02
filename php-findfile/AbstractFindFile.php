<?php
/**
 * php 遍历文件夹处理类
 * 可以设置遍历的文件夹深度，并对遍历出的文件执行自定义处理
 * 处理逻辑由继承的子类实现
 *
 * @author fdipzone
 * @DateTime 2023-08-01 16:12:19
 *
 */
abstract class AbstractFindFile
{
    /**
     * 搜索深度，默认搜索全部
     *
     * @var int
     */
    private $max_depth = 0;

    /**
     * 抽象方法，用于对遍历的文件进行处理
     * 由继承的子类实现
     *
     * @author fdipzone
     * @DateTime 2023-08-01 16:29:12
     *
     * @param string $file 文件
     * @return void
     */
    abstract protected function process(string $file):void;

    /**
     * 根据遍历的文件夹路径与搜索深度进行遍历及执行处理
     *
     * @author fdipzone
     * @DateTime 2023-08-01 16:14:33
     *
     * @param string $path 要遍历的文件夹路径
     * @param int $max_depth 搜索深度，默认搜索全部
     * @return void
     */
    final public function find(string $path, int $max_depth=0):void
    {
        if(!is_dir($path))
        {
            throw new \Exception(sprintf('path: %s not exists', $path));
        }

        if(!is_numeric($max_depth))
        {
            throw new \Exception('max depth not numeric');
        }

        if($max_depth<0)
        {
            throw new \Exception('max depth must be greater than or equal to 0');
        }

        $this->max_depth = $max_depth;

        // 执行遍历处理
        $this->traversing($path);
    }

    /**
     * 遍历文件夹及子文件夹
     * 使用递归实现，最多遍历到最大搜索深度
     *
     * @author fdipzone
     * @DateTime 2023-08-01 16:31:07
     *
     * @param string $path 要遍历的文件夹路径
     * @param int $depth 当前遍历深度
     * @return void
     */
    private function traversing(string $path, int $depth=1):void
    {
        if($handle = opendir($path))
        {
            while(($file=readdir($handle))!==false)
            {
                if($file!='.' && $file!='..')
                {
                    $cur_file = $path.'/'.$file;

                    // folder
                    if(is_dir($cur_file))
                    {
                        // 不限搜索深度或未到最大搜索深度，继续递归遍历（递归）
                        if($this->max_depth==0 || $depth<$this->max_depth)
                        {
                            $this->traversing($cur_file, $depth+1);
                        }
                    }
                    // file
                    else
                    {
                        // 执行处理
                        $this->process($cur_file);
                    }
                }
            }

            // 关闭
            closedir($handle);
        }
    }
}