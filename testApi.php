<?php
include_once "dynamoDbFunctions.php";

 //$eventArray = fetchEventsForPostAndUser(false, "USER_ID_2", "2021-04-11 23:00:00");
 //error_log(print_r($eventArray, true));

// $screenAnalytics = fetchScreenResolutionEventAnalytics();
// error_log(print_r($screenAnalytics, true));

// $scrollEventAnalytics = fetchScrollTimespentEventAnalytics(2503, true);
// error_log(print_r($scrollEventAnalytics, true));

error_log(print_r(lastDayEventAnalytics(), true));
//error_log(print_r(fetchAllUserDetails(), true));

//error_log(print_r(fetchAllBrowserNames(), true));
?>
