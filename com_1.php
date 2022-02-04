<html>
<head lang="ja">
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>コンピューターのターン</title>
</head>

<body bgcolor="#fffacd">
<h1 style="text-align:center">コンピューターのターン</h1>

<?php
session_start();
$card = $_SESSION['card'];
//var_dump($card);

//テーブルからカードが無くなったらresult.phpへ
$count = 0;
$count_p = 0;
$count_c = 0;
for($i=0;$i<52;$i++){
  if($card[$i][1]==0||$card[$i][1]==4){
    $count++;
  }elseif($card[$i][1]==1){
    $count_p++;
  }elseif($card[$i][1]==2){
    $count_c++;
  }
}
if($count==0){
  header("location:result.php");
}

//現在の得点の表示
?>
<div align="center">
<font size="7">
<?php echo $count_p/2; ?>
  VS
<?php echo $count_c/2; ?>
<br/>
</font>
</div>
<?php

$turn = 0;
if(isset($_GET['turn'])){
  $turn = $_GET['turn'];
  $turn++;
  //echo $turn;
}

$position = 0;
if(isset($_GET['position'])){
  $position = $_GET['position'];
  //echo $position;
  //echo $card[$position][0]%13;
  $card[$position][1] = 3;
  $_SESSION['card'] = $card;
}

//カードの表示
?>
<div style="text-align:center">
<?php
for($i=0;$i<52;$i++){
  if($card[$i][1]==0||$card[$i][1]==4){ //裏面
    ?>
    <!--<img src="\concentration\trump\card_<?php //echo $card[$i][0]; ?>.png" width="80" height="auto">-->
    <img src="\concentration\trump\card_back.png" width="80" height="auto">
    <?php
  }elseif($card[$i][1]==3){ //表面
    ?>
    <img src="\concentration\trump\card_<?php echo $card[$i][0]; ?>.png" width="80" height="auto">
    <?php
  }else{ //空白
    ?>
    <img src="\concentration\trump\card_blank.png" width="80" height="auto">
    <?php
  }
  if(($i+1)%13==0){
    ?>
    <br/>
    <?php
  }
}
?>
</div>
<?php

//コンピューターの行動の設定
if($turn==0){
  $shuffle = range(0,51);
  shuffle($shuffle);
  //var_dump($shuffle);
  for($i=0;$i<52;$i++){
    if($card[$shuffle[$i]][1]==0||$card[$shuffle[$i]][1]==4){
      $position = $shuffle[$i]; //めくるカードの位置を決定する
      //echo $position;
      break;
    }
  }
  ?>
  <div style="text-align:center;">
  <form action="com_1.php" method="get">
  <input type="submit" value="次へ">
  <input type="hidden" value="<?php echo $turn; ?>" name="turn">
  <input type="hidden" value="<?php echo $position; ?>" name="position">
  </form>
  </div>
  <?php
}elseif($turn==1){
  $shuffle = range(0,51);
  shuffle($shuffle);
  //var_dump($shuffle);
  for($i=0;$i<52;$i++){
    if(($card[$shuffle[$i]][1]==0||$card[$shuffle[$i]][1]==4)&&$position!=$i){
      $random = $shuffle[$i]; //めくるカードの位置を決定する
      break;
    }
  }
  ?>
  <div style="text-align:center;">
  <form action="com_1.php" method="get">
  <input type="submit" value="次へ">
  <input type="hidden" value="<?php echo $turn; ?>" name="turn">
  <input type="hidden" value="<?php echo $random; ?>" name="position">
  </form>
  </div>
  <?php
}elseif($turn==2){
  for($i=0;$i<52;$i++){
    if($i==$position){
    }elseif($card[$i][1]==3){
      if($card[$i][0]%13==$card[$position][0]%13){ //2枚のカードの数字が一致していたらゲット
        $card[$i][1] = 2;
        $card[$position][1] = 2;
        $_SESSION['card'] = $card;
        //echo "成功";
        ?>
        <div style="text-align:center;">
        <form action="com_1.php" method="get">
        <input type="submit" value="次へ">
        </form>
        </div>
        <?php
      }else{ //一致していなかったら裏面に戻す
        $card[$i][1] = 0;
        $card[$position][1] = 0;
        $_SESSION['card'] = $card;
        //echo "失敗";
        ?>
        <div style="text-align:center;">
        <form action="player_1.php" method="get">
        <input type="submit" value="次へ">
        </form>
        </div>
        <?php
      }
    }
  }
}
?>

<form action="concentration.php" method="get">
<input type="submit" value="リセット">
</form>

</body>
</html>
