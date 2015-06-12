<?php
class LoginController
{
    function login($f3) {                           //显示登陆界面
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo Template::instance()->render('application/login.html');
        }else{
             header("Location:home");
        }
    }
    
    function check($f3) {  
        session_start();                         //检测登陆是否成功
        $username = $_GET['id'];
        $password = $_GET['password'];
        $db       = $f3->get('DB');
        $mysql    = new \DB\SQL\Mapper($db, 'user');
        $user      = $mysql->find(array('nick_name=? and password=?', $username, md5($password)));
        if ($user != Null) {
            if($user[0]->status==1)
            {
            echo 1;
            $user_id = $user[0]->user_id;
            $_SESSION['user_id'] = $user_id;
        }
        else
        {
        $time = strtotime(time());
        $create_time = strtotime($user[0]->create_time);
        if (($time-$create_time)<7200)
        {
            echo 2;
        }
        else echo 3;
        }
        } 
        else echo 0;
    }
    
    function register($f3) {                        //显示登陆界面
        echo Template::instance()->render('application/register.html');
    }


    function registerintoTable($f3) {               //将注册信息加入到数据表

        $db               = $f3->get('DB');
        $mysql            = new \DB\SQL\Mapper($db, 'user');
        $username         = $_GET['username'];
        $password         = $_GET['password'];
        
        //$repeatpassword = $_GET['repassword'];
        $mail             = $_GET['mail'];
        $num              = $mysql->count(array('nick_name=?', $username));
         $numEmail              = $mysql->count(array('email=?', $mail));
        if ($num != 0) echo 0;
        else if($numEmail!=0)echo 2;
        else{
            header("Location:login");
         
            $mysql->nick_name = $username;
            $mysql->password  = md5($password);
            $mysql->email      = $mail;
            $mysql->save();
            // header("Location:login");
        } 
    }
    function checkUse($f3) {                        //检测用户名是否被注册过
        $db       = $f3->get('DB');
        $mysql    = new \DB\SQL\Mapper($db, 'user');
        $username = $_GET['username'];
        $user     = $mysql->find(array('nick_name=?', $username));
        if($user==Null)
            echo 1;
        else
        {
            $time = strtotime(time());
            $create_time = strtotime($user[0]->create_time);
            if($time-$create_time>7200)
                echo 1;
            else
                echo 0;
        }
    }

    function checkMailUse($f3)                      //检测邮箱是否被注册过
    {
        $db       = $f3->get('DB');
        $mysql    = new \DB\SQL\Mapper($db, 'user');
        $mail = $_GET['mail'];
        $num      = $mysql->count(array('email=?', $mail));
        if ($num == 0) echo 1;
        else echo 0;
    }
    
    function logout($f3) {                          //登出
        session_start();
        unset($_SESSION['user_id']);
        header("Location:login");
    }



    function home($f3)                              //首页
        {
            session_start();
            if(!isset($_SESSION['user_id']))
            {
                header("Location:login");
            }
            else
            {

            $f3->set('uid',$_SESSION['user_id']);
            echo Template::instance()->render('application/home.html');
            }
        }

    // function test($f3)
    // {
    //     echo "hell";
    //      $db       = $f3->get('DB');
    //     $user    = new \DB\SQL\Mapper($db, 'user');
    //     $res = $user->find(array('nick_name=?','peng'));
    //     echo $res[0]['email'];
    // }
}
