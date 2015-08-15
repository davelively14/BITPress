<?php

/* 
 * Plugin Name: BITPress
 * Plugin URI: https://github.com/davelively14/BITPress
 * Description: This is a Template Tag plugin for WordPress that will connect with BandsInTown (BIT) API.
 * Version: 0.1
 * Author: Dave Lively
 */

// DISPLAY TEXT
// Change these constants to adjust what is displayed in the returned HTML code.
// 
// sets the text to be hyperlinked when buying a ticket from BandsInTown.
define('BUY_TICKET_STR', 'Buy on BandsInTown');
// sets the text that notifies user event is sold out and not available on reseller site.
define('SOLD_OUT_NO_LINK_STR', 'Sold out! No online resale available.');
// sets the non-hyperlinked text notifying unavailable tickets.
define('SOLD_OUT_STR', 'Sold out!');
// sold_out_link_to_str is hyperlinked text for alternate purchasing method.
define('SOLD_OUT_HYPER_STR', 'Try SeatGeek');

// DEFAULTS
// These constants set defaults for
// 
// sets the default city for venue search
define('DEFAULT_CITY_STR', 'Atlanta');
// sets the default state for venue search
define('DEFAULT_STATE_STR', 'GA');
// sets default id
define('DEFAULT_ID_STR', 'LOVE_ATL');

function get_event($band, $date, $id = DEFAULT_ID_STR) {
    $band = urlencode($band);
    $raw_json = file_get_contents("http://api.bandsintown.com/events/search.json?artists[]=".$band."&date=".$date."&app_id=".$id);
    
    //echo $raw_json;
    //echo "</br></br>";
    
    return json_decode($raw_json, true);
}

function get_venues($city = DEFAULT_CITY_STR, $state = DEFAULT_STATE_STR) {
    
}

function get_ticket_url($band, $date, $alt_url = NULL, $id = DEFAULT_ID_STR) {
    $event = get_event($band, $date, $id);
    
    //echo $event[0]['ticket_status'];
    //echo '</br>';
    
    if ($event[0]['ticket_status'] == 'available') {
        return '<a href="'.$event[0]['url'].'">'.BUY_TICKET_STR.'</a>';
    } elseif ($alt_url == NULL) {
        return SOLD_OUT_NO_LINK_STR;
    } else {
        return SOLD_OUT_STR.' <a href="'.$alt_url.'">'.SOLD_OUT_HYPER_STR.'</a>';
    }
    
}

echo get_ticket_url("Bronze Radio Return", "2015-10-29", "http://www.google.com");
echo "</br>";
echo get_ticket_url("Eli Young Band", "2015-08-14");

?>