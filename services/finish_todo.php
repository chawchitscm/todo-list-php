<?php

    include __DIR__.'/../db_connect.php';
    session_start();

    $connection = openCon();

    $query ="SELECT finished_date, count(*) as finished_todos FROM todo WHERE finished_date IS NOT NULL GROUP BY finished_date";
    $result = mysqli_query($connection, $query);
    
    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }
    mysqli_close($connection);
    echo json_encode($data);
