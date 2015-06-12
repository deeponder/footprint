<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FootPrint</title>
<link href="app/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="app/assets/css/login.css" rel="stylesheet" type="text/css">

</head>

<body background="app/assets/images/body1.jpg">
<script src="vendor/jquery/jquery-1.11.3.min.js"></script>
<script src="vendor/jquery/bootstrap.min.js"></script>
<script type="text/javascript" src="vendor/jquery/jquery-1.6.2.min.js"></script>
<p align="center" style=" margin-top:150px; "><font size="+5" color="#FFFFFF">FootPrint</font></p>
<div id="div">
<div></div>

<div style="padding: 20px 100px 20px 140px;">
  
   <form method="post" action="" onsubmit="" class="login">
    <p>
      <label for="login" ><font color="#FFFFFF">Username:</font></label>
      <input type="text" name="id" id="id" value=""></input>
    </p>

    <p>
      <label for="password" ><font color="#FFFFFF">password:</font></label>
      <input type="password" name="password" id="password" value=""></input>
    </p>

    </form>
</div>
<p align="center"><button type="button" class="btn btn-primary" style="background-color:#060; border-color:#030; width:100px;" onclick="check()" >Login</button></p><a href="forgetpass"  style="margin-right:100px;float:right">forgetPassword?</a><a href="register"  style="margin-right:70px;float:right">Register</a>
</div>
</body>
<script type="text/javascript">
function check()
{
  var id = document.getElementById('id').value;
  var password = document.getElementById('password').value;
  $.ajax(
  {
    type:"GET",
    url : "check?id="+id+"&password="+password,
    datatype:"text",
    success:function(data)
    {
      if(data=='1')
      {
        window.location.href = 'home';
      }   
      else if(data=='2')
      {
        alert("the accout has not verified");
      } 
      else
        alert("no account");
    },
    error:function(data)
    {
      alert("登陆失败！");
    }
  });
}

</script>
</html>
