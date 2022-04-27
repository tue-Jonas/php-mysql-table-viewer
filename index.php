<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jonas Tüchler">
    <meta name="description" content="Simple PHP-Tool to display MYSQL tables">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Simple MYSQL Table Viewer</title>
</head>

<body class="my-5">

    <div class="container text-center mb-5">
        <h1 class="display-3">Simple MYSQL Table Viewer</h1>
        <h2 class="display-6">sql.jonastuechler.at</h2>
    </div>

    <div class="container mb-5">
        <div class="mx-auto" style="width: 50%">
            <form method="post" action="./">
                <div class="mb-3">
                    <label for="inputHost" class="form-label">Host</label>
                    <input required type="text" class="form-control" name="inputHost" id="inputHost">
                </div>
                <div class="mb-3">
                    <label for="inputUser" class="form-label">User</label>
                    <input required type="text" class="form-control" name="inputUser" id="inputUser">
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="inputPassword" id="inputPassword">
                </div>
                <div class="mb-3">
                    <label for="inputDatabase" class="form-label">Database</label>
                    <input required type="text" class="form-control" name="inputDatabase" id="inputDatabase">
                </div>
                <div class="mb-3">
                    <label for="inputTable" class="form-label">Table</label>
                    <input required type="text" class="form-control" name="inputTable" id="inputTable">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function inputValues(host, user, database, table) {
            document.getElementById("inputHost").value = host;
            document.getElementById("inputUser").value = user;
            document.getElementById("inputDatabase").value = database;
            document.getElementById("inputTable").value = table;
        }
    </script>

    <div class="overflow-scroll mt-5">
        <table class="table table-striped table-dark text-center">
            <?php
            if ($_POST["inputHost"]) {
                $conn = mysqli_connect($_POST["inputHost"], $_POST["inputUser"], $_POST["inputPassword"], $_POST["inputDatabase"]);
                if ($conn) {
                    echo "<thead><tr>";
                    $sql = "DESCRIBE " . $_POST["inputTable"];
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<th>' . $row[0] . '</th>';
                    }
                    echo "</tr></thead>";

                    $sql = "SELECT * FROM " . $_POST["inputTable"] . ";";
                    $result = mysqli_query($conn, $sql);
                    echo "<tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        foreach ($row as $item) {
                            echo '<td>' . $item . '</td>';
                        }
                        echo '</tr>';
                    }
                    echo "</tbody>";
                } else {
                    echo '
                        <div class="alert alert-danger" role="alert">
                            Database connection failed!
                        </div>
                    ';
                }

                $argsString = "\"" . $_POST["inputHost"] . "\", \"" . $_POST["inputUser"] . "\", \"" . $_POST["inputDatabase"] . "\", \"" . $_POST["inputTable"] . "\"";
                echo '<script>inputValues(' . $argsString . ');</script>';
            }
            ?>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
