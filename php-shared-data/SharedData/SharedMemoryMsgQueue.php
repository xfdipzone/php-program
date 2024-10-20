<?php
namespace SharedData;

/**
 * 基于共享内存实现的消息队列类
 *
 * @author fdipzone
 * @DateTime 2024-10-19 10:51:04
 *
 */
class SharedMemoryMsgQueue implements \SharedData\ISharedMsgQueue
{
    /**
     * 队列名称
     *
     * @var string
     */
    private $queue_name;

    /**
     * 消息最大容量（字节）
     *
     * @var int
     */
    private $max_message_size;

    /**
     * 共享内存 IPC 文件，用于 ftok 方法生成 System V IPC key
     * https://www.php.net/manual/en/function.ftok.php
     *
     * @var string
     */
    private $shm_ipc_file = '';

    /**
     * 初始化
     * 设置队列名称及消息最大容量
     *
     * @author fdipzone
     * @DateTime 2024-10-20 11:49:54
     *
     * @param string $queue_name 队列名称
     * @param int $max_message_size 消息最大容量（字节）
     * @param boolean $init 是否初始化
     */
    public function __construct(string $queue_name, int $max_message_size, bool $init=false)
    {
        if(empty($queue_name))
        {
            throw new \Exception('shared memory msg queue: queue name is empty');
        }

        if($max_message_size<1)
        {
            throw new \Exception('shared memory msg queue: max message size must be greater than 0');
        }

        $this->queue_name = $queue_name;
        $this->max_message_size = $max_message_size;

        // 创建共享内存 IPC 文件
        $this->shm_ipc_file = '/tmp/'.$this->queue_name.'-queue.ipc';

        if($init)
        {
            $created = \SharedData\SharedMemoryUtils::createIpcFile($this->shm_ipc_file);
            if(!$created)
            {
                throw new \Exception('shared memory msg queue: shm ipc file already exists or create fail');
            }
        }
        else
        {
            if(!file_exists($this->shm_ipc_file))
            {
                throw new \Exception('shared memory msg queue: shm ipc file not exists');
            }
        }
    }

    /**
     * 发送消息
     * https://www.php.net/manual/zh/function.msg-send.php
     *
     * @author fdipzone
     * @DateTime 2024-10-20 11:41:32
     *
     * @param string $msg 消息内容
     * @return boolean
     */
    public function send(string $msg):bool
    {
        if(empty($msg))
        {
            throw new \Exception('shared memory msg queue: message is empty');
        }

        if(mb_strlen($msg, 'utf8')>$this->max_message_size)
        {
            throw new \Exception('shared memory msg queue: message length more than max message size');
        }

        try
        {
            $msg_key = \SharedData\SharedMemoryUtils::shmKey($this->shm_ipc_file, 'm');

            if($msg_key==-1)
            {
                throw new \Exception('shared memory msg queue: msg key invalid');
            }

            $msg_queue = msg_get_queue($msg_key, 0666);

            if(!$msg_queue)
            {
                throw new \Exception('shared memory msg queue: msg queue create fail');
            }

            // 发送消息
            return msg_send($msg_queue, 1, $msg, false, false);
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 接收消息
     * https://www.php.net/manual/en/function.msg-receive.php
     *
     * @author fdipzone
     * @DateTime 2024-10-20 11:41:32
     *
     * @return string
     */
    public function receive():string
    {
        try
        {
            $msg_key = \SharedData\SharedMemoryUtils::shmKey($this->shm_ipc_file, 'm');

            if($msg_key==-1)
            {
                throw new \Exception('shared memory msg queue: msg key invalid');
            }

            $msg_queue = msg_get_queue($msg_key, 0666);

            if(!$msg_queue)
            {
                throw new \Exception('shared memory msg queue: get msg queue fail');
            }

            // 接收消息
            $received = msg_receive($msg_queue, 1, $message_type, $this->max_message_size, $message, false, MSG_IPC_NOWAIT, $err);

            if(!$received)
            {
                throw new \Exception(sprintf('shared memory msg queue: receive fail, error code %s', $err));
            }

            return $message;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 关闭消息队列
     * 关闭后将不能执行任何操作，例如发送，接收等
     *
     * @author fdipzone
     * @DateTime 2024-10-20 11:41:32
     *
     * @return boolean
     */
    public function close():bool
    {
        try
        {
            $msg_key = \SharedData\SharedMemoryUtils::shmKey($this->shm_ipc_file, 'm');

            if($msg_key==-1)
            {
                throw new \Exception('shared memory msg queue: msg key invalid');
            }

            $msg_queue = msg_get_queue($msg_key, 0666);

            if(!$msg_queue)
            {
                throw new \Exception('shared memory msg queue: get msg queue fail');
            }

            $removed = msg_remove_queue($msg_queue);

            if($removed)
            {
                // 删除共享内存 IPC 文件
                \SharedData\SharedMemoryUtils::removeIpcFile($this->shm_ipc_file);
            }

            return $removed;
        }
        catch(\Throwable $e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}