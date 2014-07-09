create table lang (
  lang varchar(2) primary key,
  name varchar(64) not null
);

insert into lang (lang, name) values ('en', 'English');

create table datatype (
  id bigserial primary key,
  type varchar(8) unique not null,
  name varchar(64) not null
);

insert into datatype (type, name) values
  ('text', 'Text'),
  ('id', 'Identifier or code'),
  ('number', 'Number'),
  ('date', 'Date'),
  ('url', 'Web link'),
  ('email', 'Email address');

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

create table code (
  id bigserial primary key,
  code varchar(64) unique not null,
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
  id bigserial primary key,
  import bigint not null,
  code bigint not null,
  header text not null,
  foreign key(import) references import(id),
  foreign key(code) references code(id)
);

create table row (
  id bigserial primary key
);

create table value (
  id bigserial primary key,
  row bigint not null,
  col bigint not null,
  value text not null,
  lang varchar(2) default 'en',
  foreign key(row) references row(id) deferrable,
  foreign key(col) references col(id) deferrable
);

create index value_idx on value using gin(to_tsvector('english', value));
