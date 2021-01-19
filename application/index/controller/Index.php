<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\facade\Session;
use think\facade\Cache;

class Index extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function login()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['username'] = trim($post['username']);
            $post['password'] = trim($post['password']);
            $res = Db::name('admin')->where(['username' => $post['username']])->find();
            if (empty($res)) {
                return json(['code' => 300, 'msg' => '账户不存在']);
            } else if ($res['password'] != encrypt($post['password'])) {
                return json(['code' => 300, 'msg' => '账户密码不正确']);
            } else if ($res['state'] == 1) {
                return json(['code' => 300, 'msg' => '您的账号已冻结！']);
            }
            //删除密码
            unset($res['password']);

            $token = md5($post['username'] . microtime() . $post['password'] . '#$@%!*');

            Cache::set('uToken_' . $res['id'], $token, 3600);

            //设置缓存
            Session::set('admin', $res);

            $data = [
                'user'  => $res,
                'token' => $token
            ];
            return json(['code' => 200, 'msg' => '登陆成功', 'data' => $data]);
        } else {
            die(print_r('aaaaa'));
        }
    }
}
