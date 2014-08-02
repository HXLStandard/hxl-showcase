create or replace view tag_view as
select T.*, DT.datatype_name
from tag T
join datatype DT using(datatype);

create or replace view dataset_view as
select D.*, S.source_name
from dataset D
join source S using(source);

create or replace view import_view as
select I.*, D.dataset_name, S.source, S.source_name, U.usr_name
from import I
join dataset D using(dataset)
join source S using(source)
join usr U using(usr);

create or replace view latest_import_view as
select I.import
from import I
join (select dataset, max(stamp) as stamp from import group by dataset) MAX
on I.dataset=MAX.dataset and I.stamp=MAX.stamp;

create or replace view col_view as
select C.*, I.stamp,
  S.source, S.source_name,
  D.dataset_name,
  T.tag_name, T.datatype
from col C
join import I using(import)
join tag T using(tag)
join dataset D using(dataset)
join source S using(source);

create or replace view value_view as
select *
from value
join col using(col);

create or replace view search_view as
select *
from value
join col using(col)
join import using(import)
join dataset using(dataset)
join source using(source);

