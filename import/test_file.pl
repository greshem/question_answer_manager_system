#!/usr/bin/perl
for $each (1..4369)
{
    if(! -f  "output/".$each )
    {
        print $each."\n";
    }
}

