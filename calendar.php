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