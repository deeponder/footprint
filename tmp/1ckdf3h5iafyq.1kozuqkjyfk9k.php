<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>FRIEND CIRCLE</title>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="../app/assets/css/circle/circle.css">
</head>
<body>
<!-- 大图 -->
<div class="jumbotron">
  <h1>Friend Circle</h1>
  <p>Here, we share happiness, share beauty!</p>
</div>
<!-- 导航栏 -->
<nav class="navbar navbar-default">
<div class="container-fluid">
   <div class="collapse navbar-collapse" id="circleNav">
          <ul class="nav navbar-nav">
          	<li class="active" id="home">
                <a class="js-nav js-tooltip js-dynamic-tooltip" data-placement="bottom" href="#" >
                  <span class="glyphicon glyphicon-home"></span>
                  <span class="text">Home</span>
                </a>
            </li>
            <li class="dropdown" id="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            	 <span class="glyphicon glyphicon-user"></span>
            	 <span class="text"> MyCircle </span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="following">FOLLOWING</a></li>
                <li><a href="follower">FOLLOWERS</a></li>
                <li class="divider"></li>
                <li><a href="collection">COLLECTIONS</a></li>
              </ul>
            </li>
          
            
          </ul>
          <form action="search" class="navbar-form navbar-right" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="type name to follow" name="search">
            </div>
            <button type="submit" class="btn btn-default">Search</button>
          </form>
          
        </div>
        </div>
        </nav>
        <hr>
	<div class="col-md-12" id="postnews">
       <form action="savepost" method="POST" role="form" class="form-horizontal" enctype="multipart/form-data">

		<div class="col-md-6 col-md-offset-3">
       	<div class="form-group" >
       		<textarea class="form-control" name="content" rows="3" placeholder="What's happening?"></textarea>
       	</div>
       	</div>
       <div class="col-md-offset-3 col-md-6">
       	<!-- <label for="file" class="col-sm-2">选择文件</label> -->
       	<div class="form-group">
       			<input type="file" name="file">
       	</div>
       
       </div>
        <div class="col-sm-offset-5 col-sm-10">
      		<button type="submit" class="btn btn-default" name="submit">POST</button>
    	</div>
       </form>
       </div>
       <hr>

<!-- news -->
<div class="col-sm-offset-1" id="postcontent">
			<?php foreach (($list?:array()) as $list): ?>
         <?php foreach (($list?:array()) as $list): ?>
         <div id="<?php echo $list['id']; ?>">
		
             <span><?php echo $list['nick_name']; ?></span>&nbsp&nbsp<span><img src="../app/uploads/<?php echo $list['image']; ?>.jpg" height="50" width="50"></span>&nbsp&nbsp<span><?php echo $list['content']; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp<span>published at:<?php echo $list['published_at']; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="admire-cnt">
             <?php if ($list['status']): ?>
				<img class="<?php echo $list['post_id']; ?>" src="../app/assets/images/4.png" alt="">
				<?php else: ?><img class="<?php echo $list['post_id']; ?>" src="../app/assets/images/5.png" alt="">

			<?php endif; ?>
             
             <span><?php echo $list['likes']; ?></span></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="javascript:void(0);" class="collection">
             <?php if ($list['collect']): ?>
             	<span class="<?php echo $list['post_id']; ?>" >collect</span>
             	<?php else: ?><span class="<?php echo $list['post_id']; ?>" >cancel collect</span>
			 <?php endif; ?>
             </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
             <a href="javascript:void(0);" class="comment"><span class="<?php echo $list['post_id']; ?>">comment</span></a>
			
           </div><br><br>
        <?php endforeach; ?>
		 <?php endforeach; ?>			
				  
</div>
        
       <!-- <hr> -->

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
	//改变导航栏样式
	$('#dropdown').click(function(){
		$('#home').removeClass("active");
	});

	$('#home').click(function(){
		$('#home').addClass('active');
	})

	//点赞功能
	  var $image = $('.admire-cnt>img');
    $image.on('click', function(e) {
       var $target = e.target;
       $($target).attr('src', '../app/assets/images/5.png');
       var $text = $($target).siblings('span');
      
       // $($target).unbind('click');
       $post_id = $($target).attr('class');
       // console.log($imgID);
        var url = 'dolike';
        $.getJSON(url,{post_id:$post_id},function(re){
        	// console.log(re);
        	if(!re[0]){
        		alert('亲，您点过赞了哦~~');
        	}else{
        		 var $count = re[1].toString();
       			$text.html($count);
        	}
        });
    });

    //收藏
    $('.collection>span').click(function(e){
    	// alert('ddd');
    	var $target = e.target;
    	$post_id = $($target).attr('class');
    	// $status = $($target).attr('favorite');
    	var url = 'handleCollect';
    	$.post(url,{post_id:$post_id},function(re){
    		// alert(re);
    		if(!re){
    			$($target).html('collect');
    		}else{
    			$($target).html('cancel collect');
    		}

    	},'json');
    });

    //评论
    $('.comment>span').click(function(e){
    	// alert('ddd');
    	var $target = e.target;
    	$post_id = $($target).attr('class');
    	var $collection = $($target).parent('a');
    	var $form = $($target).siblings('form');
    	// $status = $($target).attr('favorite');
    	var url = 'handleComment';
    	$.post(url,{post_id:$post_id},function(re){
    		$form.empty();
    		var str = "<form action='addComment' class='popcomment'><input type='text' name='content' placeholder='say something'/><input type='hidden' name='post_id' value='"+$post_id+"' /><button type='submit' class='btn btn-default'>comment</button></form><br>";
    		str = str+re;
    		$collection.append(str);
    		// console.log(re[0]['nick_name']);
    		// console.log($form);

    	},'json');

    	

    });

    提交评论

    $('.popcomment').submit(function(event)
        {   
        	// alert('hell');
            event.preventDefault();             
            var url = $(this).attr('action');
            var postdata = $(this).serialize();                

            var request = $.post(
                url,
                postdata,
                formpostcompleted,
                "text"            
            );          

            function formpostcompleted(data, status)
            {
            	alert(data);
            }
         }); // end submit function

    

</script>

</body>
</html>