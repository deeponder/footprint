<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>FOLLOWING</title>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
	  <?php foreach (($following?:array()) as $following): ?>
        	<?php foreach (($following?:array()) as $following): ?>
        	<div class="row">
			  <div class="col-md-3 col-md-offset-1"><?php echo $following['nick_name']; ?></div>
			  <div class="col-md-4 col-md-offset-4"><a class="btn btn-default" href="handleFoll?id=<?php echo $following['user_id']; ?>&tag=1" role="button">STOP FOLLOWING</a></div>
			</div><br>
        <?php endforeach; ?>
        <?php endforeach; ?>
        <br>
        <a href="home"><span class="glyphicon glyphicon-menu-left col-md-offset-1"></span>BACK</a>
</body>
</html>