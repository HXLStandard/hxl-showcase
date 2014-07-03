#!/bin/sh

psql < reset.sql
psql blue < schema.sql
psql blue < permissions.sql
psql blue < procedures.sql
psql blue < views.sql


