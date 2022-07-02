<?php
    require_once 'common/config.php';
    $url = $_SERVER['REQUEST_URI'];
    $show_completed_todos = get_url_param($url, 'completed') ? 1 : 0;
    if(isset($_SESSION['date']) && $_SESSION['date'])
        echo "<h3>Working Date: " . $_SESSION['date'] . "</h3>";
    if(!$show_completed_todos)
        echo "<h1>" . $_SESSION[USER_NAME] . "'s Todos: </h1>";
    else
        echo "<h1>" . $_SESSION[USER_NAME] . "'s Completed Todos: </h1>";
?>

<table id="tableTodos" class="table-todos">
    <tr>
        <th></th>
        <th>Todo</th>
        <th>Start</th>
        <th>End</th>
    </tr>
    <?php
        $collecting_response = '';
        if($connection) {
            if ($_SESSION[USER_ID] && $_SESSION[USER_NAME]) {
                if(isset($_SESSION['date']) && $_SESSION['date']) {
                    $userid = $_SESSION[USER_ID];
                    $date = $_SESSION[TODO_DATE];
                    $query = sprintf("SELECT * FROM `%s` WHERE %s=%d AND %s=%d AND %s='%s'",
                        TABLE_TODOS, TODO_OWNER, $userid, TODO_DONE, $show_completed_todos, TODO_DATE, $date);
                    $result = $connection->query($query);
                    if (!$result->num_rows)
                        if (!$show_completed_todos)
                            echo "<tr class='todo-item'><td colspan='5'>Nothing left to do...</td></tr> ";
                        else
                            echo "<tr class='todo-item'><td colspan='5'>Nothing done yet...</td></tr> ";
                    else {
                        for ($i = 0; $i < $result->num_rows; $i++) {
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            $text = $row[TODO_TEXT];
                            $start_time = $row[TODO_START_TIME];
                            $end_time = $row[TODO_END_TIME];
                            $id = $row[TODO_ID];
                            $tmp = explode(':', $end_time);

                            echo <<<_END
                            <tr class="todo-item">
                                <td><a type="button" class="edit-button" href="/?todo=$id">Edit</a></td>
                                <td style="word-break: break-word">$text</td>
                                <td>$start_time</td>
                                <td>$end_time</td>
                            _END;
                            if (!$show_completed_todos)
                                echo <<<_END
                                    <td><a type="button" class="done-button" href="/done?todo=$id">Done</a></td>
                            _END;
                            echo '<tr>';
                        }
                    }
                }
                else
                    $collecting_response = '<p class="error">Please select your working date!</p>';

            }
            else
                $collecting_response = '<p class="error">Please log in first!</p>';
        }
        else
            $collecting_response = '<p class="error">Cannot connect to the database!</p>';
    ?>
</table>