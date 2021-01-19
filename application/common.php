<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function encrypt($str, $self = '')
{
    return sha1(md5($str . md5('S()#$?%K') . $self) . '%w35lks04knl%');
}

if (!function_exists('msg')) {
    function msg($msg = '', $code = 300, $data = [])
    {
        if (empty($msg)) {
            return false;
        }
        if (is_numeric($msg)) {
            if ($msg == 200) {
                $arr = ['code' => $msg, 'msg' => 'success', 'data' => $code];
            } else {
                $arr = ['code' => $msg];
            }
        } else if (is_array($msg)) {
            $arr = $msg;
        } else {
            $arr = ['code' => $code, 'msg' => $msg, 'data' => $data];
        }
        return json($arr);
    }
}

//AJAX Result成功
if (!function_exists('success')) {
    function success($msg = 'success', $data = [])
    {
        if (is_array($msg)) {
            return msg('success', 200, $msg);
        } else {
            return msg($msg, 200, $data);
        }
    }
}

//AJAX Result失败
if (!function_exists('fail')) {
    function fail($msg = 'fail', $data = [])
    {
        if (is_array($msg)) {
            return msg('fail', 300, $msg);
        } else {
            return msg($msg, 300, $data);
        }
    }
}