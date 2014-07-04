create table source (
  id bigserial primary key,
  ident varchar(64) unique not null,
  name varchar(128) not null
);

create table code (
  id bigserial primary key,
  code varchar(64) unique not null,
  name varchar(128) not null
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
  stamp timestamp default now(),
  unique (dataset, stamp),
  foreign key(dataset) references dataset(id)
);

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
  foreign key(row) references row(id),
  foreign key(col) references col(id)
);

