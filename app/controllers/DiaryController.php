<?php 
	/**
	* 日记
	*/
	class DiaryController 
	{
		function index($f3){
			session_start();
			 if (! isset($_SESSION['user_id']))
        {
            header("Location:../login");
        } else{
			 $db = $f3->get('DB');
            $diary = new \DB\SQL\Mapper($db, 'diary');
            $list = $diary->find(array('user_id=?',$_SESSION['user_id']));
            $f3->set('list',$list);
            echo Template::instance()->render('application/diary.html');
		}

	}

	function rmDiary($f3){
		session_start();
		$id = $f3->get('GET.id');
		$db = $f3->get('DB');
        $diary = new \DB\SQL\Mapper($db, 'diary');
        $diary->load(array('id=?',$id));
        $diary->erase();
        echo "Delete successfull!";
        echo "<br>";
        echo "<a href='diary'>back</a>";
	}


	function saveDiary($f3){
		session_start();
		$content = $f3->get('POST.content');
		$title = $f3->get('POST.title');
        $lng = $f3->get('POST.lng');
        $lat = $f3->get('POST.lat');
		 //文件上传
        if (isset($_POST['submit']))
        {
            $name = $_FILES["file"]["name"];
        
            //$size = $_FILES['file']['size']
            //$type = $_FILES['file']['type']
        
            $tmp_name = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];
        
            if (isset($name))
            {
                if (! empty($name))
                {
        
                    $location = 'app/uploads/';
        			$time = floatval($lng)*1000000+floatval($lat)*1000000;
                    if (move_uploaded_file($tmp_name, $location . $time. '.jpg'))
                    {
        
                       
						$db = $f3->get('DB');
				        $diary = new \DB\SQL\Mapper($db, 'diary');
				        $diary->user_id = $_SESSION['user_id'];
				        $diary->content = $content;
				        $diary->image = $time;
				        $diary->title = $title;
				        $diary->day = date('d');
				        $diary->month = date('n');
				        $diary->year = date('Y');
                        $diary->lng = floatval($lng);
                        $diary->lat = floatval($lat);
				        $diary->save();


                    }
                } else
                {
                    echo 'please choose a file' . '<br>';
                    echo "<a href='home'>back</a>";
        
                    // header("Location:home");
        
                }
            }
        } else
        {
            echo "sorry, fail to upload, please try later!";
        }
        
     
        echo "Post successfull!";
        echo "<br>";
        echo "<a href='diary'>back</a>";
	}

}

 ?>