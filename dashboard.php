<?php 
    session_start();

    require 'database_alt.php';

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
            $pic = $row['pic'];
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
        <h4>Your notes</h4>
        <div class="row">
        <?php
                    $num = 0;
                    $select = "SELECT * FROM notes WHERE owner='".$_SESSION['email']."'";
                    if($result = mysqli_query($link, $select))
                    {
                        if(mysqli_num_rows($result) <= 0)
                        {
                            $message = "<p class='orange-text'>No notes yet</p>";
                        } else {
                            foreach($result as $note)
                            {
                                $num++;
                                if($note['owner'] == $_SESSION['email'])
                                {
                                    $profi = "You";
                                } else {
                                    $ask = "SELECT * FROM users WHERE email='".$note['owner']."'";
                                    if($klm = mysqli_query($link,$ask))
                                    {
                                        if(mysqli_num_rows($klm) > 0)
                                        {
                                            $finds = mysqli_fetch_array($klm);
                                            $other_name = $finds['name'];
                                            $other_last = $finds['last_name'];
                                            $profi = $other_name." ".$other_last;
                                        }
                                    }
                                }

                                if($note['partner1'])
                                {
                                    $partner = "SELECT name, last_name, pic FROM users WHERE email='".$note['partner1']."'";
                                    if($partner_results = mysqli_query($link,$partner))
                                    {
                                        $show_partner_rows = mysqli_fetch_array($partner_results);
                                        $show_partner = $show_partner_rows['name']." ".$show_partner_rows['last_name'];
                                        $show_partner_pic = $show_partner_rows['pic'];
                                        $partner_chip = '
                                            <div class="chip">
                                                <img src="./profiles/'.$show_partner_pic.'.png" alt="Contact Person">
                                                '.$show_partner.'
                                            </div>
                                        ';
                                    }
                                } else {
                                    $partner_chip = "";
                                }

                                # 0 private
                                # 1 public

                                if($note['private'] == 0)
                                {
                                    $icon = "lock_outline";
                                } else {
                                    $icon = "lock_open";
                                }
                                echo '
                                <div class="col s12 m6 l4">
                                  <div class="card">
                                    <div class="card-content white-text">
                                      <p class="black-text"><b>'.$note["title"].'</b></p>
                                      <br>
                                      <div class="chip">
                                        <img src="./profiles/'.$pic.'.png" alt="Contact Person">
                                        '.$profi.'
                                      </div>
                                      '.$partner_chip.'
                                    </div>
                                    <div class="card-action">
                                      <span class="left"><i class="material-icons">'.$icon.'</i></span>
                                      <a href="edit.php?note_id='.$note["id"].'"><i class="material-icons teal-text right">create</i></a>
                                      <a href="delete.php?note_id='.$note["id"].'"><i class="material-icons red-text right">delete</i></a>
                                    </div>
                                  </div>
                                </div>';
                            }
                        }
                    }

                ?>
                </div>
                <?php if(!empty($message)): ?>
                    <?= $message ?>
                <?php endif; ?>
    </div>
    <div class="container">
        <div class="divider"></div>
        <h4>Shared with you</h4>
        <div class="row">
        <?php 
            $quest = "SELECT * FROM notes WHERE partner1='".$_SESSION['email']."'";
            if($query_result = mysqli_query($link, $quest))
            {
                if(mysqli_num_rows($query_result) > 1)
                {
                    foreach($query_result as $shared)
                    {
                        if($shared['owner'])
                        {
                            $query_selector = "SELECT * FROM users WHERE email='".$shared['owner']."'";
                            if($query_selector_result = mysqli_query($link, $query_selector))
                            {
                                $qs_rows = mysqli_fetch_array($query_selector_result);
                                $share_name = $qs_rows['name'];
                                $share_last = $qs_rows['last_name'];
                                $share_pic = $qs_rows['pic'];
                                $owner = $share_name." ".$share_last;
                            }
                        }

                        echo '
                        <div class="col s12 m6 l4">
                            <div class="card">
                                <div class="card-content">
                                    <p><b>'.$shared['title'].'</b></p>
                                    <div class="chip">
                                        <img src="./profiles/'.$share_pic.'.png" alt="Contact Person">
                                        '.$owner.'
                                    </div>
                                    <div class="chip">
                                        <img src="./profiles/'.$pic.'.png" alt="Contact Person">
                                        You
                                    </div>
                                </div>
                                <div class="card-action">
                                    <a href="edit.php?note_id='.$shared["id"].'"><i class="material-icons teal-text right">create</i></a>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    $new_message = "<p class='orange-text'>No shared notes with you</p>";
                }
            }
        ?>
        <?php if(!empty($new_message)): ?>
            <?= $new_message ?>
        <?php endif; ?>
        </div>
    </div>
    <div class="fixed-action-btn">
        <button type="submit" data-target="modal1" class="btn-floating btn-large pulse waves-effect waves-light red modal-trigger"><i class="material-icons">add</i></button>
    </div>
  <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>New note</h4>
            <form action="insert_note.php" method="post">
                <div class="row">
                    <div class="col s6 input-field">
                        <input id="title" type="text" required class="validate" name="title" autocomplete="off">
                        <label for="title">Your note's title</label>
                    </div>
                    <div class="input-field col s6">
                        <select name="private" id="select">
                            <option value="0">Private</option>
                            <option value="1">Public</option>
                        </select>
                        <label>Choose the note's attributes</label>
                    </div>
                    <small>If your note is private you can't add a partner</small>
                    <div class="col s6 input-field">
                        <input id="partner" type="email" class="validate" name="partner" autocomplete="off">
                        <label for="partner">Add a partner</label>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">Add
                    <i class="material-icons right">add</i>
                </button>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>
    <?php include 'partials/scripts.php' ?>
    <script>
</body>
</html>