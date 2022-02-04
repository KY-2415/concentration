<html>
<head lang="ja">
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>プレイヤー1のターン</title>
</head>

<body bgcolor="#fffacd">
<h1 style="text-align:center">プレイヤー1のターン</h1>

<?php
session_start();
$card = $_SESSION['card'];
//var_dump($card);

//難易度を設定
if(isset($_GET['difficulty'])){
  if($_GET['difficulty']==1){
    $difficulty = "_1";
    $_SESSION['difficulty'] = $difficulty;
  }else{
    $difficulty = "_2";
    $_SESSION['difficulty'] = $difficulty;
  }
}
$difficulty = $_SESSION['difficulty'];

//対戦相手の設定
if(isset($_GET['vs'])){
  if($_GET['vs']==1){
    $vs = "com";
    $_SESSION['vs'] = $vs;
  }else{
    $vs = "player";
    $_SESSION['vs'] = $vs;
    $difficulty = "_2";
    $_SESSION['difficulty'] = $difficulty;
  }
}
$vs = $_SESSION['vs'];

//後攻ならcom.phpへ
if(isset($_GET['order'])){
  if($_GET['order']==2){
    header("location:com_1.php");
  }
}

//テーブルからカードが無くなったらresult.phpへ
$count = 0;   //テーブルに残っているカードの数
$count_p = 0; //プレイヤーが取得したカードの数
$count_c = 0; //コンピューターが取得したカードの数
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

//開いたカードの位置を設定
$position = 0;
if(isset($_GET['position'])){
  $position = $_GET['position'];
  //echo $position;
  //echo $card[$position][0]%13;
  $card[$position][1] = 3;
  $_SESSION['card'] = $card;
}

//カード（ボタン）の表示・設定
?>
<div style="text-align:center">
<?php
for($i=0;$i<52;$i++){
  if($card[$i][1]==0||$card[$i][1]==4){ //裏面の表示
    ?>
    <div style="display:inline-block;">
    <form action="player_1.php" method="get">
    <?php
    if($turn==2){
      ?>
      <!--<input type="image" src="\concentration\trump\card_<?php //echo $card[$i][0]; ?>.png" width="80" height="auto">-->
      <img src="\concentration\trump\card_back.png" width="80" height="auto">
      <?php
    }else{
      ?>
      <input type="image" src="\concentration\trump\card_back.png" width="80" height="auto">
      <?php
    }
    ?>
    <input type="hidden" value="<?php echo $i; ?>" name="position">
    <input type="hidden" value="<?php echo $turn; ?>" name="turn">
    </form>
    </div>
    <?php
  }elseif($card[$i][1]==3){ //表面の表示
    ?>
    <div style="display:inline-block;">

    <input type="image" src="\concentration\trump\card_<?php echo $card[$i][0]; ?>.png" width="80" height="auto">
    </form>
    </div>
    <?php
  }else{ //空白の表示
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

//判定
if($turn==2){
  for($i=0;$i<52;$i++){
    if($i==$position){
    }elseif($card[$i][1]==3){
      if($card[$i][0]%13==$card[$position][0]%13){ //カードの数字が同じだったらゲット
        $card[$i][1] = 1;
        $card[$position][1] = 1;
        $_SESSION['card'] = $card;
        //echo "成功";
        ?>
        <div style="text-align:center;">
        <form action="player_1.php" method="get">
        <input type="submit" value="次へ">
        </form>
        </div>
        <?php
      }else{
        $card[$i][1] = 4; //一度表にしたカードは記録しておく
        $card[$position][1] = 4;
        $_SESSION['card'] = $card;
        //echo "失敗";
        ?>
        <div >
        <div style="text-align:center;">
        <form action="<?php echo $vs; echo $difficulty; ?>.php" method="get"><!--対戦相手や難易度によってURLを変える-->
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
