<?php
//エラー表示してくれる設定
ini_set("display_errors", 1);

//1. POSTデータ取得 💡PHPは送信＆受信だけ
$day =$_POST["day"]; //1
$member = $_POST["member"]; //2
$name = $_POST["name"]; //3
$number = $_POST["number"]; //4
$remark = $_POST["remark"]; //5


//2. DB接続します（phpからDBに接続するものでこういうもの！）
try {
  //Password:MAMP='root',XAMPP='' MAMPはrootだけどXamppはない！
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}



//３．データ登録SQL作成
$sql = "INSERT INTO yoyaku(id,name,number,member,day,remark,indate)VALUES(:id,:name,:number,:member,:day,:remark,sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':day', $day, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':member', $member, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT) pdoのところをコピペでOK
$stmt->bindValue(':number', $number, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT) bindは橋渡
$stmt->bindValue(':remark', $remark, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':indate', $indata, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行役！ true or false



//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
  // SQLErrorって自分で入れて、どこでエラーが起きたかわかるようにしておく。
}else{
  //５．うまくいってたらindex.phpへリダイレクト
  header("Location: input.php");
  exit();
}
?>

<!-- Prepare:DBにクエリをセット
Execute:DBにセットしたクエリを実行 -->
