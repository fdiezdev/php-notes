<?php 
  session_start();

  require 'database.php';
  require 'database_alt.php';

  if(isset($_SESSION['id']))
  {
    header("Location: dashboard.php");
  } else {
    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
      $email = mysqli_real_escape_string($link, $_POST['email']);
      
      $records = $conn->prepare('SELECT id, email, password, pic FROM users WHERE email=:email');
      $records->bindParam(':email', $email);
      $records->execute();
      $results = $records->fetch(PDO::FETCH_ASSOC);

      if(count($results) > 0 && password_verify($_POST['password'],$results['password']))
      {
        $_SESSION['id'] = $results['id'];
        $_SESSION['pic'] = $results['pic'];
        $_SESSION['email'] = $results['email'];
        header("Location: dashboard.php");
      } else {
        $message = "
          Invalid username or password
        ";
      }
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="grey lighten-2">
  <div class="split-lg"></div>
          <div class="row">
            <div class="col s12 m4"></div>
            <div class="col s12 m4">
              <div class="z-depth-6 card-panel">
                <h4>Login</h4>
                <?php if(!empty($message)): ?>
                  <?= "<span class='red-text'>".$message."</span>"; ?>
                <?php endif; ?>
                <form action="login.php" method="post">
                
                  <div class="input-field col s12">
                    <input class="validate" id="email" type="email" name="email" autocomplete="off">
                    <label for="email" data-error="wrong" data-success="right">Email</label>
                  </div>
                
                
                  <div class="input-field col s12">
                    <input class="validate" id="password" type="password" name="password">
                    <label for="password" data-error="wrong" data-success="right">Password</label>
                  </div>
                
                <button type="submit" class="waves-effect waves-light btn" style="width: 100%;">Login</button>
                </form>
                <div class="split-lg"></div>
                <span><a href="signup.php">Sign Up</a> <a href="#" class="right">Forgot your password?</a></span>
              </div>
            </div>
            <div class="col s12 m4"></div>
          </div>
      </div>

    </div>
  </div>
  <?php include 'partials/scripts.php' ?>
</body>
</html>