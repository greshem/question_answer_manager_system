sub  filter_string($)
{
    (my $a)=@_;

    $a=~s/"//g;
    $a=~s/\'//g;
    $a=~s/\(//g;
    $a=~s/\)//g;
    $a=~s/\`//g;
    $a=~s/\s+$//g;
    $a=~s/^\s+//g;

    return $a;
}

sub testuni()
{
$a="a))))))a";
$a=filter_string($a);
print $a."\n";
}
