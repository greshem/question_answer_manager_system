#$sqldb->connect_db("bdm181660525.my3w.com", "bdm181660525", "mysql12345","bdm181660525_db");

sed  -i 's/bdm181660525.my3w.com/localhost/g'   *.php 
sed  -i 's/mysql12345/password/g'               *.php 
sed  -i 's/bdm181660525_db/qa_db/g'             *.php 

sed  -i 's/bdm181660525/root/g'                 *.php 
