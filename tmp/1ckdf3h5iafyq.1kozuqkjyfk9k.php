<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>FRIEND CIRCLE</title>
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="../app/assets/css/circle/circle.css">
        <link rel="stylesheet" href="../app/assets/css/jquery.Jcrop.css" type="text/css" />
    </head>
    <body>
        <!-- 大图 -->
        <div class="jumbotron" id="test2">
            <h1>Friend Circle</h1>
            <p>Here, we share happiness, share beauty!</p>
        </div>
        <!-- 导航栏 -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="circleNav">
                    <ul class="nav navbar-nav">
                        <li class="" id="home">
                            <a class="js-nav js-tooltip js-dynamic-tooltip" data-placement="bottom" href="../home">
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
         
                <div class="col-md-6 col-md-offset-3">
                    
                        <textarea class="form-control" id="postcontent" name="content" rows="3" placeholder="What's happening?"></textarea>
                   
                </div>
                <div class="col-md-offset-3 col-md-6">
                    <!-- <label for="file" class="col-sm-2">选择文件</label> -->
                 <button type="button" class="btn btn-default btn-sm" data-toggle="modal" id="addPhoto">
      Add Photo && Post
    </button>
    
                </div>
                
    
        </div>
        <hr>
        <!-- news -->
        <div class="col-sm-offset-1" id="postcontent">
            <?php foreach (($list?:array()) as $list): ?>
            <?php foreach (($list?:array()) as $list): ?>
            <div id="<?php echo $list['id']; ?>">
                <span><?php echo $list['nick_name']; ?></span>&nbsp&nbsp<span>  <a href="#" class="pop"><img
                src="../app/uploads/<?php echo $list['image']; ?>.jpg" id="imageresource" height="50" width="50"> </a></span>&nbsp&nbsp<span><?php echo $list['content']; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp<span>published at:<?php echo $list['published_at']; ?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span
                class="admire-cnt">

             <?php if ($list['status']): ?>
                <img class="<?php echo $list['post_id']; ?>" src="../app/assets/images/4.png">
                <?php else: ?><img class="<?php echo $list['post_id']; ?>" src="../app/assets/images/5.png">
             <?php endif; ?>

            <span><?php echo $list['likes']; ?></span></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="javascript:void(0);"
            class="collection">
            <?php if ($list['collect']): ?>
        <span class="<?php echo $list['post_id']; ?>">collect</span>
        <?php else: ?><span class="<?php echo $list['post_id']; ?>">cancel collect</span>
        <?php endif; ?>
        </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <a href="javascript:void(0);" class="comment"><span class="<?php echo $list['post_id']; ?>">comment</span></a>
        <form action="addComment" class="popcomment" method="post">
            <input type="text" name="content" placeholder='say something'>
            <input type="hidden" name="post_id" value="<?php echo $list['post_id']; ?>">
            <button type="submit" class="btn btn-default">comment</button>
        </form>
    </div>
    <br><br>
    <?php endforeach; ?>
    <?php endforeach; ?>
</div>
<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <img src="" id="imagepreview" style="width: 400px; height: 300px;">
            </div>
        </div>
    </div>
</div>


