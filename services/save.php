<?php
    include __DIR__.'/../db_connect.php';
    session_start();

    $connection = openCon();

    $name = "";
    $date = "";
    $description = "";

    if (isset($_POST['save'])) {
        $name = $_POST['todo_name'];
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];

        $query = "INSERT INTO todo (name, description, due_date) VALUES ('$name', '$description', '$due_date')";
        mysqli_query($connection, $query); 
		$_SESSION['message'] = "New To Do Added.";
		header('location: ../index.php');
    }