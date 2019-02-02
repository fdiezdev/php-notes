<?php 
    session_start();

    require 'database_alt.php';
    $id = $_GET['note_id'];
    
    if(!isset($_SESSION['id']))
    {
        header("Location: index.php");
    } else {
        $query = "SELECT * FROM notes WHERE id='".$id."'";
        if($result = mysqli_query($link,$query))
        {
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                if($row['owner'] == $_SESSION['email'])
                {
                    $delete = "DELETE FROM notes WHERE id='".$id."'";
                    if(mysqli_query($link,$delete))
                    {
                        // Deleted succesfully
                        header("Location: dashboard.php");
                    }
                }
            }
        }
    }

?>