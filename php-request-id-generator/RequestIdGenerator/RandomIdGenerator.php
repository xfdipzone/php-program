<?php
namespace RequestIdGenerator;

/**
 * 随机 ID 生成器
 *
 * @author fdipzone
 * @DateTime 2026-04-27 12:45:24
 *
 */
class RandomIdGenerator implements \RequestIdGenerator\IRequestIdGenerator
{
    /**
     * 生成唯一请求 ID
     *
     * @author fdipzone
     * @DateTime 2026-04-27 12:45:45
     *
     * @return string
     */
    public function generate():string
    {
        // 使用session_create_id()方法创建前缀
        $prefix = session_create_id(date('YmdHis'));

        // 使用 uniqid() 方法创建唯一id，并将字母转为大写
        $request_id = strtoupper(md5(uniqid($prefix, true)));

        // 格式化请求id
        return self::formatResponse($request_id);
    }

    /**
     * 格式化请求 ID 输出
     *
     * @author fdipzone
     * @DateTime 2026-04-27 13:10:56
     *
     * @param string $request_id 请求 ID
     * @param string $format 格式（将 request_id 字符串拆分为多段字符串）
     * @return string
     */
    private function formatResponse(string $request_id, string $format='8,4,4,4,12'):string
    {
        $tmp = array();
        $offset = 0;

        $cut = explode(',', $format);

        // 根据设定格式化
        if($cut)
        {
            foreach($cut as $v)
            {
                $cut_str = substr($request_id, $offset, $v);

                if(strlen($cut_str)>0)
                {
                    $tmp[] = $cut_str;
                }

                $offset += $v;
            }
        }

        // 加入剩余部分
        if($offset<strlen($request_id))
        {
            $tmp[] = substr($request_id, $offset);
        }

        return implode('-', $tmp);
    }
}