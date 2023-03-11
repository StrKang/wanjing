<?php

$time = date('Y-m-d H:i:s');
if (!is_numeric($time)) $time = strtotime($time);

$n = date('j', $time); // 本月第n天

$last_month_first_day = strtotime(date('Y-m', ($time - 3600*24*date('j', $time)))); // 上月第1天

$last_month_total_days = date('t', $last_month_first_day); // 上月有几天

if ($n > $last_month_total_days) {
    var_dump(date('Y-m-d H:i:s', $last_month_first_day + ($last_month_total_days-1)*24*3600));
} else {
    var_dump(date('Y-m-d H:i:s', $last_month_first_day + ($n-1)*24*3600));
}
var_dump(date('Y-m-d H:i:s', strtotime('2023-04-30 -1 month')));