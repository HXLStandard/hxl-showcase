#!/bin/sh

sh init-db.sh

php ../scripts/import-codes.php < ../hxl-codes.csv

php ../scripts/add-source.php source1 "Source #1"
php ../scripts/add-source.php source2 "Source #2"

php ../scripts/add-dataset.php source1 dataset1 "Dataset #1 from source #1"
php ../scripts/add-dataset.php source1 dataset2 "Dataset #2 from source #1"
php ../scripts/add-dataset.php source2 dataset1 "Dataset #1 from source #1"
php ../scripts/add-dataset.php source2 dataset2 "Dataset #2 from source #2"

php ../scripts/import-data.php source1 dataset1 < ../sample-data.csv
php ../scripts/import-data.php source1 dataset2 < ../sample-data.csv
php ../scripts/import-data.php source2 dataset1 < ../sample-data.csv
php ../scripts/import-data.php source2 dataset2 < ../sample-data.csv
