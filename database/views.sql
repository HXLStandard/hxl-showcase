create or replace view code_view as
select C.*, DT.type, DT.name as datatype_name
from code C
join datatype DT on C.datatype=DT.id;

create or replace view dataset_view as
select D.*, S.ident as source_ident, S.name as source_name
from dataset D
join source S on D.source=S.id;

create or replace view import_view as
select I.*, D.ident as dataset_ident, D.name as dataset_name,
  S.ident as source_ident, S.name as source_name,
  U.ident as usr_ident, U.name as usr_name
from import I
join dataset D on I.dataset=D.id
join source S on D.source=S.id
join usr U on I.usr=U.id;

create or replace view latest_import_view as
select I.id
from import I
join (select dataset, max(stamp) as stamp from import group by dataset) MAX
on I.dataset=MAX.dataset and I.stamp=MAX.stamp;

create or replace view col_view as
select C.*, I.stamp,
  S.id as source, S.ident as source_ident, S.name as source_name,
  D.id as dataset, D.ident as dataset_ident, D.name as dataset_name,
  CD.code as code_code, CD.name as code_name
from col C
join import I on C.import=I.id
join code CD on C.code=CD.id
join dataset D on I.dataset=D.id
join source S on D.source=S.id;

create or replace view value_view as
select V.*, C.header, I.id as import, I.stamp, CD.code as code_code, CD.name as code_name,
       D.id as dataset, D.ident as dataset_ident, D.name as dataset_name, 
       S.id as source, S.ident as source_ident, S.name as source_name,
       U.id as user, U.ident as usr_ident, U.name as usr_name
from value V
join row R on V.row=R.id
join col C on V.col=C.id
join import I on C.import=I.id
join dataset D on I.dataset=D.id
join source S on D.source=S.id
join code CD on C.code=CD.id
join usr U on I.usr=U.id;
