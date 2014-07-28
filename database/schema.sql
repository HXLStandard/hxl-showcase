create table lang (
  lang varchar(2) primary key,
  name varchar(64) not null
);

insert into lang (lang, name) values ('en', 'English');

create table datatype (
  id bigserial primary key,
  type varchar(32) unique not null,
  name varchar(64) not null
);

insert into datatype (type, name) values
  ('Text', 'Text'),
  ('Code', 'Identifier or code'),
  ('Number', 'Number'),
  ('Date', 'Date'),
  ('Phone number', 'Telephone number'),
  ('URL', 'Web link'),
  ('Email', 'Email address');

create table usr (
  id bigserial primary key,
  ident varchar(64) unique not null,
  name varchar(128) not null
);

create table source (
  id bigserial primary key,
  ident varchar(64) unique not null,
  name varchar(128) not null
);

create table tag (
  id bigserial primary key,
  tag varchar(64) unique not null,
  name varchar(128) not null,
  datatype bigint not null,
  foreign key(datatype) references datatype(id)
);

create table dataset (
  id bigserial primary key,
  source bigint not null,
  ident varchar(64) not null,
  name varchar(128) not null,
  unique(source, ident),
  foreign key(source) references source(id)
);

create table import (
  id bigserial primary key,
  dataset bigint not null,
  usr bigint not null,
  stamp timestamp default now(),
  unique (dataset, stamp),
  foreign key(dataset) references dataset(id),
  foreign key(usr) references usr(id)
);

create index import_stamp on import(stamp);

create table col (
  col bigserial primary key,
  import bigint not null,
  tag bigint not null,
  header text not null,
  foreign key(import) references import(id),
  foreign key(tag) references tag(id)
);

create table row (
  row bigserial primary key,
  import bigint not null,
  foreign key(import) references import(id)
);

create table value (
  id bigserial primary key,
  row bigint not null,
  col bigint not null,
  value text not null,
  lang varchar(2) default 'en',
  foreign key(row) references row(row) deferrable,
  foreign key(col) references col(col) deferrable
);

create index value_idx on value using gin(to_tsvector('english', value));
