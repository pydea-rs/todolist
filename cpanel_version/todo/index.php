<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="../css/todos.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Todos</title>

</head>

<body>
<?php
    require_once __DIR__ . "/../config.php";
    require_once __DIR__ . "/../navbar.php";

    if(!isset($_SESSION[USER_NAME]) || !$_SESSION[USER_NAME] || !isset($_SESSION[USER_ID]) )
        redirect2("/login");
?>

<?php
    $url = $_SERVER['REQUEST_URI'];
    $todo_id = get_url_param($url, "todo");
    $user_id = $_SESSION[USER_ID];
    $edit_response = null;
    $todo = null;
    if($todo_id && $user_id){
        if($connection) {
            $query = sprintf("SELECT * FROM `%s` WHERE %s=%d AND %s=%d", TABLE_TODOS, TODO_OWNER, $user_id, TODO_ID, $todo_id);
            $result = $connection->query($query);
            if($result){
                if($result->num_rows > 0)
                    $todo = $result->fetch_array(MYSQLI_ASSOC);
                else
                    $edit_response = '<p class="error">Edit failed; No such todo has been found!</p>';
            }
            else
                $edit_response = '<p class="error">Error while trying to obtain the todo you selected!</p>';
        }
        else
           $edit_response = '<p class="error">Cannot connect to the database!</p>';
    }
?>
    <div class="todos-card" id="divInput">

        <?php
            
            require_once 'todo/calendar.php';

            if(isset($_SESSION['date'])) {
                $todo_text = $start_time = $end_time = $date = '';
                $submit_button_text = "Add";
                $_SESSION['operation'] = [];
                if ($todo) {
                    $todo_text = $todo[TODO_TEXT];
                    $start_time = $todo[TODO_START_TIME];
                    $end_time = $todo[TODO_END_TIME];
                    $date = $todo[TODO_DATE];
                    $submit_button_text = "Edit";
                    $_SESSION['operation'] = array("type" => "edit", "todo_id" => $todo_id);
                    echo "<h1>Edit Todo:</h1>";
                } else {
                    $_SESSION['operation'] = array("type" => "add");
                    echo "<h1>New Todo:</h1>";
                }
                // messages and responses
                if (isset($_SESSION['response']) && $_SESSION['response']) {
                    echo $_SESSION['response'];
                    unset($_SESSION['response']);
                } else if ($edit_response) {
                    echo $edit_response;
                    $edit_response = null;
                }

                echo <<< _END
                    <br >
                    <form action="/todo/update.php" method="post">
                        <label for="txtTodo" style="padding-top:-1rem"></label><input type="text" id="txtTodo" name="todo_text" placeholder="Todo..." value="$todo_text" required="required" />
                        <br ><br >
                        <label for="timeStart">Start</label><input class="time-input" id="timeStart" name="start_time" type="time" value="$start_time" required="required" />
                        <label for="timeEnd">End</label><input class="time-input" id="timeEnd" name="end_time" type="time" value="$end_time" required="required" />
                        <!-- date -->
                        <input type="submit" name="todo_attempt" class="button-submit"  id="btnSubmitTodo" value="$submit_button_text" />
                    </form>
                _END;
                if ($_SESSION['operation']['type'] !== 'edit')
                    require_once 'todo/todos.php';
            }

         ?>
	</div>
</body>
</html>
