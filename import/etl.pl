wget --post-data="question=想念你&answer="I miss u,2"&user=chenyu"  http://192.168.1.11/qa_shadow/question_modifyok.php 
__DATA__

            $a=~s/"//g;
            $a=~s/\'//g;
            $a=~s/\(//g;
            $a=~s/\)//g;
            $a=~s/\`//g;
            $a=~s/\s+$//g;
            $a=~s/^\s+//g;

            $q=~s/\'//g;
            $q=~s/\(//g;
            $q=~s/\)//g;
            $q=~s/\`//g;
            $q=~s/\s+$//g;
            $q=~s/^\s+//g;
            $q=~s/"//g;


