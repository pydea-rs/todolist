<?php require_once __DIR__ . "/../config.php"; ?>
<form action="/todo/set_working_date.php" method="post" onsubmit="saveWorkingDate()">
    <?php
        session_start();
        if(isset($_SESSION['submit_date_response'])){
            echo $_SESSION['submit_date_response'];
            unset($_SESSION['submit_date_response']);
        }
    ?>
    <input class="date-input" id="year" name="year" min="1970" type="number" placeholder="Year" required="required" />
    <select class="date-input" style="width: 110px" onchange="updateDays()" name="month" id="month" required="required">
    </select>
    <select class="date-input" name="day" style="width: 55px" id="day" required="required">
    </select>
    <br > <br >
    <button type="submit" class="button-submit" style="width: 110px; font-size: 18px" name="submit_date" id="btnSubmitDate">Go To</button>
</form>

<script>
    const txtYear = document.getElementById('year'),
        selectMonth = document.getElementById('month'),
        selectDay = document.getElementById('day');

    const calendar = [{month: 'January', days: 31}, {month: 'February', days: 28}, {month: 'March', days: 31}, {month: 'April', days: 30},
        {month: 'May', days: 31}, {month: 'June', days: 30}, {month: 'July', days: 31}, {month: 'August', days: 31},
        {month: 'September', days: 30}, {month: 'October', days: 31}, {month: 'November', days: 30}, {month: 'December', days: 31}];

    function updateDays() {
        const month = selectMonth.options.selectedIndex;
        if(month >= 0 && month <= 12)
            for(let  i = 1; i <= calendar[month].days; i++)
                selectDay.options[selectDay.options.length] = new Option(i.toString(), i.toString());
    }

    function saveWorkingDate() {
        const year = txtYear.value, month = selectMonth.options.selectedIndex + 1, day = selectDay.options.selectedIndex + 1;
        const date = {year, month, day};
        localStorage.setItem("date", JSON.stringify(date));
    }

    const $ = document.getElementById;
    window.addEventListener('load', () => {
        for(let  i = 0; i < calendar.length; i++)
            selectMonth.options[selectMonth.options.length] = new Option(calendar[i].month, (i + 1).toString());

        const today = new Date();
        const date = JSON.parse(localStorage.getItem("date"));
        if(date){
            txtYear.value = date.year;
            selectMonth.options[date.month - 1].setAttribute("selected", "selected");
            updateDays();
            selectDay.options[date.day - 1].setAttribute("selected", "selected");
        }
        else{
            const year = today.getFullYear(), month = today.getMonth(), day = today.getDay();
            txtYear.value = year.toString();
            selectMonth.options[month].setAttribute("selected", "selected");
            updateDays();
        }

    })
</script>
