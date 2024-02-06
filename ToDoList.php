<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        input {
            padding: 10px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        .completed {
            text-decoration: line-through;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Simple To-Do List</h1>

    <form method="post" action="">
        <label for="task">Add a new task:</label>
        <input type="text" name="task" id="task" required>
        <button type="submit">Add Task</button>
    </form>

    <?php
        //For tesing: https://phptas-23010.siv-ams.servebolt.cloud/todolist.php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve the task from the form
            $task = htmlspecialchars($_POST["task"]);

            // Initialize or retrieve the tasks array from a session
            session_start();
            if (!isset($_SESSION["tasks"])) {
                $_SESSION["tasks"] = array();
            }

            // Add the new task to the tasks array
            array_push($_SESSION["tasks"], $task);
        }

        // Display the to-do list
        echo '<ul>';
        session_start();
        foreach ($_SESSION["tasks"] as $index => $task) {
            echo '<li class="' . (isset($_SESSION["completed"][$index]) ? 'completed' : '') . '">';
            echo '<input type="checkbox" onchange="toggleCompletion(' . $index . ')" ' . (isset($_SESSION["completed"][$index]) ? 'checked' : '') . '>';
            echo $task;
            echo '<button onclick="deleteTask(' . $index . ')">Delete</button>';
            echo '</li>';
        }
        echo '</ul>';

        // Function to toggle the task completion
        echo '<script>
            function toggleCompletion(index) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xmlhttp.open("GET", "toggleCompletion.php?index=" + index, true);
                xmlhttp.send();
            }

            // Function to delete a task
            function deleteTask(index) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xmlhttp.open("GET", "deleteTask.php?index=" + index, true);
                xmlhttp.send();
            }
        </script>';
    ?>
</body>
</html>
