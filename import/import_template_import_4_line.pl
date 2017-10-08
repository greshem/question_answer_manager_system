#open(FILE, "20160411boyan01_raw.txt") or die("import error \n");
my $input_file=shift or die("Usage: $0 input_file \n");
#my $input_file="小影Editorial改写20160411.txt";

open(FILE,  $input_file)or die("usage; $0  input_file \n");;
my $count=0;
for(<FILE>)
{
    #@array=split(/,/,$_);
    chomp;
    @array=split(/\|/,$_);
    if(scalar(@array)==9)
    {
        #print "ERROR". scalar(@array)."\n";;
        $count++;
        my $q=$array[1];
        my $a=$array[2];

        $q=~s/"//g;
        $a=~s/"//g;
        $q=~s/\(//g;
        $q=~s/\)//g;
        $a=~s/\)//g;
        $a=~s/\(//g;

        $q=~s/^\s+//g;
        $a=~s/^\s+//g;
        $q=~s/\s+$//g;
        $a=~s/\s+$//g;


    
        print_wget($q, $a, $count);
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
wget --post-data="question=$q&answer=$a&user=fromHost9"  http://192.168.1.11/qa_shadow/question_modifyok.php  -O  output/$count
RETVAL=\$?
[ \$RETVAL -ne 0 ] && touch /tmp/boyan_$count

EOF
;

}
