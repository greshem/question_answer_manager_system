cat  wget.sh* |grep wget   > tmptmptmp.sh

mkdir output/
mkdir output/output/
split -l 200  tmptmptmp.sh  output/bbbbbbbbbbbbbbbbb
for each in $(dir -1 output/|grep bbbbbbbbb)
do
echo bash  $each  >> output/a.sh 
done

tac  output/a.sh  > output/b.sh 

echo "nohup bash a.sh > nohup &  "> output/start.sh & 
echo "nohup bash b.sh  >nohup2&  "> output/start2.sh & 
