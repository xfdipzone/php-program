<?php
namespace FileContentOrganization;

/**
 * php 文件内容整理类入口
 * 文件内容去重，排序（升序，降序）
 * 针对每行内容为一个整体的处理
 *
 * @author fdipzone
 * @DateTime 2023-03-23 22:13:08
 *
 */
class Organizer{

    /**
     * 源文件
     *
     * @var string
     */
    private $source;

    /**
     * 整理后的文件
     *
     * @var string
     */
    private $dest;

    /**
     * 处理器类对象集合
     *
     * @var array [] \IHandler
     */
    private $handlers = [];

    /**
     * 初始化
     *
     * @author fdipzone
     * @DateTime 2023-03-23 22:26:22
     *
     * @param string $source 源文件
     * @param string $dest   整理后的文件
     */
    public function __construct(string $source, string $dest){

        if($source==''){
            throw new \Exception('source not set');
        }

        if($dest==''){
            throw new \Exception('dest not set');
        }

        if(!file_exists($source)){
            throw new \Exception('source not exists');
        }

        $this->source = $source;
        $this->dest = $dest;

    }

    /**
     * 设置需要使用的处理器
     *
     * @author fdipzone
     * @DateTime 2023-03-23 22:32:42
     *
     * @param IHandler $handler 处理器类对象
     * @return void
     */
    public function addHandler(IHandler $handler):void{
        $this->handlers[] = $handler;
    }

    /**
     * 执行处理
     *
     * @author fdipzone
     * @DateTime 2023-03-23 22:54:54
     *
     * @return boolean
     */
    public function handle():bool{

        try{
            // 读取源文件内容
            $data = file_get_contents($this->source);

            // 调用多个处理器进行处理
            if($this->handlers){
                foreach($this->handlers as $handler){
                    $data = $handler->handle($data);
                }
            }

            // 输出内容到目标文件
            return file_put_contents($this->dest, $data, true)? true : false;

        }catch(\Throwable $e){
            throw new \Exception($e->getMessage());
        }

    }

}