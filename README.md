# BITPress
This is a Template Tag plugin for WordPress that will connect with BandsInTown (BIT) API.

Current Version: 0.3

<h2>get_ticket_url</h2>

Insert the following on your page to generate a link to purchase tickets using your app_id where you want the href to appear:

<?php get_ticket_url($band, $date, $txt, $alt_url); ?>

- $band: string. Name of the band in quotes (single or double).  Examples: 'Creed' or 'Foo Fighters'
- $date: string. Date of the event in YYYY-MM-DD format in quotes.  Example: '2015-08-20'
- $txt: string (optional). This is the text to be displayed within the hyperlinked portion of the href.  Example: 'tickets' or 'buy tickets'.
- $alt_url: string (optional). In the event that tickets are unavailable, this URL will be used for the href.  Example: 'http://www.seatgeek.com/george+ezra/buy_tickets?AAz284TR'

<h4>Examples:</h4>
Input:
- <?php get_ticket_url("Bronze Radio Return", "2015-10-29", "buy tickets", "http://www.google.com"); ?>
or with <a href="https://wordpress.org/plugins/insert-php/">Insert PHP</a> plugin:
- [insert_php]get_ticket_url("Bronze Radio Return", "2015-10-29", "http://www.google.com");[/insert_php]

Output:
- If tickets are available:
  - <a href="http://www.bandsintown.com/event/10341860?app_id=LOVE_ATL" rel="nofollow">buy tickets</a>
- If tickets are unavailable:
 - Sold out! <a href="http://www.google.com">Check SeatGeek</a></br>

Input:
- <?php get_ticket_url("Bronze Radio Return", "2015-10-29"); ?>
or with <a href="https://wordpress.org/plugins/insert-php/">Insert PHP</a> plugin:
- [insert_php]get_ticket_url("Bronze Radio Return", "2015-10-29");[/insert_php]

Output:
- If tickets are available:
  - <a href="http://www.bandsintown.com/event/10341860?app_id=LOVE_ATL" rel="nofollow">Buy on BandsInTown</a>
- If tickets are unavailable:
 - Sold out! Online resale unavailable

NOTE: you can change the text in the output by adjusting the default Content constants.

<h2>get_tickets_list</h2>

Similar to get_ticket_url, but returns the ticket link, date and venue information in table form for a given event:

<?php get_ticket_list($band, $date, $alt_url);?>
or with <a href="https://wordpress.org/plugins/insert-php/">Insert PHP</a> plugin:
[insert_php]php get_ticket_list($band, $date, $alt_url);[/insert_php]

- $band: string. Name of the band in quotes (single or double).  Examples: 'Creed' or 'Foo Fighters'
- $date: string. Date of the event in YYYY-MM-DD format in quotes.  Example: '2015-08-20'
- $alt_url: string (optional). In the event that tickets are unavailable, this URL will be used for the href.  Example: 'http://www.seatgeek.com/george+ezra/buy_tickets?AAz284TR'

<h4>Examples:</h4>
Input:
- <?php get_ticket_url("Bronze Radio Return", "2015-10-29", "http://www.google.com"); ?>
or with <a href="https://wordpress.org/plugins/insert-php/">Insert PHP</a> plugin:
- [insert_php]get_ticket_url("Bronze Radio Return", "2015-10-29", "http://www.google.com");[/insert_php]

Output:
Bronze Radio Return

Venue	Date                    Tickets
Vinyl	10/29/2015 at 8:30PM	Buy on BandsInTown

<h2>events_by_venue</h2>

Insert the following on our page to generate a list of upcoming events for a given venue:

<?php events_by_venue($venue, $max); ?>
or with <a href="https://wordpress.org/plugins/insert-php/">Insert PHP</a> plugin:
[insert_php]events_by_venue($venue, $max);[/insert_php]

- $venue: string. Name of the venue in quotes (single or double).  Examples: 'Tabernacle', 'Center Stage'
- $max: integer. Default is 'all'. Max number of results to return. Note that results are sorted by date, so limiting to 10 will show the ten most recent.

<h4>Examples</h4>
Input:
- <?php events_by_venue("Tabernacle", 5); ?>;
- [insert_php]events_by_venue("Tabernacle", 5);[/insert_php]

Output:
Artist                          Date                    Tickets
Rey Pila                        08/17/2015 at 8:00PM	Buy on BandsInTown
Rodrigo y Gabriela              09/09/2015 at 7:00PM	Buy on BandsInTown
Three Days Grace                09/15/2015 at 8:00PM	Buy on BandsInTown
Nick Jonas                      09/25/2015 at 8:00PM	Buy on BandsInTown
Charli And Jack Do America	09/29/2015 at 8:00PM	Buy on BandsInTown

<h2>events_by_artist</h2>

Returns a list of upcoming events for one or more artists for a given area.

<?php events_by_artist($artists, $txt, $radius, $city, $state); ?>
or with <a href="https://wordpress.org/plugins/insert-php/">Insert PHP</a> plugin:
[insert_php]events_by_artist($artists, $txt, $city, $state, $radius);[/insert_php]

- $artists: string or array of strings. Enter one or more artists names, separated by a comma. Examples: 'Poison,Of Monsters and Men, imagine dragons'
- $txt: string (optional). This is the text to be displayed within the hyperlinked portion of the href.  Example: 'tickets' or 'buy tickets'
- $radius: integer (optional). Radius in miles from location for search. Max 150. Example: 75
- $city: string (optional). City to center the search. Default is Atlanta. Example: 'Grand Rapids' or 'Charlotte'
- $state: string (optional). Two letter state code. Default is 'GA'. Example: 'IA' or 'NC'

<h4>Examples</h4>
Input:
- <?php events_by_artist('Of Monsters and Men, Bronze Radio Return, Drew Holcomb', 'Buy Tickets', 150); ?>
- [insert_php]events_by_artist('Of Monsters and Men, Bronze Radio Return, Drew Holcomb', 'Buy Tickets', 150);[/insert_php]

<code>

<table><tr><th>Artist</th><th>Date</th><th>Venue</th><th>Tickets</th></tr><tr><td>Drew Holcomb & The Neighbors</td><td>08/27/2015 at 7:00PM</td><td>Peace Center (Greenville)</td><td><a href="http://www.bandsintown.com/event/9858186?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Drew Holcomb & The Neighbors</td><td>08/28/2015 at 7:00PM</td><td>Cottonseed Studios (Opelika)</td><td><a href="http://www.bandsintown.com/event/9911991?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Of Monsters and Men</td><td>10/07/2015 at 7:30PM</td><td>Ryman Auditorium (Nashville)</td><td><a href="http://www.bandsintown.com/event/9953381?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Of Monsters and Men</td><td>10/09/2015 at 8:00PM</td><td>Chastain Park Amphitheatre (Atlanta)</td><td><a href="http://www.bandsintown.com/event/10223003?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Bronze Radio Return</td><td>10/23/2015 at 7:00PM</td><td>The Camp House (Chattanooga)</td><td><a href="http://www.bandsintown.com/event/10341856?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Bronze Radio Return</td><td>10/24/2015 at 6:00PM</td><td>Deep Roots Festival (Milledgeville)</td><td><a href="http://www.bandsintown.com/event/10197971?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Bronze Radio Return</td><td>10/29/2015 at 8:30PM</td><td>Vinyl (Atlanta)</td><td><a href="http://www.bandsintown.com/event/10341860?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Bronze Radio Return</td><td>11/01/2015 at 7:00PM</td><td>The Grey Eagle (Asheville)</td><td><a href="http://www.bandsintown.com/event/10341863?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Drew Holcomb & The Neighbors</td><td>11/12/2015 at 7:00PM</td><td>Track 29 (Chattanooga)</td><td><a href="http://www.bandsintown.com/event/9845755?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Drew Holcomb & The Neighbors</td><td>11/14/2015 at 7:00PM</td><td>Buckhead Theatre (Atlanta)</td><td><a href="http://www.bandsintown.com/event/9904552?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr><tr><td>Drew Holcomb & The Neighbors</td><td>12/23/2015 at 7:30PM</td><td>Schermerhorn Symphony Center (Nashville)</td><td><a href="http://www.bandsintown.com/event/10482121?app_id=LOVE_ATL" rel="nofollow">Buy Tickets</a></td></tr></table>
</code>

<h2>Version Changes</h2>

<h3>Version 0.3</h3>
- Added get_ticket_list function. Returns a single event in list format.
- Added $txt parameter to get_ticket_url function.  Allows user to specify the text contained within the hyperlink.
- Added events_by_artist. Returns a list of events for a given area for one or more artists.
- Temporarily disabled availability check for tickets. Does not represent what we thought it did.

<h3>Version 0.2</h3>
- All links to ticket purchases (to include alternate sites) no includes rel="nofollow" option.
- Added optional $max parameter to limit number of returned events for a given venue. The default will return all events. Passing a value of 0 will return all events.