select count(*)  from question    where user='corechatAi';
select count(*)  from question   where user='corechat';
select count(*)  from question   where user='chatlib';


select count(*)  from answer    where user='corechatAi';
select count(*)  from answer   where user='corechat';
select count(*)  from answer   where user='chatlib';

update  question    set user='chatlib' where user='corechatAi';
update  question    set user='chatlib' where user='corechat';

update  answer    set user='chatlib' where user='corechatAi';
update  answer    set user='chatlib' where user='corechat';


;#2016_05_24_11:31:08   星期二   add by greshem

use qa_shadow
use qa_db;
update  question    set user='chatlib_zhihu' where user='chatlib';
update  answer    set user='chatlib_zhihu' where user='chatlib';

