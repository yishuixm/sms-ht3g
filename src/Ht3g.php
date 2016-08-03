<?php


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/30
 * Time: 13:20
 */

namespace yishuixm\sms;

class Ht3g
{
    private $server_url = 'http://sms.ht3g.com/sms.aspx';
    //企业ID
    private $userid;
    //用户帐号，由系统管理员
    private $account;
    //用户账号对应的密码
    private $password;

    // 调试
    private $debug = false;
    private $debug_info;

    /**
     * 构造函数
     * @param $userid 企业ID
     * @param $account 用户帐号
     * @param $password 用户账号对应的密码
     */
    public function __construct($userid,$account,$password,$debug=false)
    {
        $this->userid = $userid;
        $this->account = $account;
        $this->password = $password;
        $this->debug = $debug;
    }

    /**
     * 得到DEBUG信息
     * @return mixed
     */
    public function getDebug(){
        return $this->debug_info;
    }

    /**
     * 发送短信
     * @param $mobile
     * @param $content
     * @param string $sendTime
     * @return mixed|string
     */
    public function sendTo($mobile, $content, $sendTime=''){
        $data = http_build_query([
            'userid'        => $this->userid,
            'account'       => $this->account,
            'password'      => $this->password,
            'mobile'        => $mobile,
            'content'       => mb_convert_encoding($content, 'utf-8', 'auto'),
            'action'        => 'send',
            'sendTime'      => $sendTime,
            'extno'         => ''
        ]);

        if($this->debug){
            $this->debug_info['data'] = $data;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, "somorn.com's CURL Example beta V1.0");
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }
}