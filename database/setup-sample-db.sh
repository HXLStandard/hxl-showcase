#!/bin/sh

sh init-db.sh

php ../scripts/import-tags.php < ../hxl-tags.csv

php ../scripts/add-usr.php dpm 'David Megginson'

php ../scripts/add-source.php rowca 'OCHA Regional Office for West and Central Africa (ROWCA)'
php ../scripts/add-dataset.php rowca 3w 'ROWCA 3W'
php ../scripts/import-data.php dpm rowca 3w < ../sample-data/rowca-3w-hxl.csv

php ../scripts/add-source.php iom 'International Organization for Migration (IOM)'
php ../scripts/add-dataset.php iom haiti-dtm 'IOM Haiti DTM'
php ../scripts/import-data.php dpm iom haiti-dtm < ../sample-data/iom-haiti-dtm.csv

php ../scripts/add-source.php unhcr 'United Nations High Commissioner for Refugees (UNHCR)'
php ../scripts/add-dataset.php unhcr refugees 'UNHCR refugee data'
php ../scripts/import-data.php dpm unhcr refugees < ../sample-data/unhcr-refugee-data.csv

