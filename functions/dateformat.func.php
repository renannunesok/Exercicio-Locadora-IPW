<?php
//entrada: 22/10/2010
//saida: 2010-10-22
function trataData($date) {
    $newdate = explode('/', $date);
    $newdate = $newdate[2] . "-" .$newdate[1] . "-" . $newdate[0];
    return $newdate;
}

//entrada: 2010-10-22 12:32:47
//saida: 22/10/2010 as 12:32:47
function trataData2($date) {
    $newdate = explode(' ', $date);
    $newdate1 = explode('-', $newdate[0]);
    $newdate2 = $newdate1[2] . "/" . $newdate1[1] . "/" . $newdate1[0] . " as " . $newdate[1];
    return $newdate2;
}

//entrada: 2010-10-22 12:32:47
//saida: 22/10/2010
function trataData3($date) {
    $newdate = explode(' ', $date);
    $newdate1 = explode('-', $newdate[0]);
    $newdate2 = $newdate1[2] . "/" . $newdate1[1] . "/" . $newdate1[0];
    return $newdate2;
}

//entrada: 22/10/2010 12:32:47
//saida:  2010-10-22 00:00:00
function trataData4($date) {
    $newdate = explode('/', $date);
    $newdate = $newdate[2] . "-" . $newdate[1] . "-" . $newdate[0] . " 00:00:00";
    return $newdate;
}

//entrada: 2010-10-22 12:32:47
//saida:  22/10/2010 12:32:47
function trataData5($date) {
    $timestamp = explode(' ', $date);
    $date = $timestamp[0];
    $hour = $timestamp[1];
    $dateformat = explode('-', $date);
    $newdate = $dateformat[2] . '/' . $dateformat[1] . '/' . $dateformat[0] . ' ' . $hour;
    return $newdate;
}

//entrada: 22/10/2010 12:32PM
//saida: 2010-10-22 12:32:00
function trataData6($date) {
    $pm = 'PM';
    $pos = strpos($date, $pm);
    if ($pos === false) {
        $multi = 1;
    } else {
        $multi = 2;
    }
    $date = str_replace('PM', ':00', $date);
    $date = str_replace('AM', ':00', $date);
    $date1 = explode(' ', $date);
    $date2 = explode('/', $date1[0]);
    $hour = explode(':', $date1[1]);
    $hora = ($hour[0] + $multi);
    if ($hora == 24)
        $hora = 12;
    if ($multi == 0 && $hora == 12)
        $hora == '00';
    $newDate = $date2[2] . '-' . $date2[1] . '-' . $date2[0] . ' ' . $hora . ':' . $hour[1] . ':' . $hour[2];
    return $newDate;
}
?>
