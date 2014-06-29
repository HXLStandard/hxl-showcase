#!/bin/sh

psql < reset.sql
psql < schema.sql
