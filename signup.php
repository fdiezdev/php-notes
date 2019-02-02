<?php 
    include 'database.php';
    include 'database_alt.php';

    $message = "";

    if(!empty($_POST['email']))
    {
        if($_POST['password'] != $_POST['pass_check'])
        { 
            $message = "<div class='notification is-danger'>
            Passwords doesn't match!</div>";
        } else {
            $name = mysqli_real_escape_string($link,$_POST['name']);
            $last_name = mysqli_real_escape_string($link,$_POST['last_name']);
            $email = mysqli_real_escape_string($link,$_POST['email']);
            $password = mysqli_real_escape_string($link,$_POST['password']);
            
            $query = "SELECT email FROM users WHERE email='".$email."'";
            if($result = mysqli_query($link,$query))
            {
                if (mysqli_num_rows($result) > 0) {
                    $message = "<div class='notification is-danger'>
                    The email was already used!</div>";
                } else {
                    $sql = "INSERT INTO users (name, last_name, email, password, pic) VALUES (:name, :last_name, :email, :password, :pic)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':name', $name);
                    $pswd_hash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt->bindParam(':password', $pswd_hash);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':email', $email);
                    // PIC 
                    $pic = strtolower($name[0]);
                    $stmt->bindParam(':pic', $pic);
                    if($stmt->execute())
                    {
                        $message = "<div class='notification is-success'>
                        Successfully created new user!</div>";
                    } else {
                        $message = "<div class='notification is-danger'>
                        Error while creating user.</div>";
                    }

                }
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
    <title>My website</title>

    <link rel="stylesheet" href="css/bulma.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="split"></div>
        <div class="container">
            <div class="split-lg"></div>
            <div class="columns">
                <div class="column"></div>
                <div class="column">
                    <div class="title has-text-centered">Welcome!</div>
                    <?php if(!empty($message)): ?>
                        <?= $message ?>
                    <?php endif; ?>
                    <form action="signup.php" method="post">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Name" name="name" required autofocus autocomplete="off">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Last Name</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Last Name" name="last_name" required autocomplete="off">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" placeholder="example@example.com" name="email" required autocomplete="off" autocomplete="off">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" id="password" type="password" placeholder="Don't use password as password" name="password" required autocomplete="off">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Repeat your password</label>
                            <div class="control">
                                <input class="input" id="passcheck" type="password" placeholder="Repeat it" name="pass_check" autocomplete="off">
                            </div>
                        </div>
                        <button class="button is-fullwidth is-link" onclick="validate()" id="button">Validate</button>
                    </form>
                    <div class="split"></div>
                    <p class="has-text-centered">or <a href="login.php">Login</a></p>
                </div>
                <div class="column"></div>
            </div>
        </div>
    <?php include 'partials/scripts.php' ?>
</body>
</html>