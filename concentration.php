<html>
<head lang="ja">
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>神経衰弱</title>
</head>

<body bgcolor="#fffacd">
<h1 style="text-align:center">神経衰弱</h1>

<div style="text-align:center;">
<form action="player_1.php" method="get">
順番：
<input type="radio" value="1" name="order" checked>先攻
<input type="radio" value="2" name="order">後攻
<br/>
難易度：
<input type="radio" value="1" name="difficulty" checked>簡単
<input type="radio" value="2" name="difficulty">難しい
<br/>
VS:
<input type="radio" value="1" name="vs" checked>コンピューター
<input type="radio" value="2" name="vs">プレイヤー
<br/>
<input type="submit" value="スタート">
</form>

<form action="rule.php" method="get">
<input type="submit" value="遊び方">
</form>
</div>

<?php
//トランプの設定 randomではなく配列に入れた数値をシャッフルする
$trump = range(1,52);
//var_dump($a);
shuffle($trump);
echo "<br/>";
//var_dump($a);

for($i=0;$i<52;$i++){
  $card[$i][0] = $trump[$i]; //$card[カードの位置][0]=カードの数字
  $card[$i][1] = 0;      //カードの状態(0:テーブル上に残っている 1:プレイヤーが取得 2:コンピュータが取得)
}
//var_dump($card);

session_start();
$_SESSION['card'] = $card;
?>

</body>
</html>
