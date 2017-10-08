#open(FILE, "20160411boyan01_raw.txt") or die("import error \n");
do("common.pl");
my $input_file=shift or die("Usage: $0 input_file \n");

open(FILE,  $input_file)or die("usage; $0  input_file \n");;
my $count=0;
for(<FILE>)
{
    #@array=split(/,/,$_);
    chomp;
    @array=split(/\|/,$_);
    if(scalar(@array)==9)
    {
        my $topic=$array[2];
        my $q=$array[3];
        my $a=$array[4];
        my $a1=$array[5];

        $q=filter_string($q);
        $a=filter_string($a);
        $a1=filter_string($a1);
        $topic=filter_string($topic);

        print_wget($q, $a, $topic, $count);
        $count++;
        print_wget($q, $a1,$topic,  $count);
        $count++;
        
    }
    else
    {
     print STDERR  "ERROR". scalar(@array)."\n";;
    }
}
sub print_wget($$)
{
    (my $q, my $a, my $topic, my $count)=@_;

    if(length($a)==0 || length($a)==0)
    {
        return ;
    }
            print <<EOF
wget --post-data="question=$q&answer=$a&topic=$topic&user=boyan"  http://192.168.1.11/qa_shadow/question_modifyok.php  -O  output/$count
EOF
;

}
__DATA__
RETVAL=\$?
[ \$RETVAL -ne 0 ] && touch /tmp/boyan_$count

