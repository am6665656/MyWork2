<?php
session_start();
require('../dbconnect.php');
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
	// ↑ログインしている＝（idがセッションに記録されいる。かつ、最後の行動から1時間以内であれば。）
	$_SESSION['time'] = time();
	$members = $db->prepare('SELECT * FROM members WHERE id=?');
	$members->execute(array($_SESSION['id']));
	$member = $members->fetch();
} else {
  header('Location: ../login.php');
	// ↑ログインしていない
	exit();
}

// htmlspecialcharsのショートカット
function h($value) {
  return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

/*

function h($value) {
  if (is_array($value)) {
    return array_map("h", $value);
  } else {
    return h($value, ENT_QUOTES, "UTF-8");
  }
}


function myhtmlspecialchars($string) {
  if (is_array($string)) {
    return array_map("myhtmlspecialchars", $string);
  } else {
    return htmlspecialchars($string, ENT_QUOTES);
  }
}
*/


/*
*/
////// もし投稿画面で投稿ボタンが押されている場合(＝$_POST（句）が空でない場合)には、投稿情報をセッションに保存。
if(!empty($_POST['kamigo']) || !empty($_POST['nakashichi']) || !empty($_POST['shimogo'])){    //俳句投稿がpostで送られてきたら。（＝$_POST変数がが空でなければ。）
  //投稿内容（$_POST）を$_SESSIONに保存。
  $_SESSION['kamigo'] = $_POST['kamigo'];
  $_SESSION['nakashichi'] = $_POST['nakashichi'];
  $_SESSION['shimogo'] = $_POST['shimogo'];
  /*
  global $g_nakashichi;
  $g_nakashichi = array_column($_SESSION, 'nakashichi');
  $g_nakashichi = string($_SESSION['nakashichi']);
  global $g_kamigo;
  $g_kamigo = $_SESSION['kamigo'];
  global $g_shimogo;
  $g_shimogo = $_SESSION['shimogo'];
  */
} 


////// 音の数をカウント。

//【チェック①】音の数をカウント ＝ 文字数ー（小さいゃゅょﾔﾕﾖの数）
$mojinokazukami = mb_strlen($_POST['kamigo']);
$mojinokazunaka = mb_strlen($_POST['nakashichi']);
$mojinokazushimo = mb_strlen($_POST['shimogo']);

//【チェック②（内部用）】小さいゃゅょﾔﾕﾖの数をカウント
$yayuyonokazukami = preg_match_all('/([ゃ-ょャ-ョ])/u', $_POST['kamigo']);
$yayuyonokazunaka = preg_match_all('/([ゃ-ょャ-ョ])/u', $_POST['nakashichi']);
$yayuyonokazushimo = preg_match_all('/([ゃ-ょャ-ョ])/u', $_POST['shimoigo']);

//【チェック③】音の数をカウント ＝ 文字数ー（小さいゃゅょﾔﾕﾖの数）
$otonokazukami = $mojinokazukami - $yayuyonokazukami;    // 文字数 - ( [ゃ-ょャ-ョ]の数 )
$otonokazunaka = $mojinokazunaka - $yayuyonokazunaka;
$otonokazushimo = $mojinokazushimo - $yayuyonokazushimo;



////// 投稿内容に何かしらエラーあれば、、まずエラー用変数にエラーメッセージを格納。
//// 入力チェック 上の句
//【上の句CHECK⓪】投稿ボタン押されたが入力無しなら、エラーMSGを変数に格納。
if(!empty($_POST['done']) && empty($_POST['kamigo'])) {
  $errorKami[] = 'NG! 上の句を入力してください<br>';
}
//【チェック①】投稿ボタン押されたが、平仮名カタカナのみで構成されていなければエラーMSGを変数に格納。
if (!preg_match("/^[ぁ-ゞァ-ヾ]+$/u", $_POST['kamigo']) && !empty($_POST['done'])){
  $errorKami[] = 'NG! 上の句を平仮名のみにして下さい';
} 
//【チェック②】
if (!empty($_POST['done']) && ($otonokazukami <=3 || $otonokazukami >= 7 )) {
  $errorKami[] = 'NG！上の句の「音数」は4音～6音にして下さい';
}
//【チェック③】投稿した上の句'のなかに'課題のランダム文字'が含まれていないならエラー
if(!empty($_POST['done']) && strpos($_SESSION["kamigo"],$_SESSION["kami_random"]) === false){
  $errorKami[] = 'NG! 上の句に課題文字『' . $_SESSION['kami_random'] .'』を最低1回含めてください！<br>';
}
/*
if(!empty($_POST['done']) && (strstr($_SESSION['kamigo'],$_SESSION['kami_random']) ==false)){
  $errorKami[] = 'NG! 上の句：課題文字『' . $_SESSION['kami_random'] .'』ナシ！<br>';
}
*/

//// 入力チェック 中の句
//【中の句CHECK⓪】投稿ボタン押されたが入力無しなら、エラーMSGを変数に格納。
if(!empty($_POST['done']) && empty($_POST['nakashichi'])) {
  $errorNaka[] = 'NG! 中の句を入力してください<br>';
};
//【チェック①】投稿ボタン押されたが、平仮名カタカナのみで構成されていなければエラーMSGを変数に格納。
if (!empty($_POST['done']) && !preg_match("/^[ぁ-ゞァ-ヾ]+$/u", $_POST['nakashichi'])){
    $errorNaka[] = 'NG! 中の句を平仮名のみにしてください';;
} 
//【チェック②】
if (!empty($_POST['done']) && ($otonokazunaka < 6 || $otonokazunaka > 8 )) {
  $errorNaka[] = 'NG！中の句の「音数」は6音～8音にして下さい';
}
//【チェック③】投稿した中の句'のなかに'課題のランダム文字'が含まれていないならエラー
if(!empty($_POST['done']) && strpos($_SESSION["nakashichi"],$_SESSION["naka_random"]) === false){
  $errorNaka[] = 'NG! 中の句に課題文字『' . $_SESSION['naka_random'] .'』を最低1回含めてください！<br>';
} 

//// 入力チェック 下の句
//【下の句CHECK⓪】投稿ボタン押されたが入力無しなら、エラーMSGを変数に格納。
if(!empty($_POST['done']) && empty($_POST['shimogo'])) {
  $errorShimo[] = 'NG! 下の句を入力してください<br>';
};
//【チェック①】投稿ボタン押されたが、平仮名カタカナのみで構成されていなければエラーMSGを変数に格納。
if (!preg_match("/^[ぁ-ゞァ-ヾ]+$/u", $_POST['shimogo']) && !empty($_POST['done'])){
  $errorShimo[] = 'NG! 下の句を平仮名のみにして下さい';;
}
//【チェック②】
if (!empty($_POST['done']) && ($otonokazushimo < 4 || $otonokazushimo > 6 )) {
  $errorShimo[] = 'NG！下の句の「音数」は4音～6音にして下さい';
}
//【チェック③】投稿した下の句'のなかに'課題のランダム文字'が含まれていないならエラー
if(!empty($_POST['done']) && strpos($_SESSION["shimogo"],$_SESSION["shimo_random"]) === false){
  $errorShimo[] = 'NG! 下の句に課題文字『' . $_SESSION['shimo_random'] .'』を最低1回含めてください！<br>';
} 



//// $error変数が空でないなら何かエラーがあるので、投稿画面にてエラーを表示する。
////↓投稿の結果、エラーが何も無ければ、投稿確認画面へリダイレクトさせる。
if (empty($errorKami) && empty($errorNaka) && empty($errorShimo) && !empty($_POST['done'])){
  header('Location: haiku_confirmation.php'); 
  //exit();            
}
//エラーがあれば、投稿画面でエラーを表示。
//(考え中)
//echo '条件を満たしていません'; 


/*
*/

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>お遊び俳句ゲーム [MyPf]</title>
<link rel="stylesheet" href="haiku.css">
</head>
<body>

<div class="wrap">
  <div class="header">
    <h1>お遊び俳句ゲーム<h1>
    <h1>開始！</h1> 
    <div class="header_menu" style="text-align: right">
            <a href="haiku_gamelevel.php" class="btn">前の画面に戻る</a>
            <a href="../menu.php" class="btn">TOPへ</a>
            <a href="../logout.php" class="btn">ログアウト</a>
    </div>
  </div>




  <div class="contents">
  
    <p>【課題文字】</p>

    <?php
      //課題文字を表示。課題文字がnullなら「条件なし」。【【左記以外は何かおかしい、つまりerror】】
      if ($_SESSION['kami_random'] == null) {
        echo '<p>上の句 : 条件なし。</p>';
      } else if($_SESSION['kami_random'] != null) {
        echo '<p>上の句のどこかに 『' . $_SESSION['kami_random'] . '』を最低1回含めること。</p>';
      } else {
        echo '<p>error! something wrong!</p>';
      } 

      if ($_SESSION['naka_random'] == null) {
        echo '<p>中の句 : 条件なし。</p>';
      } else if($_SESSION['naka_random'] != null) {
        echo '<p>中の句のどこかに 『' . $_SESSION['naka_random'] . '』を最低1回含めること。</p>';
      } else {
        echo '<p>error! something wrong!</p>';
      } 

      if ($_SESSION['shimo_random'] == null) {
        echo '<p>下の句 : 条件なし。</p>';
      } else if($_SESSION['shimo_random'] != null) {
        echo "<p>下の句のどこかに 『" . $_SESSION['shimo_random'] . "』を最低1回含めること。</p>";
      } else {
        echo '<p>error! something wrong!</p>';
      } 

      
      
      ?>
    <br>
    <form action="" method="post">
      <label for="kamigo">上の句:</label>
      <input type="text" id="kamigo" name="kamigo" size="40" value="<?php echo h($_SESSION['kamigo']); ?>"><br>
        <?php
          //上の句に何かしらエラー有れば、エラーメッセージをすべて表示する。
          if (!empty($errorKami)) {
            foreach ($errorKami as $errorK) {
              echo '<p class="error">' .$errorK . '</p>' ;
            }
          }
        ?>
      <label for="nakashichi">　　　　　　　中の句:</label>
      <input type="text" id="nakashichi" name="nakashichi" size="40" value="<?php echo h($_SESSION['nakashichi']); ?>"><br>
        <?php 
          //中の句に何かしらエラー有れば、エラーメッセージをすべて表示する。
          if (!empty($errorNaka)) {
            foreach ($errorNaka as $errorN) {
              echo '<p class="error">' .$errorN . '</p>' ;
            }
          }
        ?>  
      <label for="shomogo">下の句:</label>  
      <input type="text" id="shimogo" name="shimogo"  size="40" value="<?php echo h($_SESSION['shimogo']); ?>">
      <?php 
          //下の句に何かしらエラー有れば、エラーメッセージをすべて表示する。
          if (!empty($errorShimo)) {
            foreach ($errorShimo as $errorS) {
              echo '<p class="error">' .$errorS . '</p>' ;
            }
          }
        ?>  
      <br>
      <br>
      <!-- 
        <label for="nakashichi">全体(ひらがなを漢字交じりにしたもの): ※漢字OK</label></br>   
        <textarea id="zentai" name="zentai" rows="10" cols="40" ></textarea><br>
      -->
      <input type="hidden" name="done" value="1">
      <input type="submit" value="投稿内容の確認">
    </form>
    <br>
</div>

<div class="rules">
      <p class="rules">【基本ルール】</p>
      <p class="rules">&nbsp;&nbsp;・上の句は６～８音、中の句は4~6音、</p>
      <p class="rules">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;下の句は６～８音にして下さい。</p>
      <p class="rules">&nbsp;&nbsp;・『ひらがなのみ』で俳句を書いてください</p>
      <p class="rules">&nbsp;&nbsp;・使用可能な文字：「あ～を」まで。</p>
      <p class="rules">&nbsp;&nbsp;・課題文字については大文字、小文字、</p>
      <p class="rules">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;濁音半濁音の有無、は区別されます。</p>
      <p class="rules">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;例えば...「や」と「ゃ」、「あ」と「ぁ」、「か」と</p>
      <p class="rules">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;「が」、「は」と「ぱ」、「お」と「を」は区別されます。</p>
</div>

<div class="footer">
  <p>　　　　　　　　　　</p>
</div>


<div class=div_debug1>
<?php
/////入力文字チェック【絶対消すな！！】////////////////////////////////////////
////////////////////////////////////////////////////////////
echo '<h3>総合チェック</h3>';
echo '【チェック①文字数】 入力した文字数は上の句-' . $mojinokazukami .",中の句-" .  $mojinokazunaka .",下の句-" .  $mojinokazushimo . 'です';
echo '<br>';
echo '【チェック②（内部用）】小さいゃゅょﾔﾕﾖの数は' . $yayuyonokazukami ."," . $yayuyonokazunaka ."," . $yayuyonokazushimo;
echo '<br>';
echo '【チェック③】「音数」は上の句-' .  $otonokazukami .",中の句-" . $otonokazunaka .",下の句-" . $otonokazushimo .'です';
echo '<br>';

?>


  <p>■今後の予定■
    ・条件を満たさないと投稿できないようにする
    　（①文字含むstrposかstrstrかpreg_matchか。。　
    　　②$_session,$_post両方チェックせねばダメ？？→ajax覚えた方が早い？？？？
    　　③音数チェック
    ・ゲーム開始時にエラーが出てしまう
    ・セッションクリアのタイミング（＋　unset $_SESSIONがwarningになる。。）
    ・エラー文字が赤くならない（他のCSSは聞いているのに。。）
  </p>  
  <p>■デバッグ用（変数の確認)■</p>
  <pre><?php	echo 'var_dump($_SESSION)の結果→   ';	var_dump ($_SESSION); ?></pre>
  <pre><?php echo 'print_r($_SESSION)の結果→   '; print_r($_SESSION); ?></pre>
  <pre><?php echo 'print_r($_COOKIE)の結果→   '; print_r($_COOKIE); ?></pre>
  <pre><?php echo 'print_r($_POST)の結果→   '; print_r($_POST); ?></pre>
  <pre><?php echo 'print_r($errorKami)の結果→   '; print_r($errorKami); ?></pre>
  <pre><?php echo 'print_r($errornaka)の結果→   '; print_r($errorNaka); ?></pre>
  <pre><?php echo 'print_r($errorshimo)の結果→   '; print_r($errorShimo); ?></pre>


</div>

</body>
</html>
