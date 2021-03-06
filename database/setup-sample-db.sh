#!/bin/sh

sh init-db.sh

php ../scripts/import-tags.php < ../hxl-tags.csv

php ../scripts/add-usr.php dpm 'David Megginson'

php ../scripts/add-source.php rowca 'OCHA Regional Office for West and Central Africa (ROWCA)'
php ../scripts/add-dataset.php rowca rowca-3w 'ROWCA 3W, June 2014'
php ../scripts/import-data.php dpm rowca rowca-3w < ../sample-data/rowca-3w-hxl.csv
php ../scripts/add-dataset.php rowca rowca-gin-adm2 'Guinea prefecture (ADM2) codes and centroids'
php ../scripts/import-data.php dpm rowca rowca-gin-adm2 < ../sample-data/rowca-gin-adm2.csv

php ../scripts/add-source.php sbtf 'Standby Task Force'
php ../scripts/add-dataset.php sbtf sbtf-gin-health 'Guinea health facilities'
php ../scripts/import-data.php dpm sbtf sbtf-gin-health < ../sample-data/sbtf-gin-health.csv
php ../scripts/add-dataset.php sbtf sbtf-lib-health 'Liberia health facilities'
php ../scripts/import-data.php dpm sbtf sbtf-lib-health < ../sample-data/sbtf-lib-health.csv
php ../scripts/add-dataset.php sbtf sbtf-sle-health 'Sierra Leone health facilities'
php ../scripts/import-data.php dpm sbtf sbtf-sle-health < ../sample-data/sbtf-sle-health.csv

php ../scripts/add-source.php brc 'British Red Cross'
php ../scripts/add-dataset.php brc-westafrica-movement 'West Africa Ebola movement restrictions'
php ../scripts/import-data.php dpm brc brc-westafrica-movement < ../sample-data/brc-westafrica-movement.csv

php ../scripts/add-source.php iati 'International Aid Transparency Initiative (IATI)'
php ../scripts/add-dataset.php iati iati-sla 'IATI Sierra Leone aid activities'
php ../scripts/import-data.php dpm iati iati-sla < ../sample-data/iati-sierraleone.csv

php ../scripts/add-source.php unhcr 'United Nations High Commissioner for Refugees (UNHCR)'
php ../scripts/add-dataset.php unhcr unhcr-3w 'UNHCR global 3W'
php ../scripts/import-data.php dpm unhcr unhcr-3w < ../sample-data/unhcr-3w.csv
php ../scripts/add-dataset.php unhcr refugees 'UNHCR refugee data'
php ../scripts/import-data.php dpm unhcr refugees < ../sample-data/unhcr-refugee-data-full.csv

php ../scripts/add-dataset.php unhcr mali-population-movements 'Mali monthly population-movement data'
php ../scripts/import-data.php dpm unhcr mali-population-movements < ../sample-data/mali-population-movements.csv

php ../scripts/add-source.php iom 'International Organization for Migration (IOM)'
php ../scripts/add-dataset.php iom haiti-dtm 'IOM Haiti DTM, June 2013'
php ../scripts/import-data.php dpm iom haiti-dtm < ../sample-data/iom-haiti-dtm.csv

php ../scripts/add-source.php ocha-phl 'OCHA Philippines'
php ../scripts/add-dataset.php ocha-phl philippines-3w 'OCHA Philippines 3W, 16 June 2014'
php ../scripts/import-data.php dpm ocha-phl philippines-3w < ../sample-data/phl-32-hxl.csv

vacuumdb blue
vacuumlo blue # requires postgresql-contrib package in Ubuntu
