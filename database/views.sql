create or replace view dataset_view as
select D.*, S.ident as source_ident, S.name as source_name
from dataset D
join source S on D.source=S.id;

create or replace view import_view as
select I.*, D.ident as dataset_ident, D.name as dataset_name, S.ident as source_ident, S.name as source_name
from import I
join dataset D on I.dataset=D.id
join source S on D.source=S.id;

create or replace view col_view as
select C.*, I.stamp, D.ident as dataset_ident, D.name as dataset_name, CD.code as code_code, CD.name as code_name
from col C
join import I on C.import=I.id
join code CD on C.code=CD.id
join dataset D on I.dataset=D.id
join source S on D.source=S.id;

create or replace view value_view as
select V.*, C.header, I.id as import, I.stamp, CD.code as code_code, CD.name as code_name,
       D.ident as dataset_ident, D.name as dataset_name, 
       S.ident as source_ident, S.name as source_name
from value V
join row R on V.row=R.id
join col C on V.col=C.id
join import I on C.import=I.id
join dataset D on I.dataset=D.id
join source S on D.source=S.id
join code CD on C.code=CD.id;
