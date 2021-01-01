<?php
    require '../../restaurant/r_fee.php';
    include '../../db_connect.php';
    //include '';//r_fee.php
    //変数宣言
    $finfo = "";//フロントの顧客情報
    $ffee = "";//追加料金

//顧客情報の表示
function FInformationDetails(){
    global $pdo;
    try{
    //データを持ってくる
    /**
     * コメント
     * ルームナンバーと
     */
    $sql = "SELECT * FROM customer";// WHERE reservation_id = " . $;//部屋番号と宿泊日の
    //SQLステートメントを実行、結果を変数へ格納
    $stmt = $pdo -> query($sql);
    //$stmt -> fetch();
    while($row = $stmt -> fetch()){
    //表示
    $finfo .="<dl>";
    $finfo .='<dt>宿泊日</dt><dd>'. $row['stay_date'].'</dd>';
    $finfo .='<dt>予約日</dt><dd>'. $row['reservation_date'].'</dd>';
    $finfo .='<dt>泊数</dt><dd>'. $row['stay_count'].'</dd>';
    $finfo .='<dt>氏名</dt><dd>'. $row['customer_name'].'</dd>';
    $finfo .='<dt>住所</dt><dd>'. $row['customer_address'].'</dd>';
    
    $finfo .='<dt>電話番号</dt><dd>'. $row['phone_number'].'</dd>';
    $finfo .='<dt>人数</dt><dd>大人：'. $row['adult'].'人、こども：'. $row['child'].'人</dd>';
    $finfo .='<dt>プラン</dt><dd>'. $row['customer_plan'].'</dd>';
    $finfo .='<dt>食事の有無</dt><dd>'. $row['is_denner'].'</dd>';//とりあえず、夕食
    $finfo .='<dt>食事のメニュー</dt><dd>'. $row['dinner_menu'].'</dd>';
    $finfo .='<dt>部屋番号</dt><dd>'. $row['room_1'].'</dd>';
    }
/*
    $finfo .='<dt>追加料金情報</dt><dd></dd>';
    $finfo .='<dt>日付</dt><dd>'. date("Y-m-d").'</dd>';
    //$finfo .='<dt>場所</dt><dd>'. $row['stay_date'].'</dd>';
    $finfo .='<dt>追加料金</dt><dd>'. $row['stay_date'].'</dd>';
    $finfo .='<dt>商品名</dt><dd>'. $row['stay_date'].'</dd>';
    $finfo .='<dt>備考</dt><dd>'. $row['stay_date'].'</dd>';
    $finfo .="</dl>";
*/
    echo $finfo;
    }catch(PDOException $e){
        echo $e->getMessage();
        exit;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
</head>

<body>
    <header>
        <h1>予約情報詳細</h1>
    </header>

    <div id="main">
        <?php FInformationDetails(); ?><!--customer表示-->

        <!--fee表示-->
    </div>
</body>

</html>