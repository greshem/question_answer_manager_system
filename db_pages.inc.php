<?php

class AsPagebar {

var $total; 
var $onepage;
var $num;
var $pagecount;
var $total_page;
var $offset;
var $linkhead; 

function AsPagebar($total, $onepage, $form_vars='') {
$pagecount = $_GET['pagecount'];
$this->total = $total;
$this->onepage = $onepage;
$this->total_page = ceil($total/$onepage);

if (empty($pagecount)) {
$this->pagecount = 1;
$this->offset = 0; 
}else {
$this->pagecount = $pagecount;
$this->offset = ($pagecount-1)*$onepage;
}

if (!empty($form_vars)) {

$vars = explode("|", $form_vars);
$chk = $vars[0];
$chk2 = $vars[1];
$chk_value = $_POST["$chk"];
$chk_value2 = $_POST["$chk2"];
if (empty($chk_value) && empty($chk_value2)) {
$formlink = "";
}else {
for ($i=0; $i<sizeof($vars); $i++) {
$var = $vars[$i];
$value = $_POST["$var"];
$addchar = $var."=".$value;

$formlink = $formlink.$addchar."&";
}
}
}else {
$formlink = "";
}

$linkarr = explode("pagecount=", $_SERVER['QUERY_STRING']);
$linkft = $linkarr[0];

if (empty($linkft)) {
$this->linkhead = $_SERVER['PHP_SELF']."?".$formlink;
}else {
$linkft = (substr($linkft, -1)=="&")?$linkft:$linkft."&";
$this->linkhead = $_SERVER['PHP_SELF']."?".$linkft.$formlink;
}

}
#End of function PageBar();

/**+-----------------------------------------------
| 用于取得select的指针.
| i.e. $pb = new PageBar(50, 10);
| $offset = $pb->offset();
| +-----------------------------------------------
*/
function offset() {
return $this->offset;
}
#End of function offset();


/**+-----------------------------------------------
| 取得第一页.$link为1是为带链接
| i.e. $pb = new PageBar(50, 10);
| $first_page = $pb->first_page(1);
| +-----------------------------------------------
*/
function first_page($link='', $char='', $color='') {
$linkhead = $this->linkhead;
$linkchar = (empty($char))
? "<font color='$color'>[首页]</font>"
: $char;
if ($link==1) {
return "<a href=\"$linkhead"."pagecount=1\" title=\"首页\" class=\"page_black\">$linkchar</a>";
}else {
return 1;
}
}
#End of function first_page();

/**+-----------------------------------------------
| 取得最末页.$link为1是为带链接
| i.e. $pb = new PageBar(50, 10);
| $total_page = $pb->total_page(1);
| +-----------------------------------------------
*/
function total_page($link='', $char='', $color='') {
$linkhead = $this->linkhead;
$total_page = $this->total_page;
$linkchar = (empty($char))
? "<font color='$color'>[".$total_page."]</font>"
: $char;
if ($link==1) {
return "<a href=\"$linkhead"."pagecount=$total_page\" title=\"尾页\" class=\"page_black\">[尾页]</a>";
}else {
return $total_page;
}
}


/**+-----------------------------------------------
| 取得最末页.$link为1是为带链接
| i.e. $pb = new PageBar(50, 10);
| $total_page = $pb->total_page(1);
| +-----------------------------------------------
*/
function jump_page($link='', $char='', $color='') {
$linkhead = $this->linkhead;
$total_page = $this->total_page;

	if($total_page>1)
	{
		$jump_bar="跳转到：第<select name=\"pagecount\" style=\"width:50px\"  onChange=\"javascript:window.location='".$linkhead."pagecount=' + this.value+''\">";
		$jump_bar.="<option value=\"1\" >-</option>";
		for ($i=1; $i<=$total_page; $i++) 
		{
			$jump_bar.="<option value=\"$i\" >$i</option>";
		}
		$jump_bar.="</select>页";
	}

return $jump_bar;
}



/**+-----------------------------------------------
|  跳转表单
|  i.e. $pb           = new PageBar(50, 10);
|  特别说明 $jump='' 如果在同一页要用两个Jump_form
|  那你就要设定不同的$jump，否则产生错误
|  $Jump_form    = $pb->Jump_form();
| +-----------------------------------------------
*/
function Jump_form($jump='') {
$formname = "pagebarjumpform".$jump;
$jumpname = "jump".$jump; 
$jy_num = "jy_num".$jump; 

$linkhead = $this->linkhead;
$total = $this->total_page;
$form = <<<EOT
<table width="30%" border="0" cellspacing="0" cellpadding="0">
	<SCRIPT language=JavaScript>

	function $jy_num(ctrl,n)
	{
		var num=ctrl.value;
		if(num.search(/^[0-9]+(\.[0-9]*)?$/gi)!= -1)
			return true;
		else
		{
			ctrl.value=n;
			ctrl.focus();
			return false;
		}
	}
	</SCRIPT>
    <script language="javascript">
        function $jumpname(linkhead, total, page){
            
            var pagecount = (page.value>total)?total:page.value;
            pagecount = (pagecount<1)?1:pagecount;
            location.href = linkhead + "pagecount=" + pagecount;
            return false;
        }
    </script>
       <form name="$formname" method="post" onSubmit="return $jumpname('$linkhead', $total, $formname.page)"><tr>
          <td>
        <input name="page" type="text" size="1" maxlenght="4"  style="width:30px;"   onkeyup=$jy_num($formname.page,'')>
        <input type="button" name="Submit" value="GO" onClick="return $jumpname('$linkhead', $total, $formname.page)">
      </td>
        </tr></form></table>
EOT;
return $form;
}
#End of function Jump_form();



/**+-----------------------------------------------
| 取得上一页.$char为链接的字符,默认为"[<]"
| i.e. $pb = new PageBar(50, 10);
| $pre_page = $pb->pre_page("上一页");
| +-----------------------------------------------
*/
function pre_page($char='') {
$linkhead = $this->linkhead;
$pagecount = $this->pagecount;
if (empty($char)) {
$char = "[<]";
}

if ($pagecount>1) {
$pre_page = $pagecount - 1;
return "<a href=\"$linkhead"."pagecount=$pre_page\" title=\"上一页\" class=\"page_black\">$char</a>";
} else {
return '';
}
}
#End of function pre_page();

/**+-----------------------------------------------
| 取得下一页.$char为链接的字符,默认为"[>]"
| i.e. $pb = new PageBar(50, 10);
| $next_page = $pb->next_page("下一页");
| +-----------------------------------------------
*/
function next_page($char='') {
$linkhead = $this->linkhead;
$total_page = $this->total_page;
$pagecount = $this->pagecount;
if (empty($char)) {
$char = "[>]";
}
if ($pagecount<$total_page) {
$next_page = $pagecount + 1;
return "<a href=\"$linkhead"."pagecount=$next_page\" title=\"下一页\" class=\"page_black\">$char</a>";
} else {
return '';
}
}
#End of function next_page();

/**+-----------------------------------------------
| 取得页码数字条. $num 为个数,默认为10
| $color 为当前链接的突显颜色
| $left 数字左边 默认为"[" 
| $right 数字左右 默认为"]"
| i.e. $pb = new PageBar(50, 10);
| $num_bar = $pb->num_bar(9, "$cccccc");
| +-----------------------------------------------
*/
function num_bar($num='', $color='', $maincolor='', $left='', $right='') {
$num = (empty($num))?10:$num;
$this->num = $num;
$mid = floor($num/2);
$last = $num - 1; 
$pagecount = $this->pagecount;
$totalpage = $this->total_page;
$linkhead = $this->linkhead;
$left = (empty($left))?"[":$left;
$right = (empty($right))?"]":$right;
$color = (empty($color))?"#ff0000":$color;
$minpage = (($pagecount-$mid)<1)?1:($pagecount-$mid);
$maxpage = $minpage + $last;
if ($maxpage>$totalpage) {
$maxpage = $totalpage;
$minpage = $maxpage - $last;
$minpage = ($minpage<1)?1:$minpage;
}

for ($i=$minpage; $i<=$maxpage; $i++) {
$chars = $left.$i.$right;
$char = "<font color='$maincolor'>".$chars."</font>";
if ($i==$pagecount) {
$char = "<font color='$color'>$chars</font>";
}

$linkchar = "<a href='$linkhead"."pagecount=$i' class=\"page_black\">".$char."</a>";
$linkbar .= $linkchar;
}

return $linkbar;
}
#End of function num_bar();


/**+-----------------------------------------------
| 取得上一组数字条.$char为链接的字符,默认为"[<<]"
| i.e. $pb = new PageBar(50, 10);
| $num_bar = $pb->num_bar();
| $pre_group = $pb->pre_group();
| +-----------------------------------------------
*/
function pre_group($char='') {
$pagecount = $this->pagecount;
$linkhead = $this->linkhead;
$num = $this->num;
$mid = floor($num/2);
$minpage = (($pagecount-$mid)<1)?1:($pagecount-$mid);
$char = (empty($char))?"[<<]":$char;
$pgpagecount = ($minpage>$num)?$minpage-$mid:1;
return "<a href='$linkhead"."pagecount=$pgpagecount' title=\"上一组\" class=\"page_black\">".$char."</a>";
}
#End of function pre_group();

/**+-----------------------------------------------
| 取得下一组数字条.$char为链接的字符,默认为"[>>]"
| i.e. $pb = new PageBar(50, 10);
| $num_bar = $pb->num_bar();
| $next_group = $pb->next_group();
| +-----------------------------------------------
*/
function next_group($char='') {
$pagecount = $this->pagecount;
$linkhead = $this->linkhead;
$totalpage = $this->total_page;
$num = $this->num;
$mid = floor($num/2);
$last = $num; 
$minpage = (($pagecount-$mid)<1)?1:($pagecount-$mid);
$maxpage = $minpage + $last;
if ($maxpage>$totalpage) {
$maxpage = $totalpage;
$minpage = $maxpage - $last;
$minpage = ($minpage<1)?1:$minpage;
}

$char = (empty($char))?"[>>]":$char;
$ngpagecount = ($totalpage>$maxpage+$last)?$maxpage + $mid:$totalpage;

return "<a href='$linkhead"."pagecount=$ngpagecount' title=\"下一组\" class=\"page_black\">".$char."</a>";
}
#End of function next_group();

/**+-----------------------------------------------
| 取得整个数字条，上一页，下一页，上一组
| 下一组的等.$num数字个数,$color 当前链接的突显色
| i.e. $pb = new PageBar(50, 10);
| $whole_num_bar = $pb->whole_num_bar(9);
| +-----------------------------------------------
*/
function whole_num_bar($num='', $color='', $maincolor='') {
$num_bar = $this->num_bar($num, $color, $maincolor);
//return $this->first_page(1, '', $maincolor).$this->pre_group("<font color='$maincolor'>[<<]</font>").$this->pre_page("<font color='$maincolor'>[<]</font>").$num_bar.$this->next_page("<font color='$maincolor'>[>]</font>").$this->next_group("<font color='$maincolor'>[>>]</font>").$this->total_page(1, '', $maincolor);
return $this->first_page(1, '', $maincolor).$this->pre_group("<font color='$maincolor'>[<<]</font>").$this->pre_page("<font color='$maincolor'>[<]</font>").$num_bar.$this->next_page("<font color='$maincolor'>[>]</font>").$this->next_group("<font color='$maincolor'>[>>]</font>").$this->total_page(1, '', $maincolor).$this->jump_page(1, '', $maincolor);
}
#End of function whole_bar();


/**+-----------------------------------------------
| 取得整链接，等于whole_num_bar加上表单跳转.
| $num数字个数,$color 当前链接的突显色
| i.e. $pb = new PageBar(50, 10);
| $whole_bar = $pb->whole_bar(9);
| +-----------------------------------------------
*/
function whole_bar($jump='', $num='', $color='', $maincolor='') {
$whole_num_bar = $this->whole_num_bar($num, $color, $maincolor)."&nbsp;";
$jump_form = $this->jump_form($jump);
return <<<EOT
<table width="70%" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td align="left" class="page_black">$whole_num_bar</td>
<td align="left" cwidth="80">$jump_form</td>
</tr>
</table>
EOT;
}

}

?> 
