
<!DOCTYPE html>
<html>
 <meta charset="UTF-8">
  <head>
    <title>登&nbsp;&nbsp;录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
	<link href="css/login.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
  
    <div class="container">

      <!-- <form class="form-signin" method='post' action='login.php'> --> 
      <form class="form-signin" method='post' action='login.php'>
        <h2 class="form-signin-heading">登录</h2>
     姓名： <input id="user" type="text"  name='user' value='user'  class="input-block-level" placeholder="请输入姓名">
		       密码： <input id="password"  type="password"  name='pass' value='pass'  class="input-block-level" placeholder="请输入密码">
        <button class="btn btn-large btn-primary" type="submit">登&nbsp;&nbsp;录</button> &nbsp;&nbsp; error

      </form> 
</div>

</body>
