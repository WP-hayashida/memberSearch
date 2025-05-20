<?php ini_set('display_errors', 1); //●エラー表示
// error_reporting(E_ALL);
// error_reporting(E_ALL & ~E_NOTICE);
?>

<?php
//■検索条件受け取りPHP
require "memberSearch_session.php";
?>

<!--セッション開始 -->
<?php
session_start();
$_SESSION['セッション検索語'] = "";
$_SESSION['セッション開始位置'] = "";
$_SESSION['セッション分岐値'] = "";
$_SESSION['セッションオーダー'] = "";
?>

<!--CSVファイル削除-->
<?php
/*$csvFileName = '../payroll_test/memberSearchList.csv';
    if (file_exists($csvFileName)) {
        echo "mituketa";
        if (unlink($csvFileName)) {
            echo "sakuzyo";
        } else {
            echo "CSVファイルの削除に失敗しました。";
        }
    } */
?>

<!--CSVファイル出力-->
<?php
//■CSVファイルをここに検索毎に作成
$csvFileName = '../payroll/memberSearchList.csv';

if (isset($_POST['出力'])) {
    //$filename = $_POST['example'];//●検索条件内容
    $today = date("ymd"); //●ファイル名作成用
    if (file_exists($csvFileName)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $today . '_memberSearchList.csv"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($csvFileName));
        while (ob_get_level()) {
            ob_end_clean();
        }
        readfile($csvFileName); //●出力
        exit;
    } else {
        die("ダウンロード対象ファイルが見つかりません");
    }
}
?>

<!DOCTYPE html>

<html>


<head>
    <meta charset="utf-8">
    <title>社員検索システム</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">

    <link href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" rel="stylesheet">

    <!---<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>--->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


    <script src="select2.js"></script>
    <link href="select2.css" rel="stylesheet" />
    <link rel="stylesheet" href="memberSearch.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/ja.js"></script> <!-- ←日本語化ファイルを読み込み -->


    <!--トップへ戻るボタンのJS-->
    <script>
        jQuery(document).ready(function() {
            var offset = 100;
            var duration = 500;
            jQuery(window).scroll(function() {
                if (jQuery(this).scrollTop() > offset) {
                    jQuery('.pagetop').fadeIn(duration);
                } else {
                    jQuery('.pagetop').fadeOut(duration);
                }
            });

            jQuery('.pagetop').click(function(event) {
                event.preventDefault();
                jQuery('html, body').animate({
                    scrollTop: 0
                }, duration);
                return false;
            })
        });
    </script>

</head>



