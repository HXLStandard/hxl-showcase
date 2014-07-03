#!/bin/sh

psql < reset.sql
psql blue < schema.sql
psql blue < procedures.sql
psql blue < views.sql
psql blue < permissions.sql


