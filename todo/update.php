<?php
    session_start();
    require_once '../common/config.php';

    $response = '';
    if(isset($_SESSION['operation']) && ($_SESSION['operation']['type'] === 'add' || $_SESSION['operation']['type'] === 'edit')) {
        $operation = $_SESSION['operation'];
        if (isset($_POST['todo_attempt'])) {
            if ($connection) {
                if(isset($_SESSION['date']) && $_SESSION['date']) {
                    if (isset($_POST['todo_text']) && isset($_POST['start_time']) && isset($_POST['end_time'])) {
                        $todo_text = $_POST['todo_text'];
                        $date = $_SESSION['date']; //$_POST['date'];
                        $start_time = $_POST['start_time'];
                        $end_time = $_POST['end_time'];
                        if (!$_SESSION[USER_ID] || !$_SESSION[USER_NAME])
                            $response = '<p class="error">To create your own todo list first you need to log in! </p>';
                        else if ($start_time > $end_time)
                            $response = '<p class="error">Start time of a todo cannot be after its end time! </p>';
                        else if ($date < date("Y-m-d", time()))
                            $response = '<p class="error">The date you entered is passed!</p>';
                        else {
                            $owner = $_SESSION[USER_ID];
                            // $query = "INSERT INTO `" . TABLE_USERS . "` (" . USER_NAME . ", " . USER_PASSWORD . ") VALUES ('$todo_text', '$password')";
                            if ($operation['type'] === 'add')
                                $query = sprintf("INSERT INTO `%s` (%s, %s, %s, %s, %s, %s) VALUES ('%s', '%s', '%s', '%s', %d, '%d')", TABLE_TODOS,
                                    TODO_TEXT, TODO_DATE, TODO_START_TIME, TODO_END_TIME, TODO_DONE, TODO_OWNER,
                                    $todo_text, $date, $start_time, $end_time, 0, $owner);
                            else {
                                $todo_id = $operation['todo_id'];
                                $query = sprintf("UPDATE `%s` SET %s='%s', %s='%s', %s='%s', %s='%s' WHERE %s=%d AND %s=%d", TABLE_TODOS,
                                    TODO_TEXT, $todo_text, TODO_DATE, $date, TODO_START_TIME, $start_time, TODO_END_TIME, $end_time, TODO_OWNER, $owner, TODO_ID, $todo_id);
                            }
                            $result = $connection->query($query);
                            if ($result)
                                if ($operation['type'] === 'add')
                                    $response = '<p class="success">Todo Added.</p>';
                                else
                                    $response = '<p class="success">Todo Updated.</p>';
                            else
                                $response = '<p class="error">Unknown error happened!</p>';
                        }
                    } else
                        $response = '<p class="error">Todo fields are not allowed to be empty!</p>';
                }
                else
                    $collecting_response = '<p class="error">Please select your working date!</p>';
            } else {
                $response = '<p class="error">Cannot connect to the database!</p>';
            }
        }
    }
    else
        $response =  '<p class="error">Wrong operation!</p>';
    $_SESSION['response'] = $response;
    unset($_SESSION['operation']);
    header("Location: /");