<body style="background: #f5f5f5; ">

    <!-- メッセージボックスPHP -->
    <?php
    require "memberSearch_message.php";
    ?>

    <!-- 閉じるボタン -->
    <input type="button" value="閉じる(Q)" accesskey="q" onclick="window.open('','_self').close();" style="position:absolute; top :10px; right:10px; font-size:13px; padding:2px;cursor: pointer;">

    <!--コンテナ-->
    <div class="container" style="display: flex; justify-content: center; align-items: center;">
        <div class="container-header" style="text-align: left;">
            <h1 style="color: black; text-align: center;">社員検索システム</h1>
            <a style="color: black; display: block; text-align: left; line-height:14px;">
                ※条件を入力することで、それに属する組織や役職などを絞り込めます<br>
                ※同じカテゴリー内で、複数の選択肢を選ぶことができます<br>
                ※ボタンで選択中条件の全表示・一部表示の切り替えができます
            </a>
        </div>

        <!--条件指定フォーム -->
        <form method="post" name="sForm">
            <div class="item-form-wrapper" id="item-form-wrapper" style="height: 200px;">

                <!--配列格納用 -->
                <?php
                require "../../DB/connect_wpmain_utf8.php";; //●サーバー接続

                //■pulldown絞り込み参照用
                $sql10 = "SELECT    MECD,
                                        MEFULLNAME,
                                        MEUNIT,
                                        tm_wpteam.name AS teamname,
                                        tm_wpunit.name AS unitname,
                                        tm_wpdepartment.name AS departmentname,
                                        officename,
                                        name_g,
                                        tm_wpunit.id AS unitid,
                                        tm_wpunit.sort AS unitsort,
                                        tm_wpoffice.id AS officeid,
                                        tm_wpteam.sort AS teamsort,
                                        tm_wpgrade.id AS gradeid,
                                        MEEMPLOYMENT,
                                        MEAUTHORITY_APP,
                                        MEFUNCTION
                                FROM tm_member
                                    INNER JOIN tm_wpunit ON tm_member.MEUNIT = tm_wpunit.id
                                    INNER JOIN tm_wpteam ON tm_member.METEAM = tm_wpteam.id
                                    INNER JOIN tm_wpdepartment ON tm_wpunit.department = tm_wpdepartment.id
                                    FULL OUTER JOIN tm_wpoffice ON tm_member.MEOFFICE_LOAN = tm_wpoffice.id
                                    INNER JOIN tm_wpgrade ON tm_member.MEGRADE = tm_wpgrade.id
                                WHERE MEINVALIDFLAG = '0'";

                $dyn10 = sqlsrv_query($con_wpmain, $sql10);

                //■dyn10接続チェック
                if ($dyn10 === false) {
                    print('接続失敗');
                }
                if ($dyn10 === null) {
                    print('値なし');
                }
                if (empty($dyn10) === true) {
                    print("該当データはありませんでした。");
                }

                //■配列result2を作成
                $result2 = array();
                while ($row10 = sqlsrv_fetch_array($dyn10, SQLSRV_FETCH_ASSOC)) {

                    //●MECDの先頭2桁が00の人を排除
                    $MECD =  substr($row10["MECD"], 0, 2);
                    if ($MECD == 00) {
                        continue;
                    }

                    //●エリアが空白のものはその他カテゴリーに分類
                    /*
                    if ($row10['area'] === NULL) {
                        $row10['area'] = 'その他カテゴリー';
                    }
                    */

                    //●システムは権限を変更している可能性があるので書き換え
                    if ($row10['MEUNIT'] === '13OBJ') {
                        if ($row10['MEFULLNAME'] === '高田静夫') {
                            $row10['MEEMPLOYMENT'] = 900;
                        } elseif ($row10['MEFULLNAME'] === '細野和香奈') {
                            $row10['MEAUTHORITY_APP'] = 800;
                            $row10['MEEMPLOYMENT'] = 750;
                        } elseif ($row10['MEFULLNAME'] === '山本晃司') {
                            $row10['MEAUTHORITY_APP'] = 600;
                            $row10['MEEMPLOYMENT'] = 750;
                        } else {
                            $row10['MEAUTHORITY_APP'] = 200;
                            $row10['MEEMPLOYMENT'] = 750;
                        }
                    }

                    //●ゼネラリストのみ役職表示
                    if ($row10['MEFUNCTION'] != 501) {
                        $row10['name_g'] = '';
                    }


                    $result2[] = $row10;
                }

                //■配列result2に役割のカラムを追加
                foreach ($result2 as $key => $value) {

                    if ($value['MEEMPLOYMENT'] == 900) {
                        $result2[$key]['rolename'] = '担当役員';
                        $result2[$key]['rolesort'] = 5;
                    } elseif ($value['MEAUTHORITY_APP'] == 900) {
                        $result2[$key]['rolename'] = 'エリア・カテゴリー長';
                        $result2[$key]['rolesort'] = 4;
                    } elseif ($value['MEAUTHORITY_APP'] == 800) {
                        $result2[$key]['rolename'] = 'ユニット長';
                        $result2[$key]['rolesort'] = 3;
                    } elseif ($value['MEAUTHORITY_APP'] == 600) {
                        $result2[$key]['rolename'] = 'チームリーダー';
                        $result2[$key]['rolesort'] = 2;
                    } else {
                        $result2[$key]['rolename'] = 'メンバー';
                        $result2[$key]['rolesort'] = 1;
                    }
                }

                //■departmentpull
                $sql11 = "SELECT  name
                                FROM tm_wpdepartment
                                    ORDER BY sort";

                $dyn11 = sqlsrv_query($con_wpmain, $sql11);
                $departmentPulldown = array();

                while ($row = sqlsrv_fetch_array($dyn11, SQLSRV_FETCH_ASSOC)) {

                    $departmentPulldown[] = $row["name"];
                }
                $uniqDepartment = array_unique($departmentPulldown); //●ユニーク化
                $uniqDepartmentArray = array_values($uniqDepartment); //●プルダウン用に加工


                //■officepull
                $sql12 = "SELECT  officename
                                FROM tm_wpoffice
                                    WHERE invalid = '0'
                                    ORDER BY id";

                $dyn12 = sqlsrv_query($con_wpmain, $sql12);
                $officePulldown = array();

                while ($row = sqlsrv_fetch_array($dyn12, SQLSRV_FETCH_ASSOC)) {
                    if ($row["officename"] == "") {
                        continue;
                    }
                    $officePulldown[] = $row["officename"];
                }
                $uniqOffice = array_unique($officePulldown);
                $uniqOfficeArray = array_values($uniqOffice);


                //■unitpull
                $sql13 = "SELECT * FROM tm_wpunit ORDER BY sort";
                $dyn13 = sqlsrv_query($con_wpmain, $sql13);
                while ($row = sqlsrv_fetch_array($dyn13)) {
                    if ($row["name"] == "") {
                        continue;
                    }
                    $unitPulldown[] = $row["name"];
                }
                $uniqUnit = array_unique($unitPulldown);
                $uniqUnitArray = array_values($uniqUnit);


                //■teampull
                $sql14 = "SELECT * FROM tm_wpteam ORDER BY sort";
                $dyn14 = sqlsrv_query($con_wpmain, $sql14);
                while ($row = sqlsrv_fetch_array($dyn14)) {
                    if ($row["name"] == "") {
                        continue;
                    }
                    $teamPulldown[] = $row["name"];
                }
                $uniqTeam = array_unique($teamPulldown);
                $uniqTeamArray = array_values($uniqTeam);


                //■fullnamepull
                $sql15 = "SELECT MECD,MEDATEOFQUIT,MEFULLNAME FROM tm_member 
                                WHERE MEINVALIDFLAG = '0'";
                $dyn15 = sqlsrv_query($con_wpmain, $sql15);
                while ($row = sqlsrv_fetch_array($dyn15)) {
                    //●MECDの先頭2桁が00の人を排除
                    $MECD =  substr($row["MECD"], 0, 2);
                    if ($MECD == 00) {
                        continue;
                    }
                    //●退職済みの人を排除
                    if ($row["MEDATEOFQUIT"] != "") {
                        continue;
                    }
                    if ($row["MEFULLNAME"] == "") {
                        continue;
                    }
                    $fullnamePulldown[] = $row["MEFULLNAME"];
                }
                $uniqFullname = array_unique($fullnamePulldown);
                $uniqFullnameArray = array_values($uniqFullname);


                //■position
                $sql16 = "SELECT * FROM tm_wpgrade ORDER BY id DESC";
                $dyn16 = sqlsrv_query($con_wpmain, $sql16);
                while ($row = sqlsrv_fetch_array($dyn16)) {
                    if ($row["name_g"] == "") {
                        continue;
                    }
                    $positionPulldown[] = $row["name_g"];
                }
                $uniqPosition = array_unique($positionPulldown);
                $uniqPositionArray = array_values($uniqPosition);
                //var_dump($uniqPositionArray);


                //■role    
                $uniqRoleArray = array('担当役員', 'エリア・カテゴリー長', 'ユニット長', 'チームリーダー', 'メンバー');
                //※メモ：↓この書き方はverにphp5.4以降のみなのでだめ  
                //$roleArray = ['担当役員','エリア・カテゴリー長','ユニット長','チームリーダー'];

                // var_dump($uniqRoleArray);

                //■Jsonエンコード
                $jsonPull = json_encode($result2);
                $jsonDepartmentPull = json_encode($uniqDepartmentArray);
                $jsonOfficePull = json_encode($uniqOfficeArray);
                $jsonUnitPull = json_encode($uniqUnitArray);
                $jsonTeamPull = json_encode($uniqTeamArray);
                $jsonFullnamePull = json_encode($uniqFullnameArray);
                $jsonPositionPull = json_encode($uniqPositionArray);
                $jsonRolePull = json_encode($uniqRoleArray);
                //var_dump ($result2);
                ?>

                <div class="input-block" style="display: flex;  flex-direction: column; ">
                    <!--２段で表示する場合-->
                    <!--   <p style=" margin-bottom:-5px;text-decoration:underline;">組織条件（絞り込み）</p> -->

                    <div class="input-button-box" style=" display:flex; margin-bottom:15px;padding-bottom:5px;border-bottom:1px dotted black">
                        <input type="submit" value="検索(s)" name="検索実行" id="検索実行" class="search-button" accesskey="s">

                        <input value="クリア(c)" type="button" onclick="Clear();" class="clear-button" name="clear" accesskey="c">

                        <input type="hidden" name="example" value="" id="example-id">
                        <input type="submit" id="csv-btn" value="CSV出力" class="" name="出力" style="width:10%; height:28px; cursor: pointer;" disabled>

                        <select id="display-count" style="width:10%; height:28px; padding:2px;margin:2px 8px 2px 8px; border:1px solid black;border-radius:2px;cursor: pointer;">
                            <option value="10">表示件数10件</option>
                            <option value="25">表示件数25件</option>
                            <option value="50">表示件数50件</option>
                            <option value="100">表示件数100件</option>
                        </select>
                    </div>

                    <div class="form-narrowdown" style="margin-left:5px;">
                        <div class="form" style="width: 10%; position:relative; color:black;" id="departmentnameform">
                            <label style="font-size: 14px;">部
                                <select class="pulldown" id='departmentname' name="departmentname" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="departmentnametgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--トグル記号版-->
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="areaplus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>
                                    <i class="toggle2 fa-solid fa-chevron-left " id="areaminus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>-->
                                <button type="button" class="toggle1  hidden" id="departmentnameplus" style="font-size: 8px; top:9px;right:2px;">選択中を見る</button>
                                <button type="button" class="toggle2  " id="departmentnameminus" style="font-size: 8px; top:9px;right:2px;">選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 10%; position:relative; color:black;" id="officenameform">
                            <label style="font-size: 14px;">拠点
                                <select class="pulldown" id="officename" name="officename" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="officenametgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="officenameplus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>
                                <i class="toggle2 fa-solid fa-chevron-left " id="officenameminus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>  -->
                                <button type="button" class="toggle1  hidden" id="officenameplus" style="font-size: 8px; top:9px;right:2px;">選択中を見る</button>
                                <button type="button" class="toggle2  " id="officenameminus" style="font-size: 8px; top:9px;right:2px;">選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width:20%; position:relative; color:black;" id="unitnameform">
                            <label style="font-size: 14px;">ユニット
                                <select class="pulldown" id="unitname" name="unitname" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="unitnametgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="unitnameplus" style="position: absolute; top:7px; right:5px; font-size:15px; color: #6c7686; "></i>
                                    <i class="toggle2 fa-solid fa-chevron-left " id="unitnameminus" style="position: absolute; top:7px; right:5px; font-size:15px; color: #6c7686; "></i>-->
                                <button type="button" class="toggle1  hidden" id="unitnameplus" style="font-size: 8px; top:9px;right:2px;">選択中を見る</button>
                                <button type="button" class="toggle2  " id="unitnameminus" style="font-size: 8px; top:9px;right:2px;">選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 22%; position:relative; color:black;" id="teamnameform">
                            <label style="font-size: 14px;">チーム
                                <select class="pulldown" id="teamname" name="teamname" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="teamnametgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="teamnameplus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>
                                    <i class="toggle2 fa-solid fa-chevron-left " id="teamnameminus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>-->
                                <button type="button" class="toggle1  hidden" id="teamnameplus" style="font-size: 8px; top:9px;right:2px;">選択中を見る</button>
                                <button type="button" class="toggle2  " id="teamnameminus" style="font-size: 8px; top:9px;right:2px;">選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 12%; position:relative; color:black;" id="MEFULLNAMEform">
                            <label style="font-size: 14px;">氏名
                                <select class="pulldown" id="MEFULLNAME" name="MEFULLNAME" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="MEFULLNAMEtgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="MEFULLNAMEplus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>
                                    <i class="toggle2 fa-solid fa-chevron-left " id="MEFULLNAMEminus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>-->
                                <button type="button" class="toggle1  hidden" id="MEFULLNAMEplus" style="font-size: 8px; top:9px;right:2px;">選択中を見る</button>
                                <button type="button" class="toggle2  " id="MEFULLNAMEminus" style="font-size: 8px; top:9px;right:2px;">選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 10%; position:relative; color:black; float:left;" id="positionform">
                            <label style="font-size: 14px;">職位
                                <select class="pulldown" id="position" name="position" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="positiontgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <button type="button" class="toggle1  hidden" id="positionplus" style="font-size: 8px; top:9px;right:2px;">選択中を見る</button>
                                <button type="button" class="toggle2  " id="positionminus" style="font-size: 8px; top:9px;right:2px;">選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 10%; position:relative; color:black; float:left;" id="roleform">
                            <label style="font-size: 14px;">役職
                                <select class="pulldown" id="role" name="role" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="roletgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <button type="button" class="toggle1  hidden" id="roleplus" style="font-size: 8px; top:9px;right:2px;">選択中を見る</button>
                                <button type="button" class="toggle2  " id="roleminus" style="font-size: 8px; top:9px;right:2px;">選択中を隠す</button>
                            </p>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $('.pulldown').select2({
                            language: "ja",
                            dropdownAutoWidth: true,
                            width: '100%',
                            placeholder: "選択or直接入力",
                            closeOnSelect: false,
                            dropdownPosition: 'above'
                        });


                        // Select2の選択肢が解除されたときのイベント
                        $('.pulldown').on('select2:unselect', function(e) {
                            //var unselectedValue = e.params.data.id;  // 解除された値を取得
                            //console.log('解除されました:', unselectedValue);

                            var searchField = $(this).siblings('.select2').find('.select2-selection__choice');
                            //console.log(this);
                            //console.log(e);
                            //console.log(parentId);
                            //console.log(searchField.length);

                            if (searchField.length > 0) {
                                //console.log('select2-selection__choiceが存在します。');
                            } else {
                                //console.log('select2-selection__choiceは存在しません。');
                                //console.log('nasi');
                                $('.pulldown').select2('close');
                            }
                        });


                    });
                </script>

                <script>
                    //■PHPからJSに配列を受け渡し
                    var aaa = <?php echo $jsonPull; ?>;
                    var departmentPull = <?php echo $jsonDepartmentPull; ?>;
                    var officePull = <?php echo $jsonOfficePull; ?>;
                    var unitPull = <?php echo $jsonUnitPull; ?>;
                    var teamPull = <?php echo $jsonTeamPull; ?>;
                    var fullnamePull = <?php echo $jsonFullnamePull; ?>;
                    var positionPull = <?php echo $jsonPositionPull; ?>;
                    var rolePull = <?php echo $jsonRolePull; ?>;
                    //console.log(positionPull);
                </script>

            </div>
        </form>

        <!-- 検索BOX -->
        <div class="box" id="box" style=" width:90%; position:absolute; top:370px; left:5%; margin-bottom:40px;">

            <div id="paging-container"><!--ここらへんの要素を検索件数やページネーションボタンに書き換える-->

                <div class="paging-header" id="paging-header" style="visibility:hidden; font-size:17px; color:black; font-weight:600;">

                    検索結果：<span id="js-pagination-result-total"></span>件
                    <span id="js-pagination-result-range-text"></span>
                </div>
                <div id="paging-button" style="display: flex; visibility:hidden;  max-width:500px; position:absolute; top: 0px; left:50%; transform: translate(-50%, 0%);">
                    <button class="前" id="js-button-prev" style="margin-right: 5px; width: 40px;">
                        前へ
                    </button>
                    <div id="pagination" style="display: flex;"></div>
                    <button class="次" id="js-button-next" style="margin-left:0px;width: 40px;">
                        次へ
                    </button>
                </div>

            </div>



            <!--id検索結果をDB_LIST.phpに置き換える -->
            <div style="margin-bottom:20px" id="検索結果">検索中</div>

            <div id="paging-container2" style="position: relative; margin-bottom:40px">
                <div class="paging-header2" id="paging-header2" style="visibility:hidden; font-size:large; color:black; font-weight:600;">
                    検索結果:<span id="js-pagination-result-total2"></span>件
                    <span id="js-pagination-result-range-text2"></span>
                </div>
                <div id="paging-button2" style="display: flex; visibility:hidden; max-width:500px; position:absolute; top: 0; left:50%; transform: translate(-50%, 0%);">
                    <button class="前" id="js-button-prev2" style="margin-right: 5px; width: 40px;">
                        前へ
                    </button>
                    <div id="pagination2" style="display: flex;"></div>
                    <button class="次" id="js-button-next2" style="margin-left:0px;width: 40px;">
                        次へ
                    </button>
                </div>

            </div>

        </div>

    </div>

    <!--トップへ戻るボタン-->
    <div class="pagetop">↑</div>

    <!--script呼び出し-->
    <script src='memberSearch_db_search.js' type='text/javascript'></script>
    <script src='memberSearch_messageBox.js' type='text/javascript'></script>
    <script src='memberSearch_function.js' type='text/javascript'></script>
    <script src='memberSearch_pulldown.js' type='text/javascript'></script>
    <script src='memberSearch_toggle.js' type='text/javascript'></script>
    <script src='memberSearch_pagination.js' type='text/javascript'></script>


    <script>
        //■表示件数のCookieで保持
        //●すべての読み込みの最後にしたいので最後に配置
        $('#display-count').on('change', function() {
            var selectedValue = document.getElementById('display-count').value;
            document.cookie = "displayCount=" + selectedValue + ";path=/";
        })

        document.addEventListener('DOMContentLoaded', function() {
            var displayCountCookie = getCookie("displayCount");
            if (displayCountCookie) {
                document.getElementById('display-count').value = displayCountCookie;
            }
        });

        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }

        var 表示件数 = "";
    </script>

</body>

</html>