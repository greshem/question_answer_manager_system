#!/usr/bin/perl
#open(FILE, "tmp2") or die(" open file error \n");
open(FILE, "三个字以内语料库20160413.txt") or die(" open file error \n");
for(<FILE>)
{
    #print $_;
    chomp();
    @array=split(/\|/, $_);
    print "#".scalar(@array)."|".join("|", @array)."\n";
   
    if(scalar(@array)==3)
    {
        #print "Q: $array[0] \n";
        #print "A: $array[1] \n";
        wget_post($array[0], $array[1]);
        wget_post($array[0], $array[2]);
    }
    elsif(scalar(@array)==5)
    {
        wget_post($array[1], $array[2]);
        wget_post($array[3], $array[4]);
    }
    elsif(scalar(@array)==7)
    {
        wget_post($array[1], $array[2]);
        wget_post($array[3], $array[4]);
        wget_post($array[5], $array[6]);
    }
}
sub  wget_post($$)
{
    (my $Q, my $A)=@_;
            print <<EOF
wget --post-data="question=$Q&answer=$A&user=chenyu"  http://192.168.1.11/qa_shadow/question_modifyok.php 
EOF
;

}
