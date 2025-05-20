<?php
    ini_set('display_errors',1);

    //■サーバー接続
    require "../../DB/connect_wpmain_utf8.php";

    //■セッションに条件などが格納されている場合
    if (!empty($_SESSION['セッション検索語']) ||!empty($_SESSION['セッション役職']) || !empty($_SESSION['セッション役割'])) {
        //●条件類を変数に格納
        $表示件数 = $_SESSION['セッション表示件数'];
        $検索語 = $_SESSION['セッション検索語'];
        $開始位置 = $_SESSION['セッション開始位置'];
        $分岐 = $_SESSION['セッション分岐値'];
        $役職 = $_SESSION['セッション役職'];
        $役割 = $_SESSION['セッション役割'];
        $order = $_SESSION['セッションオーダー'];
        

        //var_dump($役職);
        //print($_SESSION['セッション役職']);  

        $correct_MEEMPLOYMENT = "CASE MEFULLNAME 
                                    WHEN '高田静夫' THEN 900 
                                    WHEN '細野和香奈' THEN 750 
                                    WHEN '山本晃司' THEN 750 
                                    WHEN '松下和樹' THEN 750 
                                    WHEN '根津恵理' THEN 750 
                                    WHEN '具志堅敦紀' THEN 750 
                                    WHEN '谷口優人' THEN 750 
                                    WHEN '中津文里' THEN 750 
                                    WHEN '福岡千景' THEN 750 
                                    WHEN '林田尚文' THEN 750 
                                    WHEN '美坐辰彦' THEN 750 
                                    WHEN '川嶋拓' THEN 750 
                                    WHEN '石井佑典' THEN 750 
                                    ELSE MEEMPLOYMENT
                                END";
        $correct_MEAUTHORITY_APP = "CASE MEFULLNAME
                                        WHEN '高田静夫' THEN 900 
                                        WHEN '細野和香奈' THEN 800
                                        WHEN '山本晃司' THEN 600
                                        WHEN '松下和樹' THEN 200
                                        WHEN '根津恵理' THEN 200
                                        WHEN '具志堅敦紀' THEN 200
                                        WHEN '谷口優人' THEN 200
                                        WHEN '中津文里' THEN 200
                                        WHEN '福岡千景' THEN 200
                                        WHEN '林田尚文' THEN 200
                                        WHEN '美坐辰彦' THEN 200
                                        WHEN '川嶋拓' THEN 200
                                        WHEN '石井佑典' THEN 200
                                        ELSE MEAUTHORITY_APP
                                    END" ;
        
        $display_positionname = "CASE MEFUNCTION
                                        WHEN 501 THEN name_g 
                                        ELSE NULL
                                    END";

        //■クエリの構築
        $sql1 = "SELECT MECD,
                        MEUSERID,
                        MESEIKANA,
                        MEMEIKANA,
                        MEFULLNAME,
                        MEDATEOFENTER,
                        MEDATEOFQUIT,
                        MEユニット長フラグ,
                        MEGRADE,
                        MEGRADE_sub,
                        MEFUNCTION,
                        MEOFFICE_LOAN,
                        MEUNIT,
                        METEAM,
                        METEL,
                        MEINVALIDFLAG,
                        MEEMPLOYMENT,
                        MEAUTHORITY_APP,
                        tm_wpteam.name AS teamname,
                        tm_wpunit.name AS unitname,
                        tm_wpunit.sort AS unitsort,
                        tm_wpoffice.id AS officeid,
                        tm_wpteam.sort AS teamsort,
                        tm_wpdepartment.name AS departmentname,
                        officename,
                        name_g,
                        ".$correct_MEEMPLOYMENT."
                         AS correct_MEEMPLOYMENT,
                        ".$correct_MEAUTHORITY_APP."
                         AS correct_MEAUTHORITY_APP,
                        ".$display_positionname."
                         AS display_position
                    FROM tm_member
                        INNER JOIN tm_wpunit ON tm_member.MEUNIT = tm_wpunit.id
                        INNER JOIN tm_wpteam ON tm_member.METEAM = tm_wpteam.id
                        INNER JOIN tm_wpdepartment ON tm_wpunit.department = tm_wpdepartment.id
                        FULL OUTER JOIN tm_wpoffice ON tm_member.MEOFFICE_LOAN = tm_wpoffice.id
                        INNER JOIN tm_wpgrade ON tm_member.MEGRADE = tm_wpgrade.id
                            WHERE MEINVALIDFLAG = '0'";


        //■最初の条件を取り出す
        $whereClause = "";//●分岐・検索語用
        $whereClause1 = "";//●役職用
        $whereClause2 = "";//●役割用
        
        //■プルダウンでその他カテゴリーが選択されていた場合、検索語はNULLで検索
        if (!empty($検索語)) {
            foreach ($検索語 as $key => $value) {
                if ($value === "その他カテゴリー") {
                    $検索語[$key] = null; // ●"その他カテゴリー" を NULL に置き換える
                }
            }
        
            //■分岐と検索語を繋げてWHERE文の一部を作成
            $whereConditions = array();
            foreach ($検索語 as $value) {
                if ($value === null) {
                    $whereConditions[] = $分岐 . ' IS NULL'; //●NULL の場合は IS NULL を追加
                } else {
                    $whereConditions[] = $分岐 . " = '" . $value . "'"; //●それ以外の場合は通常の比較
                }
            }
            $whereClause .= implode(' OR ', $whereConditions);
        }

        //■SQLのWHERE文追加
        //■役職where文
        if(!empty($役職)){
            $positions = array();
            foreach ($役職 as $value) { 
                $positions[] = "($display_positionname) = '" . $value . "'";
            }
            
            if (!empty($positions)) {
                $whereClause1 .= '(' . implode(' OR ', $positions) . ')';
            }
        }
        //■役割where文
        if (!empty($役割)) {
            $roles = array();
            
            foreach ($役割 as $value) {
                if ($value === "担当役員") {
                    $roles[] = "($correct_MEEMPLOYMENT) = 900";
                }else
                if ($value === "エリア・カテゴリー長") {
                    $roles[] = "($correct_MEAUTHORITY_APP) = 900";
                }else
                if ($value === "ユニット長") {
                    $roles[] = "($correct_MEAUTHORITY_APP) = 800";
                }else
                if ($value === "チームリーダー") {
                    $roles[] = "($correct_MEAUTHORITY_APP) = 600";
                }else{
                    $roles[] = "NOT (($correct_MEEMPLOYMENT) = 900 
                                    OR ($correct_MEAUTHORITY_APP) = 900
                                    OR ($correct_MEAUTHORITY_APP) = 800
                                    OR ($correct_MEAUTHORITY_APP) = 600
                                    )";
                                    
                }
                
            }
            
            //■$rolesが空でない場合、WHERE文に追加
            if (!empty($roles)) {
                $whereClause2 .= '(' . implode(' OR ', $roles) . ')';
            }
        }
        //print($whereClause);
        //print($whereClause1);
        //print($whereClause2);

        //■完成したWHERE文を使ってクエリを構築
        if (!empty($whereClause)) {
            if(!empty($whereClause1)){
                if(!empty($whereClause2)){
                    $sql1 .= " AND (" . $whereClause . ") AND" . $whereClause1. "AND" . $whereClause2;

                }else{
                    $sql1 .= " AND (" . $whereClause . ") AND" . $whereClause1;
                }
            }else{
                if(!empty($whereClause2)){
                    $sql1 .= " AND (" . $whereClause . ") AND" . $whereClause2;
                }else{
                    $sql1 .= " AND (" . $whereClause . ") ";
                }
            }
        }else{
            if(!empty($whereClause1)){
                if(!empty($whereClause2)){
                    $sql1 .= " AND (". $whereClause1. "AND" . $whereClause2 .") ";
                }else{
                    $sql1 .= " AND (". $whereClause1.") ";
                }
            }else{
                if(!empty($whereClause2)){
                    $sql1 .= " AND (". $whereClause2 .") ";
                }else{
                }
            }
        }

        $sql1 .= $order;
        
        //print($sql1); 
    }


    //■データベースアクセス
    if (empty($whereClause) && empty($whereClause1) && empty($whereClause2)) {
            print("条件入れて（表示用）");
            exit;    
    }else{
        $DATA = sqlsrv_query($con_wpmain, $sql1); 
        $result = array();
        while($row = sqlsrv_fetch_array($DATA, SQLSRV_FETCH_ASSOC)){
            /*
            if ($row['area'] === NULL) {
                $row['area'] = 'その他カテゴリー';
            }
                */
            $result[] = $row;
        }
    }

    //var_dump($result);

    //■データベース接続チェック
    if($DATA === false){
        print ('実行に失敗');
    }
    if($DATA === null){
        print ('値がありません');
    }
    if (empty($DATA) === true) {
        print("該当データはありませんでした。"); 
    }

    $件数 = count($result);//●結果行数の取得
   //echo $件数;
