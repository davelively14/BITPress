<?php

/* 
 * Plugin Name: BITPress
 */

function get_event($band, $date, $id) {
    $band = urlencode($band);
    $raw_json = file_get_contents("http://api.bandsintown.com/events/search.json?artists[]=".$band."&date=".$date."&app_id=".$id);
    
    echo $raw_json;
    echo "</br></br>";
    
    return json_decode($raw_json, true);
}

function get_ticket_url($band, $date, $id, $alt_url = NIL) {
    $event = get_event($band, $date, $id);
    
    echo $event[0]['ticket_status'];
    echo '</br>';
    
    if ($event[0]['ticket_status'] == 'available') {
        return '<a href="'.$event[0]['ticket_url'].'">Buy on BandsInTown</a>';
    } elseif ($alt_url == NIL) {
        return 'Sold out! Online resale unavailable';
    } else {
        return 'Sold out! <a href="'.$alt_url.'">Check SeatGeek</a>';
    }
    
}

echo get_ticket_url("Bronze Radio Return", "2015-10-29", "LOVE_ATL", "http://www.google.com");
echo "</br>";
echo get_ticket_url("Eli Young Band", "2015-08-14", "LOVE_ATL")

?>