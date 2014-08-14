-- ---------------------------------------------------------------------
-- PostgreSQL SQL schema for the HXL Showcase (Blue Monster)
--
-- Started by David Megginson, July 2014
-- ---------------------------------------------------------------------

create table lang (
  lang varchar(2) primary key,
  lang_name varchar(64) not null
);

comment on table lang is 'Natural languages.';

insert into lang (lang, lang_name) values ('en', 'English');

create table datatype (
  datatype varchar(32) primary key,
  datatype_name varchar(128) not null
);

comment on table datatype is 'Data types associated with HXL tags.';

insert into datatype (datatype, datatype_name) values
  ('Text', 'Text'),
  ('Code', 'Identifier or code'),
  ('Number', 'Number'),
  ('Date', 'Date'),
  ('Phone number', 'Telephone number'),
  ('URL', 'Web link'),
  ('Email', 'Email address');

create table usr (
  usr varchar(32) unique not null,
  usr_name varchar(128) not null
);

comment on table usr is 'Web site members.';

create table source (
  source varchar(32) unique not null,
  source_name varchar(128) not null
);

comment on table source is 'Data source organisations.';

create table tag (
  tag varchar(32) primary key,
  tag_name varchar(128) not null,
  datatype varchar(32) not null,
  foreign key(datatype) references datatype(datatype)
);

comment on table tag is 'HXL hashtags.';

create table dataset (
  dataset varchar(32) primary key,
  source varchar(32) not null,
  dataset_name varchar(128) not null,
  foreign key(source) references source(source)
);

comment on table dataset is 'Top-level dataset (can have multiple imports).';

create table import (
  import bigserial primary key,
  stamp timestamp default now(),
  dataset varchar(32) not null,
  usr varchar(32) not null,
  unique(dataset, stamp),
  foreign key(dataset) references dataset(dataset),
  foreign key(usr) references usr(usr)
);

comment on table import is 'A specific import of a dataset.';

create index import_stamp on import(stamp);

create table col (
  col bigserial primary key,
  import bigint not null,
  tag varchar(32) not null,
  header text not null,
  foreign key(import) references import(import),
  foreign key(tag) references tag(tag)
);

comment on table col is 'A column of a specific import of a dataset. No col will appear in more than one import.';

create table row (
  row bigserial primary key
);

comment on table row is 'A row of a specific import of a dataset. No row will appear in more than one import.';

create table value (
  value bigserial primary key,
  row bigint not null,
  col bigint not null,
  content text not null,
  norm text,
  lang varchar(2) default 'en',
  foreign key(row) references row(row) deferrable,
  foreign key(col) references col(col) deferrable
);

comment on table value is 'A cell value in a specific import of a dataset.';

create index on value using gin(to_tsvector('english', content));
create index on value (norm);
