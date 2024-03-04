<?php
date_default_timezone_set('UTC');
// formats a date like so
// Fri, Nov 12:00 AM
function getDateElem(String $date):array {
    $class = "";

    $date = date_format(date_create($date), "D, M d, g:i A");
    $curDate = date('Y/m/d H:i');

   $dateMil = strtotime($date);
   $curDateMil = strtotime($curDate);
   $timeDifHour = ($dateMil - $curDateMil) / 60 / 60;
    // date is upcoming

    if($timeDifHour > 0) {
        // check if task needs to be done within 24 hours
        if($timeDifHour < 24) {
            $class = 'date-today';
            // doesn't need to be done within 24 hours
        } else {
            $class = 'date-upcoming';
        }
    } else {
        $class = "date-passed";
    }
    return ["<div class = $class>
                <p>
                $date
                </p>
            </div>", $class];

}

// returns a colored circle (red/yellow/green) with state (past due, upcoming, today)
// based on the given time string (date-passed, date-upcoming, date-today)
function getTimeStateElem(String $timeState):String {
    // text to be returned
    $text = "";
    $circleClass = "";
    // set output text based on given one
    switch ($timeState) {
        case "date-passed":
            $text = "Past due";
            $circleClass = 'circle-red';
            break;

        case "date-upcoming":
            $text = "Upcoming";
            $circleClass = 'circle-yellow';
            break;

        case "date-today":
            $text = "Today";
            $circleClass = 'circle-green';
            break;
        default:
            break;
}
    return "<div class ='flex align-center time-state'>
            <div class='$circleClass mar-right-8'></div>
            <h5 class = ''>$text</h5>
    </div>";
}