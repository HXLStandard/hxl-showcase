--
-- Add a new user.
--
create or replace function add_usr(varchar(64), varchar(128)) returns bigint as $$
  insert into usr(ident, name) values ($1, $2) returning id;
$$ language sql;

--
-- Look up a user.
--
create or replace function ref_usr(varchar(64)) returns bigint as $$
  select id from usr where ident=$1;
$$ language sql;


--
-- Add a new source.
--
create or replace function add_source(varchar(64), varchar(128)) returns bigint as $$
  insert into source(ident, name) values ($1, $2) returning id;
$$ language sql;

--
-- Look up a source.
--
create or replace function ref_source(varchar(64)) returns bigint as $$
  select id from source where ident=$1;
$$ language sql;

--
-- Add a new HXL code.
--
create or replace function add_code(varchar(64), varchar(128)) returns bigint as $$
  insert into code (code, name) values ($1, $2) returning id
$$ language sql;

--
-- Look up a HXL code.
--
create or replace function ref_code(varchar(64)) returns bigint as $$
  select id from code where code=$1;
$$ language sql;

--
-- Add a new dataset.
--
create or replace function add_dataset(bigint, varchar(64), varchar(128)) returns bigint as $$
  insert into dataset (source, ident, name) values ($1, $2, $3) returning id;
$$ language sql;

--
-- Look up a dataset.
--
create or replace function ref_dataset(varchar(64), varchar(64)) returns bigint as $$
  select id from dataset where source=ref_source($1) and ident=$2;
$$ language sql;

--
-- Create a new import.
--
create or replace function add_import(bigint, bigint) returns bigint as $$
  insert into import (dataset, usr, stamp) values ($1, $2, now()) returning id;
$$ language sql;

--
-- Create a new column.
--
create or replace function add_col(bigint, bigint, text) returns bigint as $$
  insert into col (import, code, header) values ($1, $2, $3) returning id;
$$ language sql;

--
-- Create a new row.
--
create or replace function add_row() returns bigint as $$
  insert into row (id) values (default) returning id;
$$ language sql;

--
-- Create a new value (cell).
--
create or replace function add_value(bigint, bigint, text) returns bigint as $$
  insert into value (row, col, value) values ($1, $2, $3) returning id;
$$ language sql;

