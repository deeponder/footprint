<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>Diary</title>
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="../app/assets/css/circle/circle.css">
    </head>
    <body>
        <!-- 大图 -->
        <div class="jumbotron" id="test2">
            <h1>Diary</h1>
            <p>Here, we share happiness, share beauty!</p>
        </div>
       
         <hr>
        <div class="col-md-12" id="postnews">
            <form action="saveDiary" method="POST" role="form" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="3" placeholder="Write something"></textarea>
                    </div>
                </div>
                
                <div class="col-sm-offset-5 col-sm-10">
                    <button type="submit" class="btn btn-default" name="submit" id="postapost">POST</button>
                </div>
            </form>
        </div>
       
        <!-- news -->
        <div class="col-sm-offset-1" id="postcontent">
            <?php foreach (($list?:array()) as $list): ?>
                <span><?php echo $list['content']; ?></span><span class="col-sm-offset-10"><a href="rmDiary?id=<?php echo $list['id']; ?>"><button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button></a></span><br>
            <?php endforeach; ?>
        </div>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>