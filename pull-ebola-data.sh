#!/bin/sh
########################################################################
# Pull fresh Ebola data from Google drive
########################################################################

wget -O sample-data/sbtf-gin-health.csv 'https://docs.google.com/spreadsheets/d/1paoIpHiYo7dy_dnf_luUSfowWDwNAWwS3z4GHL2J7Rc/export?format=csv&id=1paoIpHiYo7dy_dnf_luUSfowWDwNAWwS3z4GHL2J7Rc&gid=2077872077'

wget -O sample-data/sbtf-lbr-health.csv 'https://docs.google.com/spreadsheets/d/1paoIpHiYo7dy_dnf_luUSfowWDwNAWwS3z4GHL2J7Rc/export?format=csv&id=1paoIpHiYo7dy_dnf_luUSfowWDwNAWwS3z4GHL2J7Rc&gid=215078761'

wget -O sample-data/sbtf-sle-health.csv 'https://docs.google.com/spreadsheets/d/1paoIpHiYo7dy_dnf_luUSfowWDwNAWwS3z4GHL2J7Rc/export?format=csv&id=1paoIpHiYo7dy_dnf_luUSfowWDwNAWwS3z4GHL2J7Rc&gid=1345126910'

exit 0
