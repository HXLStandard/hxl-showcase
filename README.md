The Blue Monster is a prototype application for importing, managing,
and exporting data encoded according to the Humanitarian Exchange
Language (HXL). All code is in the Public Domain.

## Installation

1. Enable Apache2, PHP5, PostgreSQL, and the PHP PDO PostgreSQL driver
   on your system, and enable PHP support in Apache.
2. Clone the Blue Monster code from GitHub into your web directory of
   choice (e.g. /srv/www/blue/).
3. Create the directory views/templates_c within the Blue Monster
   distro, and ensure that its permissions allow the web server user
   to write to it (e.g. 1777).
4. Enable the php5 and rewrite modules in Apache2.
5. (Optional) set up an Apache VHOST pointing to the www/ directory
   inside the Blue Monster distribution.
6. Create a new PostgreSQL user (e.g. "blue").
7. Create a new PostgreSQL database (e.g. "blue"), and grant the
   "blue" user access to it.
8. Copy config/SAMPLE.database.php to config/database.php and fill in
   your database connection information.
9. Assuming that your current Ubuntu user has access to the blue
   database, change into database/ and run the setup-sample-db.sh
   shell script to set up a BlueMonster database.

Started by David Megginson, UN OCHA, 2014-07-03
