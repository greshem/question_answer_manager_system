set -x 
for each in $(find output  -type f   |grep bbbbbb)
do
rl.pl $each > /tmp/tmp_bbbbb
mv /tmp/tmp_bbbbb  $each
done
