#!/bin/sh
########################################################################
# Update just the Ebola-related data from the Standby Task Force
########################################################################

echo "Guinea health facilities ..."
php scripts/import-data.php dpm sbtf sbtf-gin-health < sample-data/sbtf-gin-health.csv

echo "Liberia health facilities ..."
php scripts/import-data.php dpm sbtf sbtf-lbr-health < sample-data/sbtf-lbr-health.csv

echo "Sierra Leone health facilities ..."
php scripts/import-data.php dpm sbtf sbtf-sle-health < sample-data/sbtf-sle-health.csv

echo "Movement restrictions ..."
php scripts/import-data.php dpm brc brc-westafrica-movement < sample-data/brc-westafrica-movement.csv

echo "Guinea prefectures ..."
php scripts/import-data.php dpm rowca rowca-gin-adm2 < sample-data/rowca-gin-adm2.csv

exit 0

# end