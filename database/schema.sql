create table code (
  id bigserial primary key,
  code varchar(64) unique not null,
  name varchar(128) not null
);

create table dataset (
  id bigserial primary key,
  ident varchar(64) unique not null
);

create table import (
  id bigserial primary key,
  dataset bigint not null,
  stamp timestamp default now(),
  foreign key(dataset) references dataset(id)
    on update cascade on delete cascade
);

create table col (
  id bigserial primary key,
  import bigint not null,
  code bigint not null,
  header text not null,
  foreign key(import) references import(id)
    on update cascade on delete cascade,
  foreign key(code) references code(id)
    on update cascade on delete cascade
);

create table row (
  id bigserial primary key,
  import bigint not null,
  foreign key(import) references import(id)
    on update cascade on delete cascade
);

create table value (
  id bigserial primary key,
  row bigint not null,
  col bigint not null,
  value text not null,
  foreign key(row) references row(id)
    on update cascade on delete cascade,
  foreign key(col) references col(id)
    on update cascade on delete cascade
);

