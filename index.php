<?php
    session_start();
    require_once 'common/config.php';
    $request = $_SERVER['REQUEST_URI'];

    switch($request){
        case '/':
        case '':
            require __DIR__ . '/todo/index.php';
            break;
        case '/register':
            require __DIR__ . '/user/register-form.php';
            break;
        case '/login':
            require __DIR__ . '/user/login-form.php';
            break;
        case '/logout':
            unset($_SESSION[USER_ID]);
            unset($_SESSION[USER_NAME]);
            unset($_SESSION['date']);
            header("Location: /login");
            break;
        default:
            $route = explode("?", $request)[0];
            if($route === '/')
                require_once 'todo/index.php';
            else if($route === '/done'){
                $todo_id = get_url_param($request, "todo");
                $userid = $_SESSION[USER_ID];
                if(!$userid){
                    $_SESSION['response'] = '<p class="error">You need to log in first!</p>';
                }
                else if(!$connection){
                    $_SESSION['response'] = '<p class="error">Cannot connect to the database!</p>';
                }
                else {
                    $query = sprintf("UPDATE `%s` SET %s=1 WHERE %s=%d AND %s=%d", TABLE_TODOS, TODO_DONE, TODO_OWNER, $userid, TODO_ID, $todo_id);
                    $result = $connection->query($query);
                    if(!$result)
                        $_SESSION['response'] = '<p class="error">Something unknown went wrong!</p>';
                    else
                        $_SESSION['response'] = '<p class="success">Selected todo marked as done successfully</p>';
                }
                header("Location: /");
            }
            else {
                http_response_code(404);
                require __DIR__ . '/404.php';
            }
            break;
    }
