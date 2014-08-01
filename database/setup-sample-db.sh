#!/bin/sh

sh init-db.sh

php ../scripts/import-tags.php < ../hxl-tags.csv

php ../scripts/add-usr.php dpm 'David Megginson'

php ../scripts/add-source.php rowca 'OCHA Regional Office for West and Central Africa (ROWCA)'
php ../scripts/add-dataset.php rowca rowca-3w 'ROWCA 3W, June 2014'
php ../scripts/import-data.php dpm rowca rowca-3w < ../sample-data/rowca-3w-hxl.csv

php ../scripts/add-source.php iom 'International Organization for Migration (IOM)'
php ../scripts/add-dataset.php iom haiti-dtm 'IOM Haiti DTM, June 2013'
php ../scripts/import-data.php dpm iom haiti-dtm < ../sample-data/iom-haiti-dtm.csv

#php ../scripts/add-source.php ocha-phl 'OCHA Philippines'
#php ../scripts/add-dataset.php ocha-phl philippines-3w 'OCHA Philippines 3W, 16 June 2014'
#php ../scripts/import-data.php dpm ocha-phl philippines-3w < ../sample-data/phl-32-hxl.csv

php ../scripts/add-source.php unhcr 'United Nations High Commissioner for Refugees (UNHCR)'
php ../scripts/add-dataset.php unhcr refugees 'UNHCR refugee data, 2012'
php ../scripts/import-data.php dpm unhcr refugees < ../sample-data/unhcr-refugee-data.csv

