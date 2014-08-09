create table lang (
  lang varchar(2) primary key,
  lang_name varchar(64) not null
);

insert into lang (lang, lang_name) values ('en', 'English');

create table datatype (
  datatype varchar(32) primary key,
  datatype_name varchar(128) not null
);

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

create table source (
  source varchar(32) unique not null,
  source_name varchar(128) not null
);

create table tag (
  tag varchar(32) primary key,
  tag_name varchar(128) not null,
  datatype varchar(32) not null,
  foreign key(datatype) references datatype(datatype)
);

create table dataset (
  dataset varchar(32) primary key,
  source varchar(32) not null,
  dataset_name varchar(128) not null,
  foreign key(source) references source(source)
);

create table import (
  import bigserial primary key,
  stamp timestamp default now(),
  dataset varchar(32) not null,
  usr varchar(32) not null,
  unique(dataset, stamp),
  foreign key(dataset) references dataset(dataset),
  foreign key(usr) references usr(usr)
);

create index import_stamp on import(stamp);

create table col (
  col bigserial primary key,
  import bigint not null,
  tag varchar(32) not null,
  header text not null,
  foreign key(import) references import(import),
  foreign key(tag) references tag(tag)
);

create table row (
  row bigserial primary key
);

create table value (
  id bigserial primary key,
  row bigint not null,
  col bigint not null,
  content text not null,
  norm text,
  lang varchar(2) default 'en',
  foreign key(row) references row(row) deferrable,
  foreign key(col) references col(col) deferrable
);

create index value_content_idx on value using gin(to_tsvector('english', content));
create index value_norm_idx on value(norm);
