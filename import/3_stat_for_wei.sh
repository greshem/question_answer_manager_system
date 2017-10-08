

#获取q 
echo -n "all question "
grep wget wget.sh.* -h  |awk -Fanswer= '{print $1}'  |sort -n  |uniq -c  |wc -l

echo -n "all anawer ";
grep wget wget.sh.* -h  |awk -Fanswer= '{print $2}'  |sort -n  |uniq -c  |wc -l

echo -n "all qa ";
 grep wget wget.sh.* -h  |wc  -l

#echo "each doc";
#grep -c wget  wget.sh.* 
#grep -c wget  wget.sh.*  |sed 's/^wget.sh.//g'  |sed 's/\.txt\.utf8:/->/g' 

for each in $(dir wget.sh\.*)
do
echo "#--------------------------------------------------------------------------"
echo $each  |sed 's/^wget.sh.//g'  |sed 's/\.txt\.utf8/:/g' 
echo -n "    Question->"
grep wget  $each | awk -Fanswer= '{print $1}'  |sort |uniq |wc -l
echo -n "    Anawer->"
grep wget  $each | awk -Fanswer= '{print $2}'  |sort |uniq |wc -l

done


