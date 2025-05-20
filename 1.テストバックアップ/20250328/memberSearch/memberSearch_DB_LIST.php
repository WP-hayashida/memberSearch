<?php
//■エラー表示
ini_set('display_errors', 1);
//■検索条件セッション受け取りPHP
require "memberSearch_session.php";

//■SQL生成ファイル
require "memberSearch_search_SQL0.php";

function S($var)
{
    $var = mb_convert_encoding($var, "SJIS", "UTF-8");
    return $var;
}
?>

<?php
//■テーブル
print "<table class='LIST' style='margin-top:15px; border:1px solid #999; border-collapse: collapse;'>";

//■テーブル見出し
print "<tr id='box-header' style='height: 28px; background-color: lightslategray;' >
    <th style='width:10% ;' rowspan='2'>USERID</th>
    <th style='width:12%; ' rowspan='2'>
        <span style='vertical-align:middle'>
            氏名
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort1' type='submit' style='cursor: pointer;' value='sort1'>
            <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort2' type='submit' style='cursor: pointer;' value='sort2'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th style='width:10%;'>
        <span style='vertical-align:middle'>
            部
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort15' type='submit' style='cursor: pointer;' value='sort15'>
            <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort16' type='submit' style='cursor: pointer;' value='sort16'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th style='width:20%;'>
        <span style='vertical-align:middle'>
            ユニット
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort17' type='submit' style='cursor: pointer;' value='sort17'>
            <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort18' type='submit' style='cursor: pointer;' value='sort18'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th style='width:16%;'>メールアドレス</th>
    <th style='width:10%;'>
        <span style='vertical-align:middle'>
            入社日
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort3' type='submit' style='cursor: pointer;' value='sort3'>
                <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort4' type='submit' style='cursor: pointer;' value='sort4'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th style='width:11%;'>                    
        <span style='vertical-align:middle'>
            職位
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort5' type='submit' style='cursor: pointer;' value='sort5'>
                <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort6' type='submit' style='cursor: pointer;' value='sort6'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>           
    </th>
    <th style='width:11%;'>   
        <span style='vertical-align:middle'>
            グレード
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort7' type='submit' style='cursor: pointer;' value='sort7'>
                <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort8' type='submit' style='cursor: pointer;' value='sort8'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>  
    </th>";

print "<tr id='box-header' style='height: 28px; background-color: lightslategray;'>
    <th>
        <span style='vertical-align:middle'>
            拠点
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort19' type='submit' style='cursor: pointer;' value='sort19'>
            <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort20' type='submit' style='cursor: pointer;' value='sort20'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th>
        <span style='vertical-align:middle'>
            チーム
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort21' type='submit' style='cursor: pointer;' value='sort21'>
            <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort22' type='submit' style='cursor: pointer;' value='sort22'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th>社用TEL</th>
    <th>
        <span style='vertical-align:middle'>
            社歴
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort9' type='submit' style='cursor: pointer;' value='sort9'>
                <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort10' type='submit' style='cursor: pointer;' value='sort10'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th>
        <span style='vertical-align:middle'>
            役職
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort11' type='submit' style='cursor: pointer;' value='sort11'>
                <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort12' type='submit' style='cursor: pointer;' value='sort12'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>
    <th>
        <span style='vertical-align:middle'>
            SPグレード
        </span>
        <span style='display:inline-block; vertical-align:  middle; font-size:0;'>
            <button class='sortbutton' name='sort13' type='submit' style='cursor: pointer;' value='sort13'>
                <i class='fa-solid fa-caret-up fa-xs'></i>
            </button>
            <button class='sortbutton' name='sort14' type='submit' style='cursor: pointer;' value='sort14'>
                <i class='fa-solid fa-caret-down fa-xs'></i>
            </button>
        </span>
    </th>";