?>

    <?php
    if($件数 == 0){ 
        //■検索結果がないとき諸々を表示しない
        print "<script>jQuery(function(){
            document.getElementById('paging-header').style.visibility='hidden';
            document.getElementById('paging-button').style.visibility='hidden';
            document.getElementById('paging-button2').style.visibility='hidden';
        })
        $('#csv-btn').prop('disabled', true); // csv出力ボタンを無効化
        </script>";
        
        //■エラーメッセージ
        print "<script>noDataErrorBox();</script>";

        //■変数総検索数に値を挿入
        print "<script> var 総検索数 = 'なし';</script>";
        exit;


    }else{    
        $総検索数 = $件数;//●JS受け渡し用
    }

    //■行指定用SQL
    //●$spl1をCSV用に使い回すために分ける
    $sql2 = "";
    $sql2 = $sql1." offset $開始位置 rows fetch next $表示件数 rows only";
    //echo "$sql2";


    $DATA1 = sqlsrv_query($con_wpmain, $sql2);//●行単位で表示するためクエリを再実行
    $result1 = array();
    while($row1 = sqlsrv_fetch_array($DATA1, SQLSRV_FETCH_ASSOC)){
        /*
        if ($row1['area'] === NULL) {
            $row1['area'] = 'その他カテゴリー';
        }
            */
        $result1[] = $row1;
    }
    //var_dump($result1);
    
 





    ///////////////////////////////////////
    //CSV作成//////////////////////////////
    ///////////////////////////////////////

    $dyn3 = sqlsrv_query($con_wpmain, $sql1);


    if($dyn3 === false){
        print ('接続失敗（CSV）');
    }
    if($dyn3 === null){
        print ('値なし（CSV）');
    }
    if (empty($dyn3) === true) {
        print("該当データはありませんでした（CSV）");
    }


    //■CSVヘッダ
    $csvstr = "USERID,氏名,部,拠点,ユニット,チーム,メールアドレス,社用TEL,入社日,社歴(日切り捨て),社歴(日数表示),役職,役割,グレード,SPグレード,出力時日付 \r\n";

    //■CSV中身
    while ($row3 = sqlsrv_fetch_array($dyn3, SQLSRV_FETCH_ASSOC)) {
        $csvstr .= $row3["MEUSERID"] . ",";//●ID
        $csvstr .= $row3["MEFULLNAME"] . ",";//●氏名
        //$csvstr .= $row3["area"] . ",";//●エリア
        $csvstr .= $row3["departmentname"] . ",";//●部
        $csvstr .= $row3["officename"] . ",";//●拠点
        $csvstr .= $row3["unitname"] . ",";//●ユニット
        $csvstr .= $row3["teamname"] . ",";//●チーム
        $csvstr .= $row3["MEUSERID"]."@workport.co.jp,";//●メアド
        $csvstr .= $row3["METEL"] . ",";//●社用TEL
        $csvstr .= $row3["MEDATEOFENTER"] . ",";//●入社日
    
        $today = date("Y-m-d");
        $day1 = new DateTime(date("Y-m-d", strtotime($row3["MEDATEOFENTER"])));
        $day2 = new DateTime($today);
        $interval = $day1->diff($day2);
        $year = $interval->format('%y');
        $month = $interval->format('%m');
        if($year == 0){  
        $csvstr .= $month."ヶ月,";//●社歴(日切り捨て)
        }else{
        $csvstr .= $year."年".$month."ヶ月,";//●社歴(日切り捨て)
        }
    
        $days = $interval->format('%a');
        $csvstr .= $days . ",";//●在籍年数（日数表示）


        if($row3["MEFULLNAME"] == "細野和香奈"){
            $csvstr .= "マネージャー" . ",";//●役職（システムは業務上役職などを変更している場合があるため）
        }elseif($row3["MEFULLNAME"] == "高田静夫" ){
            $csvstr .= "執行役員" . ",";//●役職
        }elseif($row3["MEFULLNAME"] == "山本晃司"){
            $csvstr .= "リーダー" . ",";//●役職
        }elseif($row3["MEFULLNAME"] == "松下和樹" ||
                $row3["MEFULLNAME"] == "根津恵理" ||
                $row3["MEFULLNAME"] == "具志堅敦紀" ||
                $row3["MEFULLNAME"] == "谷口優人" ||
                $row3["MEFULLNAME"] == "中津文里" ||
                $row3["MEFULLNAME"] == "福岡千景" ||
                $row3["MEFULLNAME"] == "林田尚文" ||
                $row3["MEFULLNAME"] == "美坐辰彦" ||
                $row3["MEFULLNAME"] == "川嶋拓" ||
                $row3["MEFULLNAME"] == "石井佑典"){
            $csvstr .= "" . ",";//●役職
        }else{
            
            if($row3["MEFUNCTION"]==501){
                $csvstr .= $row3["name_g"] . ",";//●役職
            }else{
                $csvstr .= "" . ",";//●役職
            }
        }

        if($row3["MEFULLNAME"] == "高田静夫" ){
            $csvstr .= "担当役員" . ",";//●役割
        }elseif($row3["MEFULLNAME"] == "細野和香奈"){
            $csvstr .= "ユニット長" . ",";//●役割
        }elseif($row3["MEFULLNAME"] == "山本晃司"){
            $csvstr .= "チームリーダー" . ",";//●役割
        }elseif($row3["MEFULLNAME"] == "松下和樹" ||
                $row3["MEFULLNAME"] == "根津恵理" ||
                $row3["MEFULLNAME"] == "具志堅敦紀" ||
                $row3["MEFULLNAME"] == "谷口優人" ||
                $row3["MEFULLNAME"] == "中津文里" ||
                $row3["MEFULLNAME"] == "福岡千景" ||
                $row3["MEFULLNAME"] == "林田尚文" ||
                $row3["MEFULLNAME"] == "美坐辰彦" ||
                $row3["MEFULLNAME"] == "川嶋拓" ||
                $row3["MEFULLNAME"] == "石井佑典"){
            $csvstr .= "メンバー" . ",";//●役割
        }else{
            if($row3["correct_MEEMPLOYMENT"] == 900){
                $csvstr .= "担当役員" . ",";
            }elseif($row3["correct_MEAUTHORITY_APP"] == 900){
                $csvstr .= "エリア・カテゴリー長" . ",";
            }elseif($row3["correct_MEAUTHORITY_APP"] == 800){
                $csvstr .= "ユニット長" . ",";
            }elseif($row3["correct_MEAUTHORITY_APP"] == 600){
                $csvstr .= "チームリーダー" . ",";
            }else{
                $csvstr .= "メンバー" . ",";//●役割
            }
        }
    
        $csvstr .= $row3["MEGRADE"] . ",";//●グレード
        $csvstr .= $row3["MEGRADE_sub"] . ",";//●SPグレード
    
        $today2 = date("Ymd");
        $csvstr .= $today2 . "\r\n";//●出力時日付！！
        }
                                      
                              
        //■CSVファイル作成ファンクション
        function putCsv($data) {

            //●CSVファイルパス名
            $csvFileName = '../payroll/memberSearchList.csv';
                  
            //●ファイルを開く
            $row5 = fopen($csvFileName, 'w');
            if ($row5 === FALSE) {
                throw new Exception('ファイルの書き込みに失敗しました。');
            }

            //●文字コード変換。エクセルで開けるようにする
            $data = mb_convert_encoding($data,'SJIS', 'UTF-8');

            //●ファイルに書き出しをする
            fwrite($row5, $data);

            //●ファイルを閉じる
            fclose($row5);
        }

        //■CSVファイルを作成
        putCsv($csvstr);

            
        
?>