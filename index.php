<?php

// include
// require
// include_once
// require_once

require_once("./db/config.php");
require_once("./db/db.php");

?>

<?php
$isEditable = false;

if (isset($_POST["deleteWorkerById"]) && !empty($_POST["deleteWorkerById"])) {
    $sql = "DELETE FROM workers WHERE Id=" . $_POST["deleteWorkerById"];

    $result = mysqli_query(dbConnect($config), $sql);

    errorMessage($config, $result);
}
else if (isset($_POST["editWorkerById"]) && !empty($_POST["editWorkerById"])) {
    if (isset($_POST["name"], $_POST["age"], $_POST["salary"])) {
        if (empty($_POST["age"])) {
            $_POST["age"] = 0;
        }
        if (empty($_POST["salary"])) {
            $_POST["salary"] = 0;
        }
        $sql = "UPDATE workers 
            SET name='" . $_POST["name"] . "',age=" . $_POST["age"] . ",salary=" . $_POST["salary"] . " WHERE id=" . $_POST["editWorkerById"];

        $result = mysqli_query(dbConnect($config), $sql);

        errorMessage($config, $result);
    }
}

if (isset($_POST["addWorker"], $_POST["name"], $_POST["age"], $_POST["salary"])) {
    if (empty($_POST["age"])) {
        $_POST["age"] = 0;
    }
    if (empty($_POST["salary"])) {
        $_POST["salary"] = 0;
    }
    $sql = "INSERT INTO workers(name, age, salary)
         VALUES ('" . $_POST["name"] . "'," . $_POST["age"] . "," . $_POST["salary"] . ")";

    $result = mysqli_query(dbConnect($config), $sql);

    errorMessage($config, $result);
}

$sql = "SELECT * FROM `workers`";

$result = mysqli_query(dbConnect($config), $sql);
errorMessage($config, $result);

$allWorkers = [];

while ($row = mysqli_fetch_assoc($result)){
    array_push($allWorkers, $row);
}

$editName = "";
$editAge = 0;
$editSalary = 0;

if (isset($_POST["editWorker"]) && !empty($_POST["editWorker"])) {
    $isEditable = true;
    foreach ($allWorkers as $row) {
        if ($row["id"] === $_POST["editWorker"]) {
            $editName = $row["name"];
            $editAge = $row["age"];
            $editSalary = $row["salary"];
        }
    }
}

mysqli_close(dbConnect($config));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        form{
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- <form action="form.php" method="POST"> -->
        <form method="POST">
            <div class="mb-3">
                <label class="form-label w-100">Name
                    <?php
                    echo '<input name="name" type="text" class="form-control" placeholder="Name" value="' . ($isEditable ? $editName : "") . '" >';
                    ?>
                </label>
            </div>
            <div class="mb-3">
                <label class="form-label w-100">Age
                    <?php
                    echo '<input name="age" type="number" class="form-control" placeholder="Age" value="' . ($isEditable ? $editAge : 0) . '" >';
                    ?>
                </label>
            </div>
            <div class="mb-3">
                <label class="form-label w-100">Salary
                    <?php
                    echo '<input name="salary" type="number" class="form-control" placeholder="Salary" value="' . ($isEditable ? $editSalary : 0) . '" >';
                    ?>
                </label>
            </div>
            <div class="col-auto mb-3">
                <?php
                if ($isEditable) {
                    echo '<button type="submit" name="editWorkerById" value="' . $_POST["editWorker"] . '" class="btn btn-warning mx-2">Edit User</button>';
                }
                ?>
                <button type="submit" name="addWorker" class="btn btn-primary mx-2">Add User</button>
            </div>
        </form>
    </div>

    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Salary</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($allWorkers as $row) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row["id"] . '</th>';
                        echo '<td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["age"] . '</td>';
                        echo '<td>' . $row["salary"] . ' ₼</td>';
                        echo '<td>
                            <form method="POST" >
                                <button type="submit" name="deleteWorkerById" value="' . $row["id"] . '" class="btn btn-danger mx-2"  >Delete</button>' .
                            ($isEditable && $row["id"] === $_POST["editWorker"] ?
                                '<button type="button" class="btn btn-primary mx-2" >Selected</button>' :
                                '<button type="submit" name="editWorker" value="' . $row["id"] . '" class="btn btn-warning mx-2"  >Edit</button>'
                            ) .
                            '</form>
                        </td>';
                        echo '<tr>';
                        // echo "<div>";
                        // echo $row["id"] . " ";
                        // echo $row["name"] . " ";
                        // echo $row["age"] . " ";
                        // echo $row["number"] . " ";
                        // echo "</div>";
                    }

                    ?>
                </tbody>
            </table>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>