$DATA1 = sqlsrv_query($con_wpmain, $sql2); //●行単位で表示するためクエリを再実行
// $result1 = array();
while ($ROW = sqlsrv_fetch_array($DATA1, SQLSRV_FETCH_ASSOC)) {
    // foreach ($result1 as $ROW) {
    print "<tr style=' border-bottom:1px dashed #999;'><td rowspan='2' class='contents_box' >" . $ROW["MEUSERID"] . "</td>"; //●MEUSERID
    print "<td rowspan='2' class='contents_box'>" . $ROW["MEFULLNAME"] . "</td>"; //●氏名
    //Print "<td class='contents_box'>".$ROW["area"]."</td>";//●エリア
    print "<td class='contents_box'>" . $ROW["departmentname"] . "</td>"; //●部
    print "<td class='contents_box'>" . $ROW["unitname"] . "</td>"; //ユニット
    print "<td class='contents_box'>" . $ROW["MEUSERID"] . "@workport.co.jp</td>"; //●メアド

    $date = date('Y年m月d日', strtotime($ROW["MEDATEOFENTER"]));
    print "<td class='contents_box'>" . $date . "</td>"; //●入社日

    if ($ROW["MEFULLNAME"] == "細野和香奈") {
        print "<td class='contents_box'>" . "マネージャー" . "</td>"; //●役職
    } elseif ($ROW["MEFULLNAME"] == "高田静夫") {
        print "<td class='contents_box'>" . "執行役員" . "</td>"; //●役職
    } elseif ($ROW["MEFULLNAME"] == "山本晃司") {
        print "<td class='contents_box'>" . "リーダー" . "</td>"; //●役職
    } elseif (
        $ROW["MEFULLNAME"] == "松下和樹" ||
        $ROW["MEFULLNAME"] == "根津恵理" ||
        $ROW["MEFULLNAME"] == "具志堅敦紀" ||
        $ROW["MEFULLNAME"] == "谷口優人" ||
        $ROW["MEFULLNAME"] == "中津文里" ||
        $ROW["MEFULLNAME"] == "福岡千景" ||
        $ROW["MEFULLNAME"] == "林田尚文" ||
        $ROW["MEFULLNAME"] == "美坐辰彦" ||
        $ROW["MEFULLNAME"] == "川嶋拓" ||
        $ROW["MEFULLNAME"] == "石井佑典"
    ) {
        print "<td class='contents_box'>" . "" . "</td>"; //●役職
    } else {
        if ($ROW["MEFUNCTION"] == 501) {
            print "<td class='contents_box'>" . $ROW["name_g"] . "</td>"; //●役職
        } else {
            print "<td class='contents_box'>" . "" . "</td>"; //●役職
        }
    }

    if ($ROW["MEGRADE"] == 101 || $ROW["MEGRADE"] == 102) {
        print "<td class='contents_box'>" . "" . "</td></tr>"; //●グレード
    } else {
        print "<td class='contents_box'>" . "G" . $ROW["MEGRADE"] . "</td></tr>"; //●グレード
    }

    print "<tr style=' border-top:1px dashed #999;'><td class='contents_box'>" . $ROW["officename"] . "</td>"; //●拠点
    print "<td class='contents_box'>" . $ROW["teamname"] . "</td>"; //●チーム   
    print "<td class='contents_box'>" . $ROW["METEL"] . "</td>"; //●社用TEL

    $today = date("Y-m-d"); //●今日の日時を取得
    $day1 = new DateTime(date("Y-m-d", strtotime($ROW["MEDATEOFENTER"]))); //●入社日をDateTimeに入れる
    $day2 = new DateTime($today); //●今日をDateTimeに入れる
    $interval = $day1->diff($day2); //●両日の差を取る
    $year = $interval->format('%y'); //●差の年を取得
    $month = $interval->format('%m'); //●差の月を取得
    if ($year == 0) {
        print "<td class='contents_box'>" . $month . "ヶ月</td>"; //●社歴(月未満切り捨て)   
    } else {
        print "<td class='contents_box'>" . $year . "年" . $month . "ヶ月</td>"; //●社歴(月未満切り捨て)  
    }


    if ($ROW["MEFULLNAME"] == "高田静夫") {
        print "<td class='contents_box'>" . "担当役員" . "</td>"; //●役割
    } elseif ($ROW["MEFULLNAME"] == "細野和香奈") {
        print "<td class='contents_box'>" . "ユニット長" . "</td>"; //●役割
    } elseif ($ROW["MEFULLNAME"] == "山本晃司") {
        print "<td class='contents_box'>" . "チームリーダー" . "</td>"; //●役割
    } elseif (
        $ROW["MEFULLNAME"] == "松下和樹" ||
        $ROW["MEFULLNAME"] == "根津恵理" ||
        $ROW["MEFULLNAME"] == "具志堅敦紀" ||
        $ROW["MEFULLNAME"] == "谷口優人" ||
        $ROW["MEFULLNAME"] == "中津文里" ||
        $ROW["MEFULLNAME"] == "福岡千景" ||
        $ROW["MEFULLNAME"] == "林田尚文" ||
        $ROW["MEFULLNAME"] == "美坐辰彦" ||
        $ROW["MEFULLNAME"] == "川嶋拓" ||
        $ROW["MEFULLNAME"] == "石井佑典"
    ) {
        print "<td class='contents_box'>" . "メンバー" . "</td>"; //●役割
    } else {
        if ($ROW["correct_MEEMPLOYMENT"] == 900) {
            print "<td class='contents_box'>担当役員</td>"; //●役割
        } elseif ($ROW["correct_MEAUTHORITY_APP"] == 900) {
            print "<td class='contents_box'>部長</td>"; //●役割
        } elseif ($ROW["correct_MEAUTHORITY_APP"] == 800) {
            print "<td class='contents_box'>ユニット長</td>"; //●役割
        } elseif ($ROW["correct_MEAUTHORITY_APP"] == 600) {
            print "<td class='contents_box'>チームリーダー</td>"; //●役割
        } else {
            print "<td class='contents_box'>メンバー</td>"; //●役割
        }
    }

    if ($ROW["MEGRADE_sub"] == "") {
        print "<td class='contents_box'>" . $ROW["MEGRADE_sub"] . "</td></tr>"; //●SPグレード
    } else {
        print "<td class='contents_box'>" . "SPG" . $ROW["MEGRADE_sub"] . "</td></tr>"; //●SPグレード
    }
}

print "</table>";
?>

<script src='memberSearch_sort.js' type='text/javascript'></script>
<script>
    //■ページングボタンの表示切り替え用変数定義
    var 総検索数 = <?php echo $総検索数 ?>;
    //■検索結果があれば
    if (総検索数 != 0) {
        //■csv出力ボタンを有効化
        $("#csv-btn").prop("disabled", false);
        //■諸々を可視化
        $("#paging-header").css("visibility", "visible");
    }
</script>