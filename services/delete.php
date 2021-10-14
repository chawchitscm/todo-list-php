<?php
    include __DIR__.'/../db_connect.php';
    session_start();

    $connection = openCon();

    if (isset($_GET['delid'])) {
        $id = $_GET['delid'];
        
        $query = "DELETE FROM todo WHERE id=$id";
        mysqli_query($connection, $query);
        $_SESSION['message'] = "To Do Deleted";
        header('location: ../index.php');
    }