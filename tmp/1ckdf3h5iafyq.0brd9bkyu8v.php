<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find A Friend~</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
<div class="row">
    <div class="col-md-3 col-md-offset-1"><?php echo $nick_name; ?></div>
    <div class="col-md-4 col-md-offset-4"><a class="btn btn-default" href="addFriend?fid=<?php echo $fid; ?>"
                                             role="button">FOLLOW</a></div>
</div>
</body>
</html>