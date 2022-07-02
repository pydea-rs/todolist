<?php
    defined('DB_HOST') or define('DB_HOST', '127.0.0.1');
    defined('DB_USERNAME') or define('DB_USERNAME', 'root');
    defined('DB_PASSWORD') or define('DB_PASSWORD', '');
    defined('DB_NAME') or define('DB_NAME','dbtodo');

    defined('TABLE_USERS') or define('TABLE_USERS', 'users');
    defined('USER_ID') or define('USER_ID', 'id');
    defined('USER_NAME') or define('USER_NAME', 'username');
    defined('USER_PASSWORD') or define('USER_PASSWORD', 'password');

    defined('TABLE_TODOS') or define('TABLE_TODOS', 'todos');
    defined('TODO_ID') or define('TODO_ID', 'id');
    defined('TODO_OWNER') or define('TODO_OWNER', 'owner');
    defined('TODO_TEXT') or define('TODO_TEXT', 'text');
    defined('TODO_DATE') or define('TODO_DATE', 'date');
    defined('TODO_START_TIME') or define('TODO_START_TIME', 'start_time');
    defined('TODO_END_TIME') or define('TODO_END_TIME', 'end_time');
    defined('TODO_DONE') or define('TODO_DONE', 'done');


    function get_url_param($url, $expected_param = 'todo'){
        $url_components = parse_url($url);
        if(array_key_exists("query", $url_components)) {
            parse_str($url_components['query'], $params);
            if (array_key_exists($expected_param, $params))
                return $params[$expected_param];
        }
        return null;
    }

    try {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }
    catch(Exception $ex){
        echo 'Cannot connect to the database because: ' . $ex ;
        $connection = null;
    }