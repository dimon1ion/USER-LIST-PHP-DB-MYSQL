<?php

// include
// require
// include_once
// require_once

    require_once("./db/config.php");
    require_once("./db/db.php");

?>

<?php

    if (isset($_POST["deleteWorkerById"]) && !empty($_POST["deleteWorkerById"])) {
        $sql = "DELETE FROM `workers` WHERE Id=".$_POST["deleteWorkerById"];

        $result = mysqli_query(dbConnect($config), $sql);
        
        errorMessage($config, $result);
    }

    if (isset($_POST["name"], $_POST["age"], $_POST["number"])) {
        if (empty($_POST["age"])) {
            $_POST["age"] = 0;
        }
        $sql = "INSERT INTO `workers`(`name`, `age`, `number`)
         VALUES ('".$_POST["name"]."','".$_POST["age"]."','".$_POST["number"]."')";

        $result = mysqli_query(dbConnect($config), $sql);
        
        errorMessage($config, $result);
    }

    $sql = "SELECT * FROM `workers`";

    $result = mysqli_query(dbConnect($config), $sql);

    errorMessage($config, $result);

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
</head>

<body>
    <div class="container">
        <!-- <form action="form.php" method="POST"> -->
        <form method="POST">
        <div class="mb-3">
                <label class="form-label w-100">Name
                    <input name="name" type="text" class="form-control" placeholder="Name">
                </label>
            </div>
            <div class="mb-3">
                <label class="form-label w-100">Age
                    <input name="age" type="number" class="form-control" placeholder="Age">
                </label>
            </div>
            <div class="mb-3">
                <label class="form-label w-100">Phone number
                    <input name="number" type="text" class="form-control" placeholder="Phone number">
                </label>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Add User</button>
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
                        <th scope="col">Phone number</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($row = mysqli_fetch_array($result)) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row["id"] . '</th>';
                        echo '<td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["age"] . '</td>';
                        echo '<td>' . $row["number"] . '</td>';
                        echo '<td><form method="POST" ><button type="submit" name="deleteWorkerById" value="' . $row["id"] . '" class="btn btn-danger mx-2"  >Delete</button></form></td>';
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