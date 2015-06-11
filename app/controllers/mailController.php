<?php

class mailController{
	//处理验证邮件
	function reg($f3){
		$db       = $f3->get('DB');
        $user    = new \DB\SQL\Mapper($db, 'user');
        $user_id = base64_decode($_GET['uid']);
        $time = strtotime(time());
        $create_time = strtotime($user->create_time);
        $user->load(array('user_id=?',$user_id));
        if (($time-$create_time)>7200)
        	echo "the url is not available!!";
        else
        {
        $user->status = 1;
        $user->update();
      	header('Location:login');
      }

	}

	//新密码更新
	function handleResetpw($f3){
		$db      = $f3->get('DB');
        $user    = new \DB\SQL\Mapper($db, 'user');

        $newpw = $_GET['newpw'];
        $user_id = $_GET['uid'];
        $user->load(array('user_id=?',$user_id));
        $user->password = $newpw;
        $user->update();
        echo "您的密码已重置";
	}

	//重置密码
	function renewpw($f3){
        // $user_id = $_GET['uid'];
        // $f3->set('uid',$user_id);
        $username = base64_decode($_GET['uid']);
        $password = $_GET['p'];
        $db      = $f3->get('DB');
        $f3->set("uid",$username);
        $user    = new \DB\SQL\Mapper($db, 'user');
        $res = $user->count(array("nick_name=?and password=?",$username,$password));
        $f3->set("username",$username);
        if($res==0)
        {
            echo "it's a wrong url!";
        }
        else
        echo Template::instance()->render('application/repassword.html');
	}

    function resetpw($f3)
    {
        $pass = $_GET['pw'];
        $username=$_GET['username'];
         $db      = $f3->get('DB');
        $user    = new \DB\SQL\Mapper($db, 'user');
        $user->load(array("nick_name=?",$username));
        $user->password=md5($pass);
        $user->update();
        $f3->clear("username");
        header("Location:login");
    }

	//验证指定用户
	function verify($f3){
		$db       = $f3->get('DB');
        $user    = new \DB\SQL\Mapper($db, 'user');
        $username = $_GET['username'];
        $res = $user->find(array('nick_name=?',$username));
        $email = $res[0]['email'];
        $user_id = $res[0]['user_id'];
        // $password = $res[0]['password'];
        $url = 'http://footprint.deeponder.com/reg?uid='.base64_encode($user_id).'&p='.base64_encode($username);
        $message = "<h1>click the url followed or copy it in the browser</h1></br><h1>it is available </h1><a href=".$url.">".$url."</a>";
        $subject = "注册验证";
        $this->sendmail($email,$message,$subject);
        $mailInfo = explode("@", $email);
        $f3->set("mailSuf",$mailInfo[1]);
        echo Template::instance()->render('application/verifying.html');
	}

	//忘记密码
	function forgetpw($f3){
		$db       = $f3->get('DB');
        $user    = new \DB\SQL\Mapper($db, 'user');
        $res = $user->find(array('nick_name=?','peng'));
        $email = $res[0]['email'];
        $user_id = $res[0]['user_id'];
        $password = $res[0]['password'];
        $url = 'http://footprint.deeponder.com/resetpw?uid='.$user_id.'&password='.$password;
        $message = "<a href=".$url.">点我重置密码</a>";
        $subject = "重置密码";
        $this->sendmail($email,$message,$subject);
	}

	//发送邮件给指定邮箱
	function sendmail($email,$message,$subject){
		$smtp = new SMTP ( 'smtp.qq.com', '465', 'ssl', 'footprint@deeponder.com', '197808hkhl');
		$smtp->set('From','"FootPrint" <footprint@deeponder.com>');
		$smtp->set('Subject',$subject);
		$smtp->set('To','<'.$email.'>');
		$smtp->set('content-type','text/html');
		$smtp->send($message);
		
	}
    function forgetpass($f3)
    {
        echo Template::instance()->render('application/forgetpw.html');
    }
   
   
    function sendUrl($f3)
    {
        $mail = $_GET['mail'];
        $db       = $f3->get('DB');
        $user    = new \DB\SQL\Mapper($db, 'user');
        $res = $user->find(array('email=?',$mail));
        if($res==Null)
            echo 0;
        else
        {
            $username=$res[0]->nick_name;
            $password=$res[0]->password;
            $url = 'http://footprint.deeponder.com/renewpw?uid='.base64_encode($username).'&p='.$password;
            $message="<h1>your username is ".$username."</h1><br><h1>click the url to renew your password:<a href=".$url.">click to reset your password</a></h1>";
            $subject="reset your password";
            $this->sendmail($mail,$message,$subject);
        }
    }
    function verifying($f3)
    {
        echo Template::instance()->render('application/verifying.html');
    }
}