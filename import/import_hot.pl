#open(FILE, "20160411boyan01_raw.txt") or die("import error \n");
#my $input_file=shift or die("Usage: $0 input_file \n");
#open(FILE,  $input_file)or die("usage; $0  input_file \n");;
#open(FILE,  "QA-4.19已修改2.txt")or die("usage; $0  input_file \n");;
#open(FILE,  "QA-4.20.txt")or die("usage; $0  input_file \n");;
#open(FILE,  "Hotspot_20160421.txt")or die("usage; $0  input_file \n");;
my $file=shift or   die("usage; $0  input_file \n");;
open(FILE,  "$file")or die("open file  $file error  \n");;
my $count=0;
for(<FILE>)
{
    #@array=split(/,/,$_);
    chomp;
    @array=split(/\|/,$_);
    if(scalar(@array)==9)
    {
        #print "ERROR". scalar(@array)."\n";;
        my $q=$array[0];
        my $a=$array[1];

        $q=~s/"//g;
        $a=~s/"//g;
        #$a=~s/|/_/g;

    
        print_wget($q, $a, $count);
        $count++;
    }
    else
    {
        print "ERROR". scalar(@array)."\n";;
    }
}
sub print_wget($$)
{
    (my $q, my $a, my $count)=@_;

            print <<EOF
wget --post-data="question=$q&answer=$a&user=hotspot"  http://192.168.1.11/qa_shadow/question_modifyok.php  -O  output/$count
EOF
;

}

__DATA__
RETVAL=\$?
[ \$RETVAL -ne 0 ] && touch /tmp/boyan_$count


