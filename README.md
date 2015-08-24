# BITPress
This is a Template Tag plugin for WordPress that will connect with BandsInTown (BIT) API.

<h2>Ticket URL:</h2>

Insert the following on your page to generate a link to purchase tickets using your app_id where you want the href to appear:

<?php get_ticket_url($band, $date, $alt_url); ?>

- $band: Name of the band in quotes (single or double).  Examples: 'Creed' or 'Foo Fighters'.
- $date: Date of the event in YYYY-MM-DD format.  Example: '2015-08-20'
- $alt_url: (Optional) In the event that tickets are unavailable, this URL will be used for the href.  Example: 'http://www.seatgeek.com/george+ezra/buy_tickets?AAz284TR'

<h4>Examples:</h4>
Input:
- <?php get_ticket_url("Bronze Radio Return", "2015-10-29", "http://www.google.com"); ?>

Output:
- If tickets are available:
  - <a href="http://www.bandsintown.com/event/10341860/buy_tickets?app_id=LOVE_ATL&came_from=233">Buy on BandsInTown</a>
- If tickets are unavailable:
 - Sold out! <a href="http://www.google.com">Check SeatGeek</a></br>

Input:
- <?php get_ticket_url("Bronze Radio Return", "2015-10-29", "LOVE_ATL"); ?>

Output:
- If tickets are available:
  - <a href="http://www.bandsintown.com/event/10341860/buy_tickets?app_id=LOVE_ATL&came_from=233">Buy on BandsInTown</a>
- If tickets are unavailable:
 - Sold out! Online resale unavailable

NOTE: you can change the text in the output by adjusting the default Content constants.

<h2>Events by Venue</h2>

Insert the following on our page to generate a list of upcoming events for a given venue:

<?php events_by_venue($venue, $max); ?>

or

[insert_php]events_by_venue($venue, $max);[/insert_php]

- $venue: string.  Name of the venue in quotes (single or double).  Examples: 'Tabernacle', 'Center Stage'
- $max: integer. Max number of results to return. Note that results are sorted by date, so limiting to 10 will show the ten most recent.

<h4>Examples</h4>
Input:
- <?php events_by_venue("Tabernacle", 5); ?>

Output:
Artist                          Date                    Tickets
Rey Pila                        08/17/2015 at 8:00PM	Buy on BandsInTown
Rodrigo y Gabriela              09/09/2015 at 7:00PM	Buy on BandsInTown
Three Days Grace                09/15/2015 at 8:00PM	Buy on BandsInTown
Nick Jonas:                     09/25/2015 at 8:00PM	Buy on BandsInTown
Charli And Jack Do America	09/29/2015 at 8:00PM	Buy on BandsInTown


<h2>Search Venues</h2>
Documentation to be added

<h2>Print List</h2>
Documentation to be added