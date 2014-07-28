#!/bin/sh

sh init-db.sh

php ../scripts/import-tags.php < ../hxl-tags.csv

php ../scripts/add-usr.php dpm 'David Megginson'

php ../scripts/add-source.php rowca 'OCHA ROWCA'
php ../scripts/add-dataset.php rowca 3w 'ROWCA 3W'
php ../scripts/import-data.php dpm rowca 3w < ../sample-data/rowca-3w-hxl.csv

php ../scripts/add-source.php iom 'International Organization for Migration (IOM)'


