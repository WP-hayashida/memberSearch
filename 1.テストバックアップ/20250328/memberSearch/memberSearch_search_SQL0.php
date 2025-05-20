<?php
ini_set('display_errors', 1);

//■サーバー接続
$parentDir = dirname($_SERVER['DOCUMENT_ROOT']) . "/DB";
require $parentDir . "/connect_wpmain_utf8.php";

//■セッションに条件などが格納されている場合
if (!empty($_SESSION['セッション検索語']) || !empty($_SESSION['セッション役職']) || !empty($_SESSION['セッション役割'])) {
    //●条件類を変数に格納
    $表示件数 = $_SESSION['セッション表示件数'];
    $検索語 = $_SESSION['セッション検索語'];
    $開始位置 = $_SESSION['セッション開始位置'];
    $分岐 = $_SESSION['セッション分岐値'];
    $役職 = $_SESSION['セッション役職'];
    $役割 = $_SESSION['セッション役割'];
    $order = $_SESSION['セッションオーダー'];

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
                                    END";

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
                        TM_WPTEAM.name AS teamname,
                        TM_WPUNIT.name AS unitname,
                        TM_WPUNIT.sort AS unitsort,
                        TM_WPOFFICE.id AS officeid,
                        TM_WPTEAM.sort AS teamsort,
                        TM_WPDEPARTMENT.name AS departmentname,
                        officename,
                        name_g,
                        {$correct_MEEMPLOYMENT}
                        AS correct_MEEMPLOYMENT,
                        {$correct_MEAUTHORITY_APP}
                        AS correct_MEAUTHORITY_APP,
                        {$display_positionname}
                        AS display_position
                    FROM TM_MEMBER
                        INNER JOIN TM_WPUNIT ON TM_MEMBER.MEUNIT = TM_WPUNIT.id
                        INNER JOIN TM_WPTEAM ON TM_MEMBER.METEAM = TM_WPTEAM.id
                        INNER JOIN TM_WPDEPARTMENT ON TM_WPUNIT.department = TM_WPDEPARTMENT.id
                        FULL OUTER JOIN TM_WPOFFICE ON TM_MEMBER.MEOFFICE_LOAN = TM_WPOFFICE.id
                        INNER JOIN TM_WPGRADE ON TM_MEMBER.MEGRADE = TM_WPGRADE.id
                    WHERE MEINVALIDFLAG = '0'";

    //■最初の条件を取り出す
    $whereClause = ""; //●分岐・検索語用
    $whereClause1 = ""; //●役職用
    $whereClause2 = ""; //●役割用

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
    if (!empty($役職)) {
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
            } else
                if ($value === "エリア・カテゴリー長") {
                $roles[] = "($correct_MEAUTHORITY_APP) = 900";
            } else
                if ($value === "ユニット長") {
                $roles[] = "($correct_MEAUTHORITY_APP) = 800";
            } else
                if ($value === "チームリーダー") {
                $roles[] = "($correct_MEAUTHORITY_APP) = 600";
            } else {
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

    //■完成したWHERE文を使ってクエリを構築
    if (!empty($whereClause)) {
        if (!empty($whereClause1)) {
            if (!empty($whereClause2)) {
                $sql1 .= " AND (" . $whereClause . ") AND" . $whereClause1 . "AND" . $whereClause2;
            } else {
                $sql1 .= " AND (" . $whereClause . ") AND" . $whereClause1;
            }
        } else {
            if (!empty($whereClause2)) {
                $sql1 .= " AND (" . $whereClause . ") AND" . $whereClause2;
            } else {
                $sql1 .= " AND (" . $whereClause . ") ";
            }
        }
    } else {
        if (!empty($whereClause1)) {
            if (!empty($whereClause2)) {
                $sql1 .= " AND (" . $whereClause1 . "AND" . $whereClause2 . ") ";
            } else {
                $sql1 .= " AND (" . $whereClause1 . ") ";
            }
        } else {
            if (!empty($whereClause2)) {
                $sql1 .= " AND (" . $whereClause2 . ") ";
            } else {
            }
        }
    }

    $sql1 .= $order;
    // print($sql1);
}


//■データベースアクセス
if (empty($whereClause) && empty($whereClause1) && empty($whereClause2)) {
    print("条件入れて（表示用）");
    exit;
} else {
    $DATA = sqlsrv_query($con_wpmain, $sql1);
    $result = array();
    while ($row = sqlsrv_fetch_array($DATA, SQLSRV_FETCH_ASSOC)) {
        /*
            if ($row['area'] === NULL) {
                $row['area'] = 'その他カテゴリー';
            }
                */
        $result[] = $row;
    }
}

//■データベース接続チェック
if ($DATA === false) {
    print('実行に失敗');
}
if ($DATA === null) {
    print('値がありません');
}
if (empty($DATA) === true) {
    print("該当データはありませんでした。");
}

$件数 = count($result); //●結果行数の取得

if ($件数 == 0) {
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
} else {
    $総検索数 = $件数; //●JS受け渡し用
}

//■行指定用SQL
//●$spl1をCSV用に使い回すために分ける
$sql2 = "";
$sql2 = $sql1 . " offset $開始位置 rows fetch next $表示件数 rows only";

// $DATA1 = sqlsrv_query($con_wpmain, $sql2); //●行単位で表示するためクエリを再実行
// $result1 = array();
// while ($row1 = sqlsrv_fetch_array($DATA1, SQLSRV_FETCH_ASSOC)) {
//     /*
//         if ($row1['area'] === NULL) {
//             $row1['area'] = 'その他カテゴリー';
//         }
//             */
//     $result1[] = $row1;
// }
