<?php
require_once __DIR__ . '/../config.php';
session_start();
$res = null;
if(isset($_POST['submit_date'])){
    if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])){
        $year = $_POST['year'];
        $month = $_POST['month'];
        $day = $_POST['day'];
        if(checkdate($month, $day, $year)){
            $_SESSION['date'] = "$year-$month-$day";
        }
        else
            $res = '<p class="error">Your selected date is not a valid date!</p>';
    }
    else
        $res = '<p class="error">Year, month and day are\'nt allowed to be empty!</p>';

    $_SESSION['submit_date_response'] = $res;

    redirect2('/');
}