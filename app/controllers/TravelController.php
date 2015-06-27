<?php
class TravelController
{
	function showMap($f3)
	{
		session_start();
        if (! isset($_SESSION['user_id']))
        {
            header("Location:login");
        } else
        {
            $uid = $_SESSION['user_id'];
            $db = $f3->get('DB');
            //$friend = new \DB\SQL\Mapper($db, 'friendship');
            $point = new \DB\SQL\Mapper($db, 'diary');
            $travel = new \DB\SQL\Mapper($db,'travel');
            $points = $point->find(array("user_id=?",$uid));
            $travel_route = $travel->find(array("user_id=?",$uid));
            $f3->set("travels",$travel_route);
            $f3->set("points",$points);

		echo Template::instance()->render("application/travel.html");
	   }
	}


	function addPhoto($f3)// 将添加的照片的位置放入到数据库
	{
        session_start();
        $alng =$f3->get('POST.alng');
        $alat = $f3->get('POST.alat');
        $clng = $f3->get('POST.lng');
        $clat = $f3->get('POST.lat');

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
                    $time =floatval($alng)*1000000+floatval($alat)*1000000;
                    if (move_uploaded_file($tmp_name, $location . $time. '.jpg'))
                    {
        
                       
                        $db = $f3->get('DB');
                        $travel = new \DB\SQL\Mapper($db, 'travel');
                        $travel->user_id = $_SESSION['user_id'];
                        $travel->img = floatval($alng)*1000000+floatval($alat)*1000000;
                        $travel->slng = floatval($clng);
                        $travel->slat = floatval($clat);
                        $travel->elng = floatval($alng);
                        $travel->elat = floatval($alat);
                        $travel->save();


                    }
                } 
            }
        } else
        {
            echo $clat;
            echo "sorry, fail to upload, please try later!";
        }
         echo "Added successfull!";
        echo "<br>";
        echo "<a href='showMap'>back</a>";
	}

	function travel($f3)
	{
		$out=array(1,1,2,3);
		$f3->set("out",$out);
		echo Template::instance()->render("application/photoShow.html");
	}
	function createTravel($f3)
	{
        session_start();
		$lng = $_GET['startlng'];
		$lat = $_GET['startlat'];
		$db = $f3->get('DB');
		$route = new \DB\SQL\Mapper($db,'travel');
		$route->user_id = $_SESSION['user_id'];
		$route->slng = floatval($lng);
		$route->slat = $lat;
        $route->elng = $lng;
        $route->elat = $lat;
		$route->save();
	}
}