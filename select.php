<?php
//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $dbh = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root',''); //とりあえず情報入れる
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM yoyaku"; //table名
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}

function getreservation(){
  $dsn='mysql:dbname=gs_db;host=localhost;charset=utf8';
  $user='root';
  $pass='';
  $dbh = new PDO($dsn,$user,$pass);
  $ps = $dbh->query("SELECT * FROM yoyaku");
  $reservation_member = array(); //各日付の予約人数を$reservation_memberへ入れるための配列を用意する
  
  foreach($ps as $out) { //情報を全て$outに入れる
    $day_out = strtotime((string) $out['day']);
    $member_out =(string) $out['member'];
    $reservation_member[date('Y-m-d',$day_out)] = $member_out;
  }
    return $reservation_member;
} 

  //getreservation関数を$reservation_arrayに代入しておく
  $reservation_array = getreservation();

  // Calendarの日付と予約された日付を照合する関数
  function reservation($date,$reservation_array){
    if(array_key_exists($date,$reservation_array)){
        if($reservation_array[$date] >= 10){
          $reservation_member = "<br/>"."<span class = 'green'>"."予約できません"."</span>";
          return $reservation_member;
        }
        else{

          $reservation_member = "<br/>"."<span class = 'green'>".$reservation_array[$date]."人"."</span>";
          return $reservation_member;
        }
    }
  }
      

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!-- **********************************************************************************************************************************************
Calendar表示
********************************************************************************************************************************************** -->

<?php
//timezone
date_default_timezone_set('Asia/Tokyo');

//previous month or next month
if(isset($_GET['ym'])){
  $ym=$_GET['ym'];
}else{
  //this month
  $ym = date('Y-m');
}

//timestamp
//strtotime('Y-m-01);
$timestamp = strtotime($ym . '-01');
//エラーが返ってきたら現在時刻を取得
if($timestamp === false){
  $ym = date('Y-m');
  $timestamp = strtotime($ym . '-01');
}

$today = date('Y-m-j'); //jはゼロ埋めなし。ありはd
$html_title= date('Y年n月',$timestamp); //date(表示する内容,基準)
$prev= date('y-m',strtotime('-1 month',$timestamp));
$next= date('y-m',strtotime('+1 month',$timestamp));
$day_count = date('t',$timestamp); //tは月の日数の意味、l(曜日英語)d(曜日短縮)
$youbi=date('w',$timestamp); //1日が何曜日か。sunday=0

//初期化
$weeks= [];//配列
$week=''; //文字列


//first week
//str_repeat関数
if($youbi>0){
$week .= str_repeat('<td></td>',$youbi);
}//月書が日曜($youbi=0)の場合は空白セルはいらない

for($day=1; $day<=$day_count;$day++,$youbi++){
  $date=$ym.'-'.$day; //2020-00-00

  if($today==$date){
    $week.= '<td class="today">'.$day; //今日の場合はクラスをつける
  }else{
    $week.='<td>'.$day;
  }
  $week.='</td>';

  if($youbi %7==6 || $day == $day_count){ //しゅう終わり、月終わりの場合、
    if($day==$day_count){//月の最終日に空白セルを追加する
      $week.=str_repeat('<td></td>',6-($youbi%7));
    }
    $weeks[]='<tr>'.$week.'</tr>'; //weeks配列にtrと$weekを追加

    $week =''; //weekをリセット
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>PHPカレンダー</title>
    <link rel="stylesheet" href="/php02/css/calendar.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    
</head>
<body>
    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a><?php echo $html_title; ?><a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
            foreach($weeks as $week){
              echo $week;
            }
            ?>
        </table>
    </div>
    
</body>
</html>