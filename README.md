# BITPress
This is a Template Tag plugin for WordPress that will connect with BandsInTown (BIT) API.

<h2>Ticket URL:</h2>

Insert the following on your page to generate a link to purchase tickets using your app_id where you want the href to appear:

<?php get_ticket_url($band, $date, $id, $alt_url); ?>

- $band: Name of the band.  Examples: 'Creed' or 'Foo Fighters'.
- $date: Date of the event in YYYY-MM-DD format.  Example: '2015-08-20'
- $id: Your app_id that you received from BIT.  Example: 'LOVE_ATL'
- $alt_url: (Optional) In the event that tickets are unavailable, this URL will be used for the href.  Example: 'http://www.seatgeek.com/george+ezra/buy_tickets?AAz284TR'

<h4>Examples:</h4>
Input:
- <?php get_ticket_url("Bronze Radio Return", "2015-10-29", "LOVE_ATL", "http://www.google.com"); ?>

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

<h2>Search Venues</h2>
Documentation to be added

<h2>Print List</h2>
Documenation to be added