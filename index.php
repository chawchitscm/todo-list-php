<?php  
    include('db_connect.php'); 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/index.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/linegraph.js"></script>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-5">To Do List</h1>
        <form method="post" action="./services/save.php">
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 mb-1">
                    <input type="text" class="form-control" placeholder="To Do" name="todo_name">
                </div>
                <div class="col-md-4 mb-1">
                    <input type="text" class="form-control" placeholder="Description" name="description">
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 mb-1">
                    <input type="date" class="form-control" name="due_date">
                </div>
                <div class="col-md-4 mb-1">
                    <input type="submit" value="Add" class="btn btn-primary" name="save">
                </div>
            </div>
        </form>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="row d-flex justify-content-center">
                <div class="col-md-10">
                    <div class="alert alert-success my-3">
                        <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
        
        <?php 
            $connection = openCon();
            $result = mysqli_query($connection, "SELECT * from todo") 
        ?>
        <div class="row d-flex justify-content-center my-3">
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>To Do</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Checked</th>
                            <th>Finished Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['description'] ?></td>
                            <td><?php echo $row['due_date']; ?></td>
                            <td>
                                <div class="form-check">
                                    <?php if($row['checked'] == 1): ?>
                                    <input class="form-check-input" type="checkbox" checked>
                                    <?php else: ?>
                                    <input class="form-check-input" type="checkbox">
                                    <?php endif ?>
                                </div>
                            </td>
                            <td><?php echo $row['finished_date']; ?></td>
                            <td>
                                <button type="button" class="btn btn-success editBtn" data-toggle="modal" data-target="#editModal"
                                data-id="<?php echo $row['id']; ?>"
                                data-name="<?php echo $row['name']; ?>"
                                data-desc="<?php echo $row['description'] ?>"
                                data-due="<?php echo $row['due_date'] ?>"
                                data-checked="<?php echo $row['checked'] ?>"
                                data-finish="<?php echo $row['finished_date'] ?>"
                                >
                                    Edit
                                </button>
                                <a href="./services/delete.php?delid=<?php echo $row['id']; ?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="linegraph"></canvas>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="./services/edit.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                        $result = mysqli_query($connection, "SELECT * from todo where id=") 
                    ?>
                    <div class="modal-body">
                        <input type="hidden" name="todo_id" id="todo_modal_id">
                        <input class="form-control mb-1" type="text" name="todo_name" placeholder="To Do" id="todo_modal_name">
                        <input class="form-control mb-1" type="text" name="description" placeholder="Description" id="todo_modal_desc">
                        <input class="form-control mb-1" type="date" name="due_date" id="todo_modal_due">
                        <input class="form-control mb-1" type="date" name="finished_date" id="todo_modal_finish">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="checked" value="1" id="todo_modal_checked">
                            <label class="form-check-label">
                                Checked
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>