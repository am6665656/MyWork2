﻿<?php
session_start();
require('../dbconnect.php');
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
	// ↑ログインしている＝（idがセッションに記録されいる。かつ、最後の行動から1時間以内であれば。）
	$_SESSION['time'] = time();
	$members = $db->prepare('SELECT * FROM members WHERE id=?');
	$members->execute(array($_SESSION['id']));
	$member = $members->fetch();
} else {
	// ログインしていない
	header('Location: login.php');
	exit();
}

// htmlspecialcharsのショートカット
function h($value) {
	return htmlspecialchars($value, ENT_QUOTES);
}


// ページが読み込まれたらクイズを表示する
// ランダムにクイズを取ってくる
// SELECT * FROM quiz_book ORDER BY RAND();


$id = (int)$_POST['monme'];
$_SESSION['monme'] = $id;

// $id = $_SESSION['monme'];
$questions = $db->prepare('SELECT * FROM quiz_book WHERE id=:id');
$questions->bindValue( ':id', $_SESSION['monme'], PDO::PARAM_INT);
$questions->execute();
while ($quiz = $questions->fetch()) {
	$_SESSION['question'] = $quiz['question']; 
	$_SESSION['answer'] = $quiz['answer'];
	$_SESSION['choice_a'] = $quiz['choice_a'];
	$_SESSION['choice_b'] = $quiz['choice_b'];
	$_SESSION['choice_c'] = $quiz['choice_c'];
	$_SESSION['genre'] = $quiz['genre'];
	$_SESSION['commentary'] = $quiz['commentary'];
}


/*
$questions = $db->prepare('SELECT * FROM quiz_book WHERE id=1');
$questions->execute(array(
	$_POST['question'],
	$_POST['choice_a'],
	$_POST['choice_b'],
	$_POST['choice_c'],
	$_POST['answer'],
	$_POST['commentary'],
	$_POST['genre']
));
$quiz_book = $question->fetchAll();
*/


//header('Location: post_done.php'); exit();
// ↑次へボタンが押されたら、Headerファンクションで再度同じページ（quiz.php)にジャンプする。
// こうすることで再読み込みボタンやF5からの『フォーム再送信画面』で投稿が重複することを防げる(???)

// footerに問題数を表示 全20問中のn問目
// 

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<title>3択クイズです</title>
<link rel="stylesheet" href="quiz.css" type="text/css">
</head>
<body>

<div id="div1">
  <h1>3択クイズ！</h1>
	<dl>
		<dt><?php echo h($member['user_name']); ?>さんが挑戦中。</dt>
	</dl>
	<div class="header_menu" style="text-align: right">
			<a href="../index.php">TOPへ</a>
			<a href="../logout.php">ログアウト</a>
	</div>
</div>

<div id="div2">
  <p>問題:<?php echo $_SESSION['monme'];?></p>

	<p>
		<?php
	echo h(($_SESSION['question'])).'<br>';
	echo h(($_SESSION['genre'])).'<br>';
		?>
	</p>	
</div>


	<div id="div3">
	  <form action="./answer.php" method="post">
	    <input type="radio" name="kotae" id="kotae" value="<?php echo $_SESSION['choice_a'] ?>" required><label for="1">選択肢A：<?php echo h(($_SESSION['choice_a'])); ?></label><br>
	    <input type="radio" name="kotae" id="kotae" value="<?php echo $_SESSION['choice_b'] ?>"><label for="2">選択肢B：<?php echo $_SESSION['choice_b'] ?></label><br>
	    <input type="radio" name="kotae" id="kotae" value="<?php echo $_SESSION['choice_c'] ?>"><label for="3">選択肢C：<?php echo $_SESSION['choice_c'] ?></label><br>
	    <input type="submit" value="答え">
	  </form>
	</div>


<footer>
	<?php 
	/* クイズの件数を取得 ※今はジャンルが足し算になってるが！！！！？？？？
	const quizlength = (selectで件数取得)
	*/
	//$genre = '足し算';
	//$quiz_count = $db->prepare('SELECT COUNT(*) AS quiz_count FROM quiz_book WHERE genre=:genre');
	//$quiz_count->bindValue( ':genre', $genre, PDO::PARAM_STR);
	$quiz_count = $db->prepare('SELECT COUNT(*) AS quiz_count FROM quiz_book');
	$quiz_count->execute();
	while ($quiz_kensu = $quiz_count->fetch()) {
		$_SESSION['quiz_count'] = $quiz_kensu['quiz_count'];
	}	
	?>

<p>現在、全<?php echo $_SESSION['quiz_count']; ?>問中の<?php echo $_SESSION['monme'];?>問目です</p>
  <a href="../index.php">ログインTOPに戻る</a>
</footer>

<div class=div_debug1>
	<pre><?php	echo 'var_dump($_SESSION)の結果→   ';	var_dump ($_SESSION); ?></pre>
	<pre><?php echo 'print_r($_SESSION)の結果→   '; print_r($_SESSION); ?></pre>
	<pre><?php echo 'print_r($_COOKIE)の結果→   '; print_r($_COOKIE); ?></pre>
	<pre><?php echo 'print_r($_POST)の結果→   '; print_r($_POST); ?></pre>
	<p><?php print_r($quiz);  ?></p>
	<?php
	function console_log($data){
	  echo '<script>';
	  echo 'console.log('.json_encode($data).')';
	  echo '</script>';
	}
	console_log($_SESSION);
	?>

</div>

</body>
</html>