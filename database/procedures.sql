
--
-- Add a new HXL code.
--
create or replace function add_code(varchar(64), varchar(128)) returns bigint as $$
  insert into code (code, name) values ($1, $2) returning id
$$ language sql;

--
-- Delete a HXL code.
--
create or replace function del_code(varchar(64)) returns bigint as $$
  with deleted as (delete from code where code=$1 returning *) select count(*) from deleted;
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
create or replace function add_dataset(varchar(64), varchar(128)) returns bigint as $$
  insert into dataset (ident, name) values ($1, $2) returning id;
$$ language sql;

--
-- Look up a dataset.
--
create or replace function ref_dataset(varchar(64)) returns bigint as $$
  select id from dataset where ident=$1;
$$ language sql;

--
-- Create a new import.
--
create or replace function add_import(varchar(64)) returns bigint as $$
  insert into import (dataset, stamp) values (ref_dataset($1), now()) returning id;
$$ language sql;

--
-- Create a new column.
--
create or replace function add_col(bigint, varchar(64), text) returns bigint as $$
  insert into col (import, code, header) values ($1, ref_code($2), $3) returning id;
$$ language sql;

--
-- Create a new row.
--
create or replace function add_row(bigint) returns bigint as $$
  insert into row (import) values ($1) returning id;
$$ language sql;

--
-- Create a new value (cell).
--
create or replace function add_value(bigint, bigint, text) returns bigint as $$
  insert into value (row, col, value) values ($1, $2, $3) returning id;
$$ language sql;

