INSERT INTO yoyaku(name,tel,member,day,remark,indate)VALUES('Noriki kadowaki',123456789,4,"2024-11-30","No smoking room,please",SYSDATE()); 
-- 日付はなぜか””が必要

SELECT * from yoyaku;
select name, id from yoyaku;

-- sysdateでもnowでも良い。