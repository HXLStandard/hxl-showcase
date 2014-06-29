#!/bin/sh

psql < reset.sql
psql blue < schema.sql
psql blue < perms.sql

