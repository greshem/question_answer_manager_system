#!/usr/bin/perl
system(" /usr/bin/delete_space_for_bash.pl");
for $each (glob("*.xlsx"))
{
    my $output="${each}.txt.utf8";
    if(! -f  $output)
    {
            print ("INFO_CONVERT: python qa_db_import_excel_xslt.py   $each > ${each}.txt.utf8");
            my_system("python qa_db_import_excel_xslt.py   $each > ${each}.txt.utf8");
    }
    else
    {
        print "#exists: $output  skip \n";
    }
}

for $each (glob("*.txt"))
{
    my_system("bash /tmp3/bin/gb2312_to_utf8.sh  $each  > $each.utf8 ");
    my_system("sed  -i  's/\t/|/g'  $each.utf8  ");
    my_system("dos2unix  $each.utf8");
}

for $each(glob("*.txt.utf8"))
{
    if($each=~/^wget.sh/)
    {
        next;
    }

    if( $each=~/editorial*/i)
    {
        my_system(" perl  import_editorial_2_shadow.pl   $each  shadow > wget.sh.$each ");
        my_system("sed 's/qa_shadow/qa_v2/g'   wget.sh.$each  > wget.sh_xiaozhu_.$each ");

    }
    elsif($each=~/Hotspot/i)
    {
        my_system("perl import_hot.pl   $each > wget.sh.$each ");
        my_system("sed 's/qa_shadow/qa_v2/g'   wget.sh.$each  > wget.sh_xiaozhu_.$each ");
        my_system("sed 's/小影/小竹子/g' -i   wget.sh_xiaozhu_.$each ");
    }
    elsif($each=~/hai/i)
    {
        my_system("perl import_haitian.pl   $each > wget.sh.$each ");
        my_system("sed 's/qa_shadow/qa_v2/g'   wget.sh.$each  > wget.sh_xiaozhu_.$each ");
    }
    elsif ($each=~/boyan/i)
    {
        my_system("perl import_boyan.pl    $each > wget.sh.$each ");
        my_system("sed 's/qa_shadow/qa_v2/g'   wget.sh.$each  > wget.sh_xiaozhu_.$each ");
    }
    elsif($each=~/edit/i)
    {
        my_system("perl   import_internship.pl   $each >  wget.sh.$each ");
        my_system("sed 's/qa_shadow/qa_v2/g'   wget.sh.$each  > wget.sh_xiaozhu_.$each ");
    }
    elsif($each=~/实习生/i)
    {
        my_system("perl   import_qingtian.pl   $each >  wget.sh.$each ");
        my_system("sed 's/qa_shadow/qa_v2/g'   wget.sh.$each  > wget.sh_xiaozhu_.$each ");
    }

    else 
    {
    }
}

print join("\n", glob("wget.sh.*"))."\n";
print "#=================================\n";
system("grep -c wget  wget.sh* ");

########################################################################
sub logger($)
{
    use POSIX;
    $log_time = POSIX::strftime('%Y-%m-%d %T',localtime(time()));

	(my $log_str)=@_;
	open(FILE, ">> /tmp/import.log") or warn("open all.log error\n");
	print FILE 	$log_time.":".$log_str;
	print STDOUT $log_time.":".$log_str;
	close(FILE);
}

sub my_system($)
{
	(my $cmd_str)=@_;
	logger("CMD: $cmd_str\n");
	system($cmd_str);
	if($?>>8 ne 0)
	{
		logger("CMD: $cmd_str  ERROR\n");
	}
}


