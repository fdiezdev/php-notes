<?php 
    session_start();

    require 'database_alt.php';

    $id = $_GET['note_id'];
    if(!isset($_SESSION['id']))
    {
        header("Location: index.php");
    } else {
        $query = "SELECT * FROM users WHERE id='".$_SESSION['id']."'";
        if($result = mysqli_query($link,$query))
        {
            $row = mysqli_fetch_array($result);
            $name = $row['name'];
            $last = $row['last_name'];
            $email = $row['email'];
            $account = $row['account'];

            if(isset($_SESSION['id']))
            {
                $sql = "SELECT * FROM notes WHERE id='".$id."'";
                if($end = mysqli_query($link,$sql))
                {
                    if(mysqli_num_rows($end))
                    {
                        $fields = mysqli_fetch_array($end);
                        $owner = $fields['owner'];
                        if($fields['owner'] != $_SESSION['email'])
                        {
                            if($fields['partner1'] != $_SESSION['email']){
                                header('Location: index.php');
                            } else {
                                $content = $fields['content'];
                            }
                        } else {
                            $content = $fields['content'];
                        }
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'partials/app.php' ?>
    <div class="split-lg"></div>
    <div class="container">
        <!--<h3>Welcome, <?= $name ?></h3>-->
        <form action="update.php" method="post">
            <input type="hidden" value="<?= $id ?>" name="id">
            <textarea name="data" class="special"><?= $content ?></textarea>
            <div class="fixed-action-btn">
                <button type="submit" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">save</i></button>
            </div>
        </form>
        <a id="menu" class="waves-effect waves-light btn btn-floating" ><i class="material-icons">help</i></a>
        <div class="tap-target" data-target="menu">
            <div class="tap-target-content">
                <h5>Press the button to save</h5>
                <p>save the document an syncronize it to able your partner to see it</p>
            </div>
        </div>
    <?php include 'partials/scripts.php' ?>
    <script>
        $("#menu").click(function(){
            $('.tap-target').tapTarget();
        });
    </script>
</body>
</html>