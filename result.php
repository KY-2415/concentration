<html>
<head lang="ja">
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>result</title>
</head>

<body bgcolor="#fffacd">
<?php

session_start();
$card = $_SESSION['card'];
$vs = $_SESSION['vs'];

$count_p = 0;
$count_c = 0;
//取得したカードのカウント
for($i=0;$i<52;$i++){
  if($card[$i][1]==1){
    $count_p++;
  }elseif($card[$i][1]==2){
    $count_c++;
  }
}

//結果の表示
if($count_p>$count_c){ //勝ち
  ?>
  <div align="center">
  <font size="7">
  プレイヤー1の勝ち！
  <br/>
  <?php echo $count_p/2; ?>
  VS
  <?php echo $count_c/2; ?>
  </font>
  </div>
  <?php
}elseif($count_p<$count_c){ //負け
  ?>
  <div align="center">
  <font size="7">
  <?php
  if(strcmp("$vs", "com")==0){
    echo "コンピューターの勝ち！";
  }else{
    echo "プレイヤー2の勝ち！";
  }
  ?>
  <br/>
  <?php echo $count_p/2; ?>
  VS
  <?php echo $count_c/2; ?>
  </font>
  </div>
  <?php
}else{
  //引き分け
  ?>
  <div align="center">
  <font size="7">
  引き分け
  <br/>
  <?php echo $count_p/2; ?>
  VS
  <?php echo $count_c/2; ?>
  </font>
  </div>
  <?php
}
?>

<div style="text-align:center;">
<form action="concentration.php" method="get">
<input type="submit" value="メニューに戻る">
</form>
</div>

</body>
</html>
