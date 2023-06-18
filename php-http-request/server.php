<?php
// 获取http请求方式
$request_method = requestMethod();

if(empty($request_method))
{
    echo 'request method not supported';
}

switch($request_method)
{
    case 'get':
        echo handleGet();
        break;
    case 'post':
        echo handlePost();
        break;
    case 'multipart':
        echo handleMultiPart();
        break;
}

/**
 * 通过$_SERVER获取http请求方式
 *
 * @author fdipzone
 * @DateTime 2023-06-17 16:33:08
 *
 * @return string
 */
function requestMethod():string
{
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='GET')
    {
        return 'get';
    }
    elseif(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE']=='application/x-www-form-urlencoded')
        {
            return 'post';
        }
        elseif(isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'],'multipart/form-data')!==false)
        {
            return 'multipart';
        }
    }

    return '';
}

/**
 * 处理GET方式请求
 *
 * @author fdipzone
 * @DateTime 2023-06-17 16:41:40
 *
 * @return string
 */
function handleGet():string
{
    $ret = array(
        'name' => $_GET['name'],
        'profession' => $_GET['profession'],
    );
    return json_encode($ret, JSON_UNESCAPED_UNICODE);
}

/**
 * 处理POST方式请求
 *
 * @author fdipzone
 * @DateTime 2023-06-17 16:42:08
 *
 * @return string
 */
function handlePost():string
{
    // 生成图片
    $photo = dirname(__FILE__).'/pic/post_photo_'.date('YmdHis').'.jpg';
    file_put_contents($photo, $_POST['photo'], true);

    $ret = array(
        'name' => $_POST['name'],
        'profession' => $_POST['profession'],
        'photo' => $photo
    );
    return json_encode($ret, JSON_UNESCAPED_UNICODE);
}

/**
 * 处理二进制方式请求
 *
 * @author fdipzone
 * @DateTime 2023-06-17 16:42:32
 *
 * @return string
 */
function handleMultiPart():string
{
    // 生成图片
    $photo = dirname(__FILE__).'/pic/multipart_photo_'.date('YmdHis').'.jpg';
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo);

    $ret = array(
        'name' => $_POST['name'],
        'profession' => $_POST['profession'],
        'photo' => $photo
    );
    return json_encode($ret, JSON_UNESCAPED_UNICODE);
}