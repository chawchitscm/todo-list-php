<?php
    include __DIR__.'/../db_connect.php';
    session_start();

    $connection = openCon();

    if (isset($_POST['edit'])) {
        $id = $_POST['todo_id'];
        $name = $_POST['todo_name'];
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];
        $checked = $_POST['checked'];
        $finished_date = $_POST['finished_date'];

        $query = "UPDATE todo SET name='$name', description='$description', due_date='$due_date', checked='$checked', finished_date='$finished_date' WHERE id=$id";
        mysqli_query($connection, $query); 
		$_SESSION['message'] = "To Do Updated.";
		header('location: ../index.php');
    }