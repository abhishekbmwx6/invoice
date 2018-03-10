<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>A Pen by  Zoltan Kohalmy</title>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <div class="col-md-6 centered">
 <form class="form-signin " method="post"  action="./controller/login.do.php" >
        <h2 class="form-signin-heading">Please sign in</h2>
        <h4 class="alert alert-danger text-center"><?php if($_GET && $_GET["error"]){ echo $_GET["error"]; } ?></h4> 
        
        <label for="Username" class="sr-only">Username</label>
        <input type="text" minlength="3" name="username" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" minlength="3" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
</div>
</div>
</body>

</html>
