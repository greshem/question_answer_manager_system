<?php
include 'header.php';

echo <<<EOF

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">用户管理</li>
              <li><a href="createuser.php">新建用户</a></li>
              <li class="active"><a href="userlist.php">用户列表</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span10">

<div class="btn-toolbar">
    <a class="btn btn-primary" href="createuser.php" >新 建</a>
    <button class="btn">导 入</button>
    <button class="btn">导出</button>
</div>

EOF;

echo <<<EOF
		
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>用户名</th>
          <th>备注</th>
		  <th>邮件</th>
          <th>状态</th>
          <th style="width: 36px;"></th>
        </tr>
      </thead>
      <tbody>
EOF;



$result = queryMysql(" select account,remark,email,status from user ORDER BY account asc ");
$num    = mysql_num_rows($result);

for ($j = 0 ; $j < $num ; ++$j)
{
    $row = mysql_fetch_row($result);

    echo <<<EOF
       <tr>
          <td>$row[0]</td>
          <td>$row[1]</td>
          <td>$row[2]</td>
          <td>$row[3]</td>
          <td>
              <a href="edituser.php?account=$row[0]"><i class="icon-pencil"></i></a>
          	  <a href="deleteuser.php?account=$row[0]"><i class="icon-remove"></i></a>
              <!--<a href="#myModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>-->
          </td>
        </tr>
EOF;
    
}


echo <<<EOF

      </tbody>
    </table>
</div>
<div class="pagination">
    <ul>
        <li><a href="#">Prev</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</div>
<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">确认</h3>
    </div>
    <div class="modal-body">
        <p class="error-text">您确认删除这个用户吗?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
        <button class="btn btn-danger" data-dismiss="modal">删除</button>
    </div>
</div>

EOF;

include 'bottom.php';
?>
