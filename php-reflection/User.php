<?php
/**
 * 用户接口
 *
 * @author fdipzone
 * @DateTime 2023-03-30 17:01:31
 *
 */
interface IUser{

    /**
     * 新增用户
     *
     * @author fdipzone
     * @DateTime 2023-03-30 17:01:51
     *
     * @param array $data 用户数据
     * @return int
     */
    public function add(array $data):int;

    /**
     * 读取用户数据
     *
     * @author fdipzone
     * @DateTime 2023-03-30 17:01:55
     *
     * @param int $id 用户id
     * @return array
     */
    public function get(int $id):array;

}

/**
 * 用户类
 *
 * @author fdipzone
 * @DateTime 2023-03-30 17:03:26
 *
 */
class User implements IUser{

    /**
     * 用户数据
     *
     * @var array
     */
    protected $user = array();

    /**
     * 新增用户
     *
     * @author fdipzone
     * @DateTime 2023-03-30 17:01:51
     *
     * @param array $data 用户数据
     * @return int
     */
    public function add(array $data):int{
        $this->user[] = $data;
        $keys = array_keys($this->user);
        return end($keys);
    }

    /**
     * 读取用户数据
     *
     * @author fdipzone
     * @DateTime 2023-03-30 17:01:55
     *
     * @param int $id 用户id
     * @return array
     */
    public function get(int $id):array{
        if(isset($this->user[$id])){
            return $this->user[$id];
        }else{
            return array();
        }
    }

}

/**
 * VIP用户类
 *
 * @author fdipzone
 * @DateTime 2023-03-30 17:28:13
 *
 */
class Vip extends User{

    /**
     * 读取vip用户数据
     *
     * @author fdipzone
     * @DateTime 2023-03-30 17:04:22
     *
     * @param int $id 用户id
     * @return array
     */
    public function getVip(int $id):array{
        $data = $this->get($id);
        if($data){
            return $this->format($data);
        }
        return $data;
    }

    /**
     * 修饰数据
     *
     * @author fdipzone
     * @DateTime 2023-03-30 17:04:41
     *
     * @param array $data 用户数据
     * @return array
     */
    private function format(array $data):array{
        $data['is_vip'] = 1;
        return $data;
    }

}
?>