<!-- 隐藏框 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Choose photo</h4>
          </div>
          <div class="modal-body">
            <div class="container">
                    <div class="row">
                        <div class="col-md-1">
                            <button type="button" class="btn btn-self" id="add" >THIS IS THE BUTTON</button>
                        </div>
                    </div>
                    <div class="row" style="padding-top:10px">
                        <div class="col-md-1">
                            <div id="photo-show"></div>
                        </div>
                    </div>              
             </div>
          </div>
          <div class="modal-footer">        
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">Cancel</button>
                <button type="button" class="btn btn-primary" id="submit">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <form action="graphicUpload.html" method="post" onsubmit="return checkCoords();" id="photoform">
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />     
    </form>

    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-1">
                        <img src="" id='modifyPhoto' />
                    </div>
                    <div class="col-md-1 col-md-offset-3">
                        <div id="preview-pane">
                            <div class="preview-container">
                                <img src="" id="jcrop-preview" class="jcrop-preview" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="modify-submit">Ok</button>
          </div>
        </div>
      </div>
    </div>
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<script src="../vendor/jquery/jquery.Jcrop.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
    //放大图片
    $(".pop").on("click", function (e) {
        $target = e.target;
        $('#imagepreview').attr('src', $($target).attr('src')); // here asign the image to the modal when the user click the enlarge link
        $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    });
    //改变导航栏样式
    $('#dropdown').click(function () {
        $('#home').removeClass("active");
    });
    $('#home').click(function () {
        $('#home').addClass('active');
    })
    //点赞功能
    // var $image = $('.admire-cnt>img');
    $('.admire-cnt>img').on('click', function (e) {
        var $target = e.target;
        $($target).attr('src', '../app/assets/images/5.png');
        var $text = $($target).siblings('span');
        $post_id = $($target).attr('class');
        var url = 'dolike';
        $.getJSON(url, {post_id: $post_id}, function (re) {
            if (!re[0]) {
                alert('亲，您点过赞了哦~~');
            } else {
                var $count = re[1].toString();
                $text.html($count);
            }
        });
    });
    //收藏
    $('.collection>span').click(function (e) {
        // alert('ddd');
        var $target = e.target;
        $post_id = $($target).attr('class');
        // $status = $($target).attr('favorite');
        var url = 'handleCollect';
        $.post(url, {post_id: $post_id}, function (re) {
            // alert(re);
            if (!re) {
                $($target).html('collect');
            } else {
                $($target).html('cancel collect');
            }
        }, 'json');
    });
    //评论
    $('.comment>span').click(function (e) {
        // alert('ddd');
        var $target = e.target;
        $post_id = $($target).attr('class');
        var $onepost = $($target).parents('div:eq(0)');
        var $aele = $($target).parent();
        var $form = $($aele).next();
        var $cont = $($form).nextAll();
        // $status = $($target).attr('favorite');
        var url = 'handleComment';
        $.post(url, {post_id: $post_id}, function (re) {
            $cont.empty();
            var str = "<div>" + re + "</div>";
            $onepost.append(str);
            // console.log(re[0]['nick_name']);
            // console.log($form);
        }, 'json');
    });
    // $('#test2').live('click', function(){
    //  alert('ee');
    // });
    //提交评论
    $('.popcomment').submit(function (event) {
        // alert('hell');
        event.preventDefault();
        var url = $(this).attr('action');
        var postdata = $(this).serialize();
        // alert(postdata);
        var request = $.post(
                url,
                postdata,
                formpostcompleted,
                "text"
        );
        function formpostcompleted(data, status) {
            // console.log(data);
            alert(data);
        }
    }); // end submit function
    //这里是我懒得写Ajax了，但为了给用户一个反馈
    $('#postapost').click(function () {
        alert('post successfully!');
    });
</script>

<!-- 剪辑图片 -->
  <script type="text/javascript">

            //????
            $(function(){

                $("#add").bind("drag",function(event){
                    event.preventDefault(); 
                });

                $("#add").bind("dragenter",function(event){ 
                    event.preventDefault();
                });

                $("#add").bind("dragover",function(event){  
                    $('#add').css('background-image','url(../app/assets/images/up2.png)');
                    event.preventDefault();
                });

                $("#add").bind("dragleave",function(event){ 
                    $('#add').css('background-image','url(../app/assets/images/up1.png)');
                    event.preventDefault();
                });
                

                var reader = new FileReader();
                var img;
                var p;
                var jcrop_api,
                    boundx,
                    boundy,
                $preview = $('#preview-pane'),
                $pcnt = $('#preview-pane .preview-container'),
                $pimg = $('#jcrop-preview'),
                xsize = $pcnt.width(),
                ysize = $pcnt.height();
                var count = 0;

                $("#add").bind("drop",function(event){
                    event.preventDefault();

                    $('#add').css('background-image','url(../app/assets/images/up1.png)');
                    
                    var file = event.originalEvent.dataTransfer.files;
                    if(file.length==0){
                        alert("no file");
                        return false;
                    }

                    for(var i=0;i<file.length;i++)
                    { 
                        if(file[i].type.indexOf('image') === -1){ 
                            alert("您拖的不是图片！"); 
                            return false; 
                        }
                        //判断图片格式
                        // if(!(/\.(?:jpg|png|gif)$/.test(file[i])))      //不严谨
                        // {
                        //  alert("not jpg");
                        //  return false;
                        // }

                        if(count == 1)return false;
                        reader.readAsDataURL(file[i]);
                        reader.onloadend = function(readEvent){
                            p = readEvent.target.result;
                            img = '<div id="the-photo-container"><img src="'+ p +'" id="the-photo" /></div>';
                            $('#modifyPhoto').attr("src",p);
                            $('.jcrop-holder img').attr("src",p);
                            //修剪预览框
                            $('#jcrop-preview').attr("src",p);

                            $('#myModal').modal('hide');
                            $('#photoModal').modal('show');
                            
                            
                            
                            //裁剪
                            $('#modifyPhoto').Jcrop({
                                  bgFade : true,
                                  bgOpacity : 0.3,
                                  boxWidth : 300,
                                  boxHeight : 300,
                                  aspectRatio : 1,   //按照上传部分设定为固定大小
                                  onChange: updateCoords,
                                  onSelect: updateCoords
                            },function(){
                                var bounds = this.getBounds();
                                boundx = bounds[0];
                                boundy = bounds[1];
                                jcrop_api = this;
                                $preview.appendTo(jcrop_api.ui.holder); 
                            });
                        }
                    }   
                });
                
                function updateCoords(c)
                 {
                        var rx = xsize/c.w;
                        var ry = ysize/c.h;
                        $pimg.css({
                            width: Math.round(rx * boundx) + 'px',
                            height: Math.round(ry * boundy) + 'px',
                            marginLeft: '-' + Math.round(rx * c.x) + 'px',
                            marginTop: '-' + Math.round(ry * c.y) + 'px',
                        });
                        $('#x').val(c.x);
                        $('#y').val(c.y);
                        $('#w').val(c.w);
                        $('#h').val(c.h);
                 };
                
                $('#modify-submit').bind("click",function(){
                    $("#photo-show").append(img);
                    $("#photoModal").modal('hide');
                    jcrop_api.release();
                    if($('#w').val() != 0 && $('#h').val() != 0)
                    {
                        var sx = xsize/$('#w').val();
                        var sy = ysize/$('#h').val();
                        $('#the-photo').css({
                            width: Math.round(sx * boundx) + 'px',
                            height: Math.round(sy * boundy) + 'px',
                            marginLeft: '-' + Math.round(sx * $('#x').val()) + 'px',
                            marginTop: '-' + Math.round(sy * $('#y').val()) + 'px',
                        });
                    }
                    else{
                        var sx = xsize;
                        var sy = ysize;
                        $('#the-photo').css({
                            width: "135",
                            height: "135",
                        });
                    }
                    $('#myModal').modal('show');
                    count = 1;
                });


                $('#addPhoto').bind("click",function(){
                    $("#photo-show").empty();
                    $("#myModal").modal('show');
                });

                $('#cancel').bind("click",function(){
                    $("#myModal").modal('hide');
                    $("#photo-show").empty();
                    count = 0;
                    $('#x').val(0);
                    $('#y').val(0);
                    $('#w').val(0);
                    $('#h').val(0);
                });


                
                $('#submit').bind("click",function(){
                    $.ajax({
                        url: 'savepost',
                        cache: false,
                        data: {
                            img:p,
                             x: $('#x').val(),
                             y: $('#y').val(),
                             w: $('#w').val(),
                             h: $('#h').val(),
                             content:$('#postcontent').val(),
                        },
                        type: 'post',
                        dataType: 'json',
                        success: function(data){
                            $('#myModal').modal('hide');
                            $('#photo-show').empty();
                            count = 0;
                            $('#x').val(0);
                            $('#y').val(0);
                            $('#w').val(0);
                            $('#h').val(0);
                            location.reload();  

                        },
                        error: function(data){
                            alert("post failed");
                        }

                    });
                });

            //点击框外隐藏事件处理
           $('#photoModal').on('hidden.bs.modal',function(){
                jcrop_api.release();
                photoModalShow = 0;
            });

            });

        </script>
</body>
</html>