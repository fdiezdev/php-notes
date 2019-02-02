<?php
    session_start();

    require 'database_alt.php';

    if(!isset($_SESSION['id']))
    {
        header("Location: index.php");
    } else {
        $id = $_POST['id'];
        $content = mysqli_real_escape_string($link,$_POST['data']);
        $sql = "UPDATE notes SET content='".$content."' WHERE id='".$id."'";
        if($result = mysqli_query($link, $sql))
        {
            header("Location: edit.php?note_id=".$id."");
        }
    }

?>