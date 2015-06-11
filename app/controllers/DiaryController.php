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
		$db = $f3->get('DB');
        $diary = new \DB\SQL\Mapper($db, 'diary');
        $diary->user_id = $_SESSION['user_id'];
        $diary->content = $content;
        $diary->save();
        echo "Post successfull!";
        echo "<br>";
        echo "<a href='diary'>back</a>";
	}

}

 ?>