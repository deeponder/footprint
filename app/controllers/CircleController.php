<?php

/**
 * 朋友圈
 */
class CircleController {

    function home($f3)
    {
        session_start();
        if (! isset($_SESSION['user_id']))
        {
            header("Location:../login");
        } else
        {
            $uid = $_SESSION['user_id'];
            $db = $f3->get('DB');
            $friend = new \DB\SQL\Mapper($db, 'friendship');
            $user = new \DB\SQL\Mapper($db, 'user');
            $post = new \DB\SQL\Mapper($db, 'post');
            $collection = new \DB\SQL\Mapper($db, 'collection');
            $like = new \DB\SQL\Mapper($db, 'likes');
            $friends = $friend->find(array('friend_id=?', $uid));
            $list = array();
            // 精华所在！！循环将post内容赋给list，并判断用户是否点过赞
            $i = 0;
            foreach ($friends as $obj)
            {
                $list[ $i ] = $post->find(array('user_id=?', $obj->user_id),array('order'=>"post_id DESC"));
                foreach ($list[ $i ] as $item)
                {
                    $isLiked = $like->find(array('post_id=? and user_id=?', $item->post_id, $_SESSION['user_id']));
                    $isCollected = $collection->find(array('post_id=? and user_id=?', $item->post_id, $_SESSION['user_id']));
                    if (! $isLiked)
                    {
                        $item->status = 1;
                    }
                    if (! $isCollected)
                    {
                        $item->collect = 1;
                    }
                }
                $i++;
            }
            $f3->set('list', $list);
            echo Template::instance()->render('application/circle/home.html');
        }
    }

    //发布新动态
    function savepost($f3)
    {
 session_start();
        $db = $f3->get('DB');
        $post = new \DB\SQL\Mapper($db, 'post');
        $allId = $post->select('post_id', array(), array('order' => 'post_id DESC'));

        // var_dump($allId);
        if (! $allId)
        {
            $oldId = $newId = 1;
        } else
        {
            $oldId = $allId[0]['post_id'];
            //postId加1作为图片的保存名
            $newId = $oldId + 1;
        }


        //获取nickname，这里post_id == user_id
        $user = new \DB\SQL\Mapper($db, 'user');
        $users = $user->select('nick_name', array('user_id=?', $_SESSION['user_id']));
        $nickname = $users[0]['nick_name'];


//图片上传处理
        $img = isset($_POST['img'])? $_POST['img'] : '';
    $x = $_POST['x'];
    $y = $_POST['y'];
    $w = $_POST['w'];
    $h = $_POST['h'];
  
    // 获取图片  
    list($type, $data) = explode(',', $img);  
    // 判断类型  
    if(strstr($type,'image/jpeg')!==''){  
        $ext = '.jpg';  
    }
// 生成的文件名  
    $photo = 'app/uploads/'.$newId.$ext;
    // 生成文件  
    file_put_contents($photo, base64_decode($data), true); 
    if($x != 0 && $y != 0 && $w != 0 && $h != 0)
    {
        $image = imagecreatefromjpeg($photo);
        $to_crop_array = array("x"=>$x,"y"=>$y,"width"=>$w,"height"=>$h);
        $new_im = imagecrop($image,$to_crop_array);
        imagejpeg($new_im,$photo);
    } 
    
     //存库
    $post->post_id = $newId;
    $post->user_id = $_SESSION['user_id'];
    $post->content = $_POST['content'];
    $post->image = $newId;
    $post->published_at = date("Y-m-d H:i", time());
    $post->nick_name = $nickname;
    $post->save();

   
    //返回  
    header('content-type:application/json;charset=utf-8');  
    $ret = array("ok");  
    echo json_encode($ret);  
       

        // //文件上传
        // if (isset($_POST['submit']))
        // {
        //     $name = $_FILES["file"]["name"];

        //     //$size = $_FILES['file']['size']
        //     //$type = $_FILES['file']['type']

        //     $tmp_name = $_FILES['file']['tmp_name'];
        //     $error = $_FILES['file']['error'];

        //     if (isset($name))
        //     {
        //         if (! empty($name))
        //         {

        //             $location = 'app/uploads/';

        //             if (move_uploaded_file($tmp_name, $location . $newId . '.jpg'))
        //             {

        //                 //存库
        //                 $post->post_id = $newId;
        //                 $post->user_id = $_SESSION['user_id'];
        //                 $post->content = $_POST['content'];
        //                 $post->image = $newId;
        //                 $post->published_at = date("Y-m-d H:i", time());
        //                 $post->nick_name = $nickname;
        //                 $post->save();
        //                 header("Location:home");
        //             }
        //         } else
        //         {
        //             echo 'please choose a file' . '<br>';
        //             echo "<a href='home'>back</a>";

        //             // header("Location:home");

        //         }
        //     }
        // } else
        // {
        //     echo "sorry, fail to upload, please try later!";
        // }
    }

    //查找好友
    function search($f3)
    {
        session_start();
        $key = $_GET['search'];
        $db = $f3->get('DB');
        $user = new \DB\SQL\Mapper($db, 'user');
        $friend = new \DB\SQL\Mapper($db, 'friendship');
        $result = $user->find(array('nick_name=?', $key));
        if (! $result)
        {
            echo "sorry, we can't find the person";
            echo "<br>";
            echo "<a href='home'>back</a>";
        } else
        {

            $isFriend = $friend->find(array('user_id=? AND friend_id=?', $result[0]['user_id'], $_SESSION['user_id']));
            if ($isFriend)
            {
                echo "you are following him/her";
                echo "<br>";
                echo "<a href='home'>back</a>";
            } else
            {

                $f3->set('nick_name', $result[0]['nick_name']);
                $f3->set('fid', $result[0]['user_id']);
                echo Template::instance()->render('application/circle/findFriend.html');
            }
        }
    }

    //添加好友
    function addFriend($f3)
    {
        session_start();
        $fid = $_GET['fid'];
        $db = $f3->get('DB');
        $friend = new \DB\SQL\Mapper($db, 'friendship');
        $friend->user_id = $fid;
        $friend->friend_id = $_SESSION['user_id'];
        $result = $friend->save();
        if (! $result)
        {
            echo "sorry, fail to add, try later please!";
            echo "<br>";
            echo "<a href='home'>back</a>";
        } else
        {
            echo "Congradulations! you have followed him/her";
            echo "<br>";
            echo "<a href='home'>back</a>";
        }
    }

    //显示关注人列表
    function following($f3)
    {
        session_start();
        $db = $f3->get('DB');
        $friend = new \DB\SQL\Mapper($db, 'friendship');
        $user = new \DB\SQL\Mapper($db, 'user');
        $foll = $friend->select('user_id', array('friend_id=?', $_SESSION['user_id']));
        $totalfoll = count($foll);
        $following = array();
        for ($i = 0; $i < $totalfoll; $i++)
        {
            $following[ $i ] = $user->find(array('user_id=?', $foll[ $i ]['user_id']));
        }
        $f3->set('following', $following);

        // var_dump($totalfoll);
        echo Template::instance()->render('application/circle/following.html');
    }

    //显示粉丝列表
    function follower($f3)
    {
        session_start();
        $db = $f3->get('DB');
        $friend = new \DB\SQL\Mapper($db, 'friendship');
        $user = new \DB\SQL\Mapper($db, 'user');
        $foller = $friend->select('friend_id', array('user_id=?', $_SESSION['user_id']));
        $totalfoll = count($foller);
        $follower = array();
        for ($i = 0; $i < $totalfoll; $i++)
        {
            $follower[ $i ] = $user->find(array('user_id=?', $foller[ $i ]['friend_id']));
        }
        $f3->set('follower', $follower);
        echo Template::instance()->render('application/circle/follower.html');
    }

    //取关和移出粉丝
    function handleFoll($f3)
    {
        session_start();
        $db = $f3->get('DB');
        $friend = new \DB\SQL\Mapper($db, 'friendship');
        $tag = $_GET['tag'];
        $id = $_GET['id'];
        if (! $tag)
        {
            $friend->load(array('friend_id=? AND user_id=?', $id, $_SESSION['user_id']));
            $friend->erase();
            echo "Rmove Your follower sussessfully!";
            echo "<br>";
            echo "<a href='follower'>back</a>";
        } else
        {
            $friend->load(array('user_id=? AND friend_id=?', $id, $_SESSION['user_id']));
            $friend->erase();
            echo "Stop following sussessfully!";
            echo "<br>";
            echo "<a href='following'>back</a>";
        }
    }

    //点赞处理函数
    function dolike($f3)
    {
        session_start();
        $post_id = $_GET['post_id'];
        $db = $f3->get('DB');
        $post = new \DB\SQL\Mapper($db, 'post');
        $like = new \DB\SQL\Mapper($db, 'likes');
        $posts = $post->find(array('post_id=?', $post_id));
        $likes = $posts[0]['likes'] + 1;
        $re = $like->find(array('post_id=? and user_id=?', $post_id, $_SESSION['user_id']));
        $result = array();
        $result[0] = 1;
        if (! $re)
        {
            $like->user_id = $_SESSION['user_id'];
            $like->post_id = $post_id;
            $like->save();

            $post->load(array('post_id=?', $post_id));
            $post->likes = $likes;
            $post->update();
        } else
        {
            $result[0] = 0;
        }
        $result[1] = $likes;

        echo json_encode($result);
    }

    //收藏处理
    function handleCollect($f3)
    {
        session_start();
        $post_id = $f3->get('POST.post_id');
        // $status = $f3->get('POST.status');
        // echo $status;
        $uid = $_SESSION['user_id'];
        $db = $f3->get('DB');
        $collect = new \DB\SQL\Mapper($db, 'collection');
        $re = $collect->find(array('post_id=? and user_id=?', $post_id, $uid));
        $flag = 1;
        if ($re)
        {
            $collect->load(array('post_id=? and user_id=?', $post_id, $uid));
            $collect->erase();
            $flag = 0;
        } else
        {
            $collect->user_id = $uid;
            $collect->post_id = $post_id;
            $collect->collected_at = date("Y-m-d H:i", time());
            $collect->save();
        }
        echo $flag;
    }

    //显示收藏
    function collection($f3)
    {
        session_start();
        $db = $f3->get('DB');
        $collect = new \DB\SQL\Mapper($db, 'collection');
        $post = new \DB\SQL\Mapper($db, 'post');
        $collections = $collect->find(array('user_id=?', $_SESSION['user_id']));
        $i = 0;
        $list = array();
        foreach ($collections as $obj)
        {
            $list[ $i ] = $post->find(array('post_id=?', $obj->post_id));
            $i++;
        }
        $f3->set('list', $list);
        echo Template::instance()->render('application/circle/collection.html');

    }

    //取消收藏
    function delCol($f3)
    {
        session_start();
        $post_id = $f3->get('GET.post_id');
        $db = $f3->get('DB');
        $collect = new \DB\SQL\Mapper($db, 'collection');
        $collect->load(array('post_id=? and user_id=?', $post_id, $_SESSION['user_id']));
        $collect->erase();
        echo "Cancel collection sussessfully!";
        echo "<br>";
        echo "<a href='collection'>back</a>";

    }

    //评论处理函数
    function handleComment($f3)
    {
        session_start();
        $post_id = $f3->get('POST.post_id');
        $db = $f3->get('DB');
        $comment = new \DB\SQL\Mapper($db, 'comment');
        $comments = $comment->find(array('post_id=?', $post_id));
        $list = "";
        foreach ($comments as $obj)
        {
            $str = "<span>" . $obj->nick_name . "</span>&nbsp&nbsp<span>:" . $obj->content . "</span><br>";
            $list = $list . $str;
        }
        echo json_encode($list);

    }

    //发表评论
    function addComment($f3)
    {
        session_start();
        $post_id = $f3->get('POST.post_id');
        $content = $f3->get('POST.content');
        $db = $f3->get('DB');
        $comment = new \DB\SQL\Mapper($db, 'comment');
        $user = new \DB\SQL\Mapper($db, 'user');
        $user->load(array('user_id=?', $_SESSION['user_id']));
        $comment->post_id = $post_id;
        $comment->content = $content;
        $comment->user_id = $_SESSION['user_id'];
        $comment->nick_name = $user->nick_name;
        $comment->save();
        echo "comment success! click comment link to see your comments!";
        // echo $post_id;
        //        echo "<a href='home'>back</a>";
    }

}

?>