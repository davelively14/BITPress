<?php

/*
 * Plugin Name: BITPress
 * Plugin URI: https://github.com/davelively14/BITPress
 * Description: This is a template tag plugin for WordPress that will connect with BandsInTown (BIT) API.
 * Version: 0.3
 * Author: Dave Lively
 */

// CONTENT
// Change these constants to adjust the content to be displayed in the returned
// HTML code for given functions.
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
// These constants set defaults for many of the functions.
//
// sets the default city for venue searches
define('DEFAULT_CITY_STR', 'Atlanta');
// sets the default state for venue search
define('DEFAULT_STATE_STR', 'GA');
// sets default id to be associated with all queries.
define('DEFAULT_ID_STR', 'LOVE_ATL');
// sets default radius for all searches
define('DEFAULT_RADIUS_INT', 25);

// SYSTEM CONSTANTS
// Don't change these. These are BandsInTown API specific
//
// sets the base URI for calls to the API to return events
define('URL_EVENTS_STR', 'http://api.bandsintown.com/events/');
// sets the base URI for calls to the API to return venues
define('URL_VENUES_STR', 'http://api.bandsintown.com/venues/');
// sets to search and return JSON
define('OPT_SEARCH_STR', 'search.json?');
// sets to return events in JSON format
define('OPT_EVENTS_STR', 'events.json?');
// sets return type
define('JSON_FORMAT_STR', '&format=json');
// URI call to set the ID of partner
define('ID_QUERY_STR', '&app_id=');

function get_event($band, $date) {
    $band = urlencode($band);
    $raw_json = file_get_contents(URL_EVENTS_STR.OPT_SEARCH_STR."artists[]=".$band."&date=".$date.ID_QUERY_STR.DEFAULT_ID_STR);
    return json_decode($raw_json, true);
}

function clean_datetime($datetime) {
    $d = str_split($datetime);
    $year = $d[0].$d[1].$d[2].$d[3];
    $month = $d[5].$d[6];
    $day = $d[8].$d[9];
    $hour = $d[11].$d[12];
    $min = $d[14].$d[15];

    if ($hour > 12) {
        $hour = $hour - 12;
        $apm = 'PM';
    } else {
        $apm = 'AM';
    }

    return $month.'/'.$day.'/'.$year.' at '.$hour.':'.$min.$apm;
}

function search_venues($keyword, $city = DEFAULT_CITY_STR, $state = DEFAULT_STATE_STR, $radius = DEFAULT_RADIUS_INT) {
    $keyword = urlencode($keyword);
    $city = urlencode($city);

    $raw_json = file_get_contents(URL_VENUES_STR.OPT_SEARCH_STR."query=".$keyword.'&location='.$city.','.$state.ID_QUERY_STR.DEFAULT_ID_STR);
    return json_decode($raw_json, true);
}

function get_ticket_url($band, $date, $txt = BUY_TICKET_STR, $alt_url = NULL) {
    $event = get_event($band, $date);
    echo '<a href="'.$event[0][url].'" rel="nofollow">'.$txt.'</a>';
    // Temporarily disabled availability check
    /*if ($event[0]['ticket_status'] == 'available') {
        echo '<a href="'.$event[0][url].'" rel="nofollow">'.$txt.'</a>';
    } elseif ($alt_url == NULL) {
        echo SOLD_OUT_NO_LINK_STR;
    } else {
        echo SOLD_OUT_STR.' <a href="'.$alt_url.'" rel="nofollow">'.SOLD_OUT_HYPER_STR.'</a>';
    }*/

}

function get_ticket_list($band, $date, $txt = BUY_TICKET_STR, $alt_url = NULL) {
    $event = get_event($band, $date);

    if (sizeof($event) > 0) {
        $code = '<table><tr><th>Venue</th><th>Date</th><th>Tickets</th></tr><tr><td>'.$event[0][venue][name].'</td><td>'.clean_datetime($event[0][datetime]).'</td><td>';
        $code = $code.'<a href="'.$event[0][url].'" rel="nofollow">'.$txt.'</a>';

        // Availability check temporarily disabled
        /*if ($event[0]['ticket_status'] == 'available') {
            $code = $code.'<a href="'.$event[0][url].'" rel="nofollow">'.BUY_TICKET_STR.'</a>';
        } elseif ($alt_url == NULL) {
            $code = $code.SOLD_OUT_NO_LINK_STR;
        } else {
            $code = $code.SOLD_OUT_STR.' <a href="'.$alt_url.'" rel="nofollow">'.SOLD_OUT_HYPER_STR.'</a>';
        }*/

        $code = $code.'</td></table>';

        echo $code;
    } else {
        echo "No event found";
    }

}

function print_list($array) {
    $code = '<table><tr>';

    foreach (array_keys($array[0]) as $item) {
        $code = $code.'<th>'.ucfirst($item).'</th>';
    }

    $code = $code.'</tr>';

    foreach ($array as $outer) {
        $code = $code.'<tr>';
        foreach ($outer as $inner) {

            if (filter_var($inner, FILTER_VALIDATE_URL)) {
                $code = $code.'<td><a href="'.$inner.'">Link</td>';
            } elseif(is_array($inner)) {
                if (key($inner) == 'artists' || key($inner) == 'venue') {
                    $code = $code.'<td><a href="'.$inner[0][url].'">'.$inner[0][name].'</a></td>';
                } elseif (key($inner) == 'venue') {
                    $code = $code.'<td><a href="'.$inner[url].'">'.$inner[name].'</a></td>';
                } else {
                    $code = $code.'<td>'.'array'.'</td>';
                }

            } else {
                $code = $code.'<td>'.$inner.'</td>';
            }

        }
        $code = $code.'</tr>';
    }

    $code = $code.'</table>';
    echo $code;
}

// Returns standard list of events
function list_events_code($events, $txt, $venues = false) {
    $code = '<table><tr><th>Artist</th><th>Date</th>';
    if ($venues) {
        $code = $code.'<th>Venue</th>';
    }
    $code = $code.'<th>Tickets</th></tr>';
    foreach ($events as $event) {
        $code = $code.'<tr><td>'.$event[artists][0][name].'</td><td>'.clean_datetime($event[datetime]).'</td>';
        if ($venues) {
            $code = $code.'<td>'.$event[venue][name].' ('.$event[venue][city].')</td>';
        }
        $code = $code.'<td>';
        $code = $code.'<a href="'.$event[url].'" rel="nofollow">'.$txt.'</a></td>';
        /*if ($event[ticket_status] == 'available') {
            $code = $code.'<a href="'.$event[url].'" rel="nofollow">'.$txt.'</a></td>';
        // TODO: build in SeatGeek functionality, create default links.
        } else {
            $code = $code.SOLD_OUT_NO_LINK_STR.'</td>';
        }*/
        $code = $code.'</tr>';
    }
    $code = $code.'</table>';

    return $code;
}

// function events_by_venue($keyword, $max = 0, $txt = BUY_TICKET_STR) {
//     $venues = search_venues($keyword);
//
//     if (sizeof($venues) > 0) {
//         $raw_json = file_get_contents(URL_VENUES_STR.$venues[0][id]."/".OPT_EVENTS_STR."app_id=".DEFAULT_ID_STR);
//         $events = json_decode($raw_json, true);
//
//         if (sizeof($venues) > 1) {
//             foreach ($venues as $venue) {
//                 $raw_json = file_get_contents(URL_VENUES_STR.$venue[id]."/".OPT_EVENTS_STR."app_id=".DEFAULT_ID_STR);
//                 array_merge($events, json_decode($raw_json, true));
//             }
//         }
//
//     } else {
//         echo "Could not find venue";
//         return;
//     }
//
//     // If $max is default zero, all events in BIT for that venue will be listed. If $max is a number, this will ensure
//     // that no more than the $max number of events are returned
//     if (sizeof($events) > $max and $max != 0) {
//         $events = array_splice($events, 0, $max);
//     }
//
//
//     echo list_events_code($events, $txt);
//
// }

function events_rec($artists, $city = DEFAULT_CITY_STR, $state = DEFAULT_STATE_STR, $radius = DEFAULT_RADIUS_INT) {
  $artists = explode(',', $artists);

  $fetch_url = URL_EVENTS_STR.'recommended?';
  foreach ($artists as $artist ) {
    $fetch_url = $fetch_url.'artists[]='.urlencode(trim($artist)).'&';
  }

  $fetch_url = $fetch_url.'location='.urlencode($city).','.$state.'&radius='.$radius.JSON_FORMAT_STR.ID_QUERY_STR.DEFAULT_ID_STR;

  $raw_json = file_get_contents($fetch_url);
  $events = json_decode($raw_json, true);

  echo list_events_code($events, BUY_TICKET_STR, true);

}

function events_by_artist($artists, $txt = BUY_TICKET_STR, $radius = DEFAULT_RADIUS_INT, $city = DEFAULT_CITY_STR, $state = DEFAULT_STATE_STR) {
    $artists = explode(',', $artists);

    $fetch_url = URL_EVENTS_STR.OPT_SEARCH_STR;

    foreach ($artists as $artist) {
        $artist = trim($artist);
        $artist = urlencode($artist);
        $fetch_url = $fetch_url.'artists[]='.$artist.'&';
    }

    $fetch_url = $fetch_url.'location='.urlencode($city).','.$state.'&radius='.$radius.ID_QUERY_STR.DEFAULT_ID_STR;

    $raw_json = file_get_contents($fetch_url);
    $events = json_decode($raw_json, true);

    echo list_events_code($events, $txt, true);
}

/*echo 'Get your Bronze Radio Return ';
get_ticket_url("Bronze Radio Return", "2015-10-29", "tickets", "http://www.google.com");
echo ' before they sell out!';
echo '</br>';
get_ticket_url("Bronze Radio Return", "2015-10-29");
get_ticket_list("Bronze Radio Return", "2015-10-29", "Buy Tix");
events_by_artist('Of Monsters and Men, Bronze Radio Return, Drew Holcomb', 'Buy Tickets', 150);*/

events_rec('Young the Giant, Lumineers');

?>
