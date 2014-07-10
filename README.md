The Blue Monster is a prototype application for importing, managing,
and exporting data encoded according to the Humanitarian Exchange
Language (HXL). All code is in the Public Domain.

## Installation

1. Enable Apache2, PHP5, PostgreSQL, and the PHP PDO PostgreSQL driver
   on your system, and enable PHP support in Apache.
2. Clone the Blue Monster code from GitHub into your web directory of
   choice (e.g. /srv/www/blue/).
3. (Optional) set up an Apache VHOST pointing to the www/ directory
   inside the Blue Monster distribution.
4. Create a new PostgreSQL user (e.g. "blue").
5. Create a new PostgreSQL database (e.g. "blue"), and grant the
   "blue" user access to it.
6. Copy config/SAMPLE.database.php to config/database.php and fill in
   your database connection information.
7. Assuming that your current Ubuntu user has access to the blue
   database, change into database/ and run the setup-sample-db.sh
   shell script to set up a BlueMonster database.

Started by David Megginson, UN OCHA, 2014-07-03
