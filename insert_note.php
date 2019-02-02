<?php 
    session_start();

    if(!isset($_SESSION['id']))
    {
        header("Location: index.php");
    } else {
        require 'database_alt.php';

        $title = mysqli_real_escape_string($link, $_POST['title']);
        $owner = $_SESSION['email'];
        $private = $_POST['private'];
        $partner = mysqli_real_escape_string($link, $_POST['partner']);
        $content = "";

        # 0 == "private" && 1 == "public"
        if($private == "0")
        {
            $insert = "INSERT INTO notes (title, owner, private, content) VALUES ('".$title."', '".$owner."', '".$private."', '$content')";
            if(mysqli_query($link, $insert))
            {
                header("Location: dashboard.php");
            } else {
                echo "Error!";
            }
        } elseif ($private == "1") {
            if (!empty($partner)) {
                $add_with_partner = "INSERT INTO notes (title, owner, private, content, partner1) VALUES ('".$title."', '".$owner."', '".$private."', '$content', '".$partner."')";
                if($res_a_partner = mysqli_query($link, $add_with_partner))
                {
                    header("Location: dashboard.php");
                } else {
                    echo "Error #2";
                    echo "<br>";
                    echo $partner;
                    echo "<br>";
                    echo $owner;
                    echo "<br>";
                    echo $private;
                    echo "<br>";
                    echo $title;
                }
            } else {
                $add_with_out_partner = "INSERT INTO notes (title, owner, private, content) VALUES ('".$title."', '".$owner."', '".$private."', '$content')";
                if($res_a_wo_partner = mysqli_query($link,$add_with_out_partner))
                {
                    header("Location: dashboard.php");
                } else {
                    echo "Error #3";
                }
            }
        }
        
        /**/
    }

?>