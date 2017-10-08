<?php
require_once('lib_db.php');

function logger_seg($str)
{
    #file_put_contents("all.log", $str,  FILE_APPEND);
}

function   testunit_seg()
{

    $sqldb=new db;
    $sqldb->connect_db("localhost", "root", "password","qa_db");

    $question="黛玉为什么不敢挑宝钗的短?";
    update_question_seg_keyword($sqldb, $question);

    $answer="李鸿章背景"; #16 
    update_answer_seg_keyword($sqldb, $answer);
}



function update_answer_seg_keyword($sqldb, $answer)
{
    $a_id=$sqldb->get_a_id_with_answer($answer);
    echo $a_id."\n";
    $output=seg_str($answer);
    update_answer_seg_keyword_aid($sqldb, $a_id,$output);
}

function update_answer_seg_keyword_aid($sqldb, $a_id, $output)
{

    if(! is_null($a_id))
    {
        logger_seg("a_id=$a_id, seg= ".$output["seg"]."|keyword=".$output["keyword"]."\n");
        $sqldb->update_a_seg($a_id, $output["seg"]);
        $sqldb->update_a_keywords($a_id, $output["keyword"]);
    }
}


function  update_question_seg_keyword($sqldb, $question)
{
    #$sqldb=new db;
    #$sqldb->connect_db("localhost", "root", "password","qa_shadow");

    $q_id=$sqldb->get_q_id_with_question($question);
    echo $q_id."\n";
    $output=seg_str($question);

    update_question_seg_keyword_qid($sqldb, $q_id,$output);
}
function  update_question_seg_keyword_qid($sqldb, $q_id,$output)
{

    if(is_null($q_id))
    {
        #echo "没有这个questio\n";
    }
    else
    {

        logger_seg("q_id=$q_id, seg= ".$output["seg"]."|keyword=".$output["keyword"]."\n");
        $sqldb->update_q_seg($q_id, $output["seg"]);
        $sqldb->update_q_keywords($q_id, $output["keyword"]);
    }

}


function  seg_str($string)
{
    #curl http://localhost:9100/nlp?text=你好
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://localhost:9100/nlp?text=$string");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $output = curl_exec($ch);
    curl_close($ch);

    #echo $output;
    $seg=json_decode($output,true);
    #var_dump($b);
    #echo  "seg->".$b['seg']."\n";
    #echo  "keyword->".$b['keyword']."\n";
    return $seg;
}

#testunit_seg();

?>
