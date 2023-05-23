<?php
/**
 * 测试session storage captcha
 *
 * 创建图片
 * demo.php?action=create&storage_type=session
 *
 * 验证
 * demo.php?action=validate&storage_type=session&validate_code=xxx
 *
 *
 * 测试redis storage captcha
 *
 * 创建图片
 * demo.php?action=create&storage_type=redis
 *
 * 验证
 * demo.php?action=validate&storage_type=redis&validate_code=xxx
 */
require 'autoload.php';

/**
 * 测试Captcha生成与验证
 */
class TestCaptcha{

    /**
     * 操作类型
     * create/validate
     *
     * @var string
     */
    private $action;

    /**
     * 使用的存储类型
     * session/redis
     *
     * @var string
     */
    private $storage_type;

    /**
     * 初始化
     *
     * @param string $action 操作类型
     * @param string $storage_type 使用的存储类型
     */
    public function __construct(string $action, string $storage_type){
        if(!in_array($action, ['create', 'validate'])){
            throw new \Exception('action not exists');
        }

        if(!in_array(strtolower($storage_type), [strtolower(\Captcha\Storage\Type::SESSION), strtolower(\Captcha\Storage\Type::REDIS)])){
            throw new \Exception('storage type not exists');
        }

        $this->action = $action;
        $this->storage_type = $storage_type;
    }

    /**
     * 执行测试
     *
     * @param string $key 唯一标识
     * @return void
     */
    public function run(string $key):void{
        // storage
        if(strtolower($this->storage_type)==strtolower(\Captcha\Storage\Type::SESSION)){
            $captcha_storage = $this->createSessionStorage();
        }elseif(strtolower($this->storage_type)==strtolower(\Captcha\Storage\Type::REDIS)){
            $captcha_storage = $this->createRedisStorage();
        }

        // action
        if($this->action=='create'){
            $this->create($key, $captcha_storage);
        }elseif($this->action=='validate'){
            // 获取用户输入的验证码
            $validate_code = isset($_GET['validate_code'])? $_GET['validate_code'] : '';
            $this->validate($key, $validate_code, $captcha_storage);
        }
    }

    /**
     * 创建session存储对象
     *
     * @return \Captcha\Storage\IStorage
     */
    private function createSessionStorage():\Captcha\Storage\IStorage{
        // session storage
        session_start();

        $session_config = array(
            'expire' => 60
        );
        $session_storage_config = new \Captcha\Storage\SessionStorageConfig($session_config);
        $session_storage = \Captcha\Storage\Factory::make(\Captcha\Storage\Type::SESSION, $session_storage_config);
        return $session_storage;
    }

    /**
     * 创建redis存储对象
     *
     * @return \Captcha\Storage\IStorage
     */
    private function createRedisStorage():\Captcha\Storage\IStorage{
        // redis storage
        $redis_config = array(
            'connect_config' => array(
                'host' => 'redis',
                'port' => 6379,
                'index' => 0,
                'auth' => '',
                'timeout' => 1,
                'reserved' => NULL,
                'retry_interval' => 100,
            ),
            'expire' => 60
        );
        $redis_storage_config = new \Captcha\Storage\RedisStorageConfig($redis_config);
        $redis_storage = \Captcha\Storage\Factory::make(\Captcha\Storage\Type::REDIS, $redis_storage_config);
        return $redis_storage;
    }

    /**
     * 创建验证码图片
     *
     * @param string $key 唯一标识
     * @param \Captcha\Storage\IStorage $storage 存储对象
     * @return void
     */
    private function create(string $key, \Captcha\Storage\IStorage $storage):void{
        $captcha_config = new \Captcha\Config($key, $storage);
        $captcha_config->setFontSize(24);
        $captcha_config->setPointNum(150);
        $captcha_config->setLineNum(15);

        // 输出验证码图片
        \Captcha\Captcha::create($key, 6, $captcha_config);
    }

    /**
     * 执行验证
     *
     * @param string $key 唯一标识
     * @param string $validate_code 用户输入的验证码
     * @param \Captcha\Storage\IStorage $storage 存储对象
     * @return void
     */
    private function validate(string $key, string $validate_code, \Captcha\Storage\IStorage $storage):void{
        // 执行验证
        $ret = \Captcha\Captcha::validate($key, $validate_code, $storage);

        var_dump($ret);
    }

}

// 获取操作与使用的存储类型
$action = isset($_GET['action'])? $_GET['action'] : 'create';
$storage_type = isset($_GET['storage_type'])? $_GET['storage_type'] : \Captcha\Storage\Type::SESSION;

$key = 'register';
$captcha_test = new TestCaptcha($action, $storage_type);
$captcha_test->run($key);