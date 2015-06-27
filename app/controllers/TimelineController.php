<?php

class TimelineController{
    public function Timeline($f3){
		 $db       = $f3->get('DB');
        $mysql    = new \DB\SQL\Mapper($db, 'diary');
$f3->set('records',$db->exec('SELECT * FROM diary'));
$f3->set('months',$db->exec('SELECT distinct month,year FROM diary'));
	 
     echo Template::instance()->render('application/timeline.html');
	}
	  
}
?>