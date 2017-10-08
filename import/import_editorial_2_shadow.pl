#!/usr/bin/perl
#open(FILE, "Editorial_Selection_20160323.csv") or die("import error \n");
#open(FILE, "Editorial_Selection_20160324.txt") or die("import error \n");
#open(FILE, "Editorial_Selection_20160325.txt") or die("import error \n");
#open(FILE, "Editorial_Selection_20160328.txt") or die("import error \n");
#open(FILE, "Editorial_Selection_20160331.txt") or die("import error \n");
#open(FILE, "Editorial_Selection_20160415.txt") or die("import error \n");
#open(FILE, "Editorial_Selection_20160419.txt") or die("import error \n");
#open(FILE, "Editorial_Selection_20160420.txt") or die("import error \n");
#open(FILE, "Editorial_Selection_20160422.txt") or die("import error \n");
do("common.pl");

my $file=shift or   die("usage; $0  input_file \n");;
our $shadow_mode=shift; 
if($shadow_mode=~/shadow/i)
{
    $shadow_mode=1;    
}
open(FILE, "$file") or die("open file $file error  \n");
my $count=0;
for(<FILE>)
{
    #@array=split(/,/,$_);
    @array=split(/\|/,$_);
    #56388,这个世界有什么?,有这个世界不该有的东西,0.8782481,知乎,0,不符合,周涛
    if(scalar(@array)==10)
    {
        #print scalar(@array)."\n";
        print "#=================\n";
        #print join("|", @array)."\n";
        
        #if($array[6]=~/^符合$/)
        if($array[6]=~/^\s*不符合/ && $shadow_mode )
        {
            print "DUMP2:$array[6]\n";
            next;
        }
        if($array[5]=~/^ 1$/ )
        {
            #print join("|", @array);
            my $q=$array[1];
            my $a=$array[2];

            $a=filter_string($a);
            $q=filter_string($q);
            wget_post($q, $a,$count);
            $count++;
        }
    }
    else
    {
        print STDERR "格式错误: ".scalar(@array)." \n";
    }
}
sub  wget_post($$)
{
    (my $q, my $a,my $count)=@_;
            print <<EOF
wget --post-data="question=$q&answer=$a&user=chatlib"  http://192.168.1.11/qa_shadow/question_modifyok.php   -O output/$count
EOF
;

}
