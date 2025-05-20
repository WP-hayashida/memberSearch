<?php
header('Content-Type: application/json');
require "../../../DB/connect_wpmain_utf8.php";

$archive_flg=0;


//すべて指定された年月のもののアーカイブを下に取得※初期値は今月
//$post_Ym="202504";
$post_Ym = $_POST['ym'] ?? date('Ym');
$this_Ym = date("Ym");

if($post_Ym!==$this_Ym) $archive_flg=1;

//echo $this_month;//アーカイブにない場合ほんちゃんにつなぐ処理もいる
if($archive_flg===0){
    //役職情報
    $roleArr = [
        ["No" => 0, "id" => "head-pic", "name" => "本部長"],
        ["No" => 1,"id" => "depart-pic", "name" => "部長"],
        ["No" => 2,"id" => "manager", "name" => "ユニット長"],
        ["No" => 3,"id" => "teamleader", "name" => "チームリーダー"],
        ["No" => 4,"id" => "member", "name" => "メンバー"]
    ];
    //■メンバー情報
    $sql = "WITH MemberWithRowNum AS (
            SELECT
                *,
                ROW_NUMBER() OVER (PARTITION BY MEUSERID ORDER BY MECD) AS rn
            FROM (
                SELECT
                    CONCAT(MESEIKANA,MEMEIKANA) AS MEKANA,
                    TM_MEMBER.MEUSERID,
                    TM_MEMBER.MEFULLNAME,
                    U.headquarter AS headquarter,
                    H.sort AS sort_headquarter,
                    H.name AS name_headquarter,
                    U.department AS department,
                    D.sort AS sort_department,
                    D.name AS name_department,
                    TM_MEMBER.MEUNIT,
                    U.sort AS sort_MEUNIT,
                    U.name AS name_MEUNIT,
                    TM_MEMBER.METEAM,
                    T.sort AS sort_METEAM,
                    T.name AS name_METEAM,
                    TM_MEMBER.MEGRADE,
                    G.id AS sort_name_g,
                    G.name_g AS name_g,
                    TM_MEMBER.MEOFFICE_LOAN,
                    OL.officename AS name_MEOFFICE_LOAN,
                    TM_MEMBER.MEOFFICE_BELONG,
                    OB.officename AS name_MEOFFICE_BELONG,
                    TM_MEMBER.MEEMPLOYMENT,
                    TM_MEMBER.MEAUTHORITY_APP,
                    MEDATEOFENTER,
                    METEL,
                    MEGRADE_sub,
                    MA.MEOFFICE_TAX,
                    OT.officename AS name_MEOFFICE_TAX,
                    MA.MEOFFICE_ACC,
					OA.name AS name_MEOFFICE_ACC,
                    CASE
                        WHEN TM_WPHEADQUARTER.pic = TM_MEMBER.MEUSERID THEN 'head-pic'
                        WHEN TM_WPDEPARTMENT.pic = TM_MEMBER.MEUSERID THEN 'depart-pic'
                        WHEN MU.manager = TM_MEMBER.MEUSERID THEN 'manager'
                        WHEN TM_WPTEAM.teamleader = TM_MEMBER.MEUSERID
                        OR TM_WPTEAM.teamleader2 = TM_MEMBER.MEUSERID
                        OR TM_WPTEAM.teamleader3 = TM_MEMBER.MEUSERID THEN 'teamleader'
                        ELSE 'member'
                    END AS role,
                    MECD
                FROM TM_MEMBER
                LEFT JOIN TM_MEMBER_management AS MA ON TM_MEMBER.MEUSERID = MA.MEUSERID
                LEFT JOIN TM_WPOFFICE AS OT ON MA.MEOFFICE_TAX = OT.id
                LEFT JOIN TM_WPUNIT AS U ON TM_MEMBER.MEUNIT = U.id
                LEFT JOIN TM_WPTEAM AS T ON TM_MEMBER.METEAM = T.id
                LEFT JOIN TM_WPGRADE AS G ON TM_MEMBER.MEGRADE = G.id
                LEFT JOIN TM_WPDEPARTMENT AS D ON D.id = U.department
                LEFT JOIN TM_WPHEADQUARTER AS H ON H.id = U.headquarter
                LEFT JOIN TM_WPOFFICE AS OL ON TM_MEMBER.MEOFFICE_LOAN = OL.id
                LEFT JOIN TM_WPOFFICE AS OB ON TM_MEMBER.MEOFFICE_BELONG = OB.id
				LEFT JOIN TM_WPOFFICE_ACC AS OA ON MA.MEOFFICE_ACC = OA.id
                LEFT JOIN TM_WPHEADQUARTER ON TM_WPHEADQUARTER.pic = TM_MEMBER.MEUSERID
                LEFT JOIN TM_WPDEPARTMENT ON TM_WPDEPARTMENT.pic = TM_MEMBER.MEUSERID
                LEFT JOIN TM_WPUNIT AS MU ON MU.manager = TM_MEMBER.MEUSERID AND MU.invalid = 0
                LEFT JOIN TM_WPTEAM ON (
                    TM_WPTEAM.teamleader = TM_MEMBER.MEUSERID
                    OR TM_WPTEAM.teamleader2 = TM_MEMBER.MEUSERID
                    OR TM_WPTEAM.teamleader3 = TM_MEMBER.MEUSERID
                ) AND TM_WPTEAM.invalid = 0
                WHERE LEFT(MECD,2) <> '00'
                AND RIGHT(TM_MEMBER.MEUSERID,4) <> '_ptn'
                AND MEINVALIDFLAG = 0
            ) AS sub
        )
        SELECT * FROM MemberWithRowNum WHERE rn = 1
        ORDER BY MECD;";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $memberArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        if ($row['MEUSERID'] === 'tamura' || $row['MEUSERID'] === 'hayashi') {
            $row['role'] = '';
        }

        // role.nameを探してname_roleに代入
        $row['name_role'] = '';
        $row['sort_role'] = '';
        foreach ($roleArr as $role) {
            if ($role['id'] === ($row['role'] ?? '')) {
                $row['name_role'] = $role['name'];
                $row['sort_role'] = $role['No'];
                break; // 見つかったらループ抜ける
            }
        }

        // name_METEAMに：が含まれているかチェックして、：までを取り除く
        if (strpos($row['name_METEAM'], '：') !== false) {
            // '：'の位置を見つけ、'：'の後ろから文字列を取り出す
            //$row['name_METEAM'] = mb_convert_encoding($row['name_METEAM'], 'UTF-8', 'auto');
            $row['name_METEAM'] = mb_substr($row['name_METEAM'], mb_strpos($row['name_METEAM'], '：')+1);
            //echo $row['name_METEAM'];
        }else{
            $row['name_METEAM']=$row['name_METEAM'];
        }

        //グレードにGをつける
        $row['MEGRADE'] = 'G'.$row['MEGRADE'];

        //入社日フォーマット
        if (!empty($row['MEGRADE_sub'])) {
            $row['MEGRADE_sub'] = 'SPG'.$row['MEGRADE_sub'];
        } else {
            $row['MEGRADE_sub'] = '';
        }

        //入社日フォーマット
        if (!empty($row['MEUSERID'])) {
            $row['Email'] = $row['MEUSERID'].'@workport.co.jp';
        } else {
            $row['Email'] = '';
        }

        //入社日フォーマット
        if (!empty($row['MEDATEOFENTER'])) {
            $dateObj = new DateTime($row['MEDATEOFENTER']);
            $row['formattedDATEOFENTER'] = $dateObj->format('Y年m月d日');
        } else {
            $row['formattedDATEOFENTER'] = '';
        }

        // 入社日が存在する場合に在籍期間を計算
        $row['job_tenure'] = '';
        if (!empty($row['MEDATEOFENTER'])) {
            $today = date("Y-m-d");
            $day1 = new DateTime(date("Y-m-d", strtotime($row["MEDATEOFENTER"])));
            $day2 = new DateTime($today);
            $interval = $day1->diff($day2);
            $year = $interval->format('%y');
            $month = $interval->format('%m');

            if ($year == 0) {
                $row['job_tenure'] = "{$month}ヶ月";
            } else {
                $row['job_tenure'] = "{$year}年{$month}ヶ月";
            }
        }



        $memberArr[] = $row;

    }

    //var_dump($memberArr);


    //■本部情報
    $sql = "SELECT id,name,pic
            FROM TM_WPHEADQUARTER
            ORDER BY sort";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $headquarterArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $headquarterArr[] = $row;
    }
    //var_dump($headquarterArr);


    //■部情報
    /*$sql = "SELECT D.id,D.name,D.pic,D.headquarter,U.officeid,O.officename
            FROM TM_WPDEPARTMENT AS D

            INNER JOIN TM_WPUNIT AS U ON U.department = D.id
            INNER JOIN TM_WPOFFICE AS O ON O.id = U.officeid

            ORDER BY D.sort";*/
    $sql = "WITH RankedData AS (
            SELECT
                D.id,
                D.name,
                D.sort,
                D.pic,
                D.headquarter,
                ROW_NUMBER() OVER (PARTITION BY D.id ORDER BY D.sort) AS row_num
            FROM TM_WPDEPARTMENT AS D
            RIGHT JOIN TM_WPUNIT AS U ON U.department = D.id
            LEFT JOIN TM_WPOFFICE AS O ON O.id = U.officeid
        )
        SELECT id, name, pic, headquarter
        FROM RankedData
        WHERE row_num = 1
        ORDER BY sort;";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $departmentArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $departmentArr[] = $row;
    }
    //var_dump($departmentArr);

    //■ユニット情報
    $sql = "SELECT U.id,U.name,manager ,department,O.officename
            FROM TM_WPUNIT AS U
            INNER JOIN TM_WPOFFICE AS O ON U.officeid=O.id
            WHERE U.invalid=0
            ORDER BY U.sort";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $unitArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $unitArr[] = $row;
    }
    //var_dump($unitArr);

    //チーム情報
    $sql = "SELECT id,name,teamleader as pic,LEFT(id,5) as unit
            FROM TM_WPTEAM
            WHERE invalid=0
            ORDER BY sort";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $teamArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $row["unit"] = substr($row["id"], 0, 5);
        $teamArr[] = $row;
    }
    //var_dump($teamArr);

    //UNIQOFFICE情報
    $sql = "WITH UniqueNames AS (
                    SELECT id AS uniqID,officename AS id, officename,
                        ROW_NUMBER() OVER (PARTITION BY officename ORDER BY id) AS rn
                    FROM TM_WPOFFICE
                    WHERE invalid = 0
                    and id<>'13GN'
                    and officename<>'本社オフィス'
                    and officename<>'大阪オフィス'
                )
                SELECT uniqID, id, officename
                FROM UniqueNames
                WHERE rn = 1
                ORDER BY uniqID";
    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $officeUniqArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $officeUniqArr[] = $row;
    }

    //●OFFICE_BELONG情報
    /*
    $sql = "SELECT O.id,officename,U.department
            FROM TM_WPOFFICE AS O
            INNER JOIN TM_WPUNIT AS U ON O.id = U.officeid";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $officeArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        //社内サポート意味わからんユニットに紐づいていない

        $officeArr[] = $row;
    }*/

    //●UNIQ_OFFICE_BELONG情報
    $sql = "SELECT O.id, officename, U.department
        FROM TM_WPOFFICE AS O
        INNER JOIN TM_WPUNIT AS U ON O.id = U.officeid";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) {
        print('connection failed');
        exit;  // 接続失敗の場合は処理を停止
    }
    if ($dyn === null) {
        print('no value');
        exit;  // 結果が空の場合も処理を停止
    }

    $officeBelongArr = array();
    $uniqOfficeBelongArr = array();

    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $officeBelongArr[] = $row;
        // officenameをキーにしてユニーク化
        $officename = $row['officename'];
        // officenameがまだ存在しない場合、$uniqOfficeBelongArrに追加
        if (!isset($uniqOfficeBelongArr[$officename])) {
            // uniqIDを追加してデータを格納
            $uniqOfficeBelongArr[$officename] = [
                'uniqID' => $row['id'], // uniqIDとしてidを設定
                'id' => $row['officename'],      // idも保持
                'officename' => $row['officename'], // officenameも保持
                'department' => $row['department']
            ];
        }
    }
    
    // 変換後、配列をリセットしてインデックス付き配列にする
    $officeBelongArr = array_values($officeBelongArr);
    $uniqOfficeBelongArr = array_values($uniqOfficeBelongArr);

    // ユニーク化されたデータを$officeArrに再代入
    //$officeArr = array_values($uniqueOffices);

    // $officeArr の内容を確認するためにデバッグ
    //var_dump($officeBelongArr);
    //var_dump($uniqOfficeBelongArr);


    //GRADE情報
    $sql = "WITH UniqueNames AS (
                    SELECT id, name_g,
                        ROW_NUMBER() OVER (PARTITION BY name_g ORDER BY id) AS rn
                    FROM TM_WPGRADE
                    WHERE invalid = 0
                    and name_g<>''
                )
                SELECT id, name_g
                FROM UniqueNames
                WHERE rn = 1
                ORDER BY id DESC";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $gradeArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $gradeArr[] = $row;
    }
    //var_dump($gradeArr);


    /*
    $json_memberArr = json_encode($memberArr);
    $json_headquarterArr = json_encode($headquarterArr);
    $json_departmentArr = json_encode($departmentArr);
    $json_unitArr = json_encode($unitArr);
    $json_teamArr = json_encode($teamArr);
    $json_officeUniqArr = json_encode($officeUniqArr);
    //$json_officeArr = json_encode($officeArr);
    $json_officeBelongArr = json_encode($officeBelongArr);
    $json_uniqOfficeBelongArr = json_encode($uniqOfficeBelongArr);
    $json_gradeArr = json_encode($gradeArr);
    $json_roleArr = json_encode($roleArr);
    */
    echo json_encode([
        'memberArr' => $memberArr,
        'headquarterArr' => $headquarterArr,
        'departmentArr' => $departmentArr,
        'unitArr' => $unitArr,
        'teamArr' => $teamArr,
        'officeUniqArr' => $officeUniqArr,
        'officeBelongArr' => $officeBelongArr,
        'uniqOfficeBelongArr' => $uniqOfficeBelongArr,
        'gradeArr' => $gradeArr,
        'roleArr' => $roleArr,
    ]);


}else{
///////////////////////////////
//■ここからアーカイブ検索//
///////////////////////////////

        //役職情報
        $roleArr = [
            ["No" => 0, "id" => "head-pic", "name" => "本部長"],
            ["No" => 1,"id" => "depart-pic", "name" => "部長"],
            ["No" => 2,"id" => "manager", "name" => "ユニット長"],
            ["No" => 3,"id" => "teamleader", "name" => "チームリーダー"],
            ["No" => 4,"id" => "member", "name" => "メンバー"]
        ];
        //■メンバー情報
        $sql = "WITH MemberWithRowNum AS (
    SELECT
        *,
        ROW_NUMBER() OVER (PARTITION BY MEUSERID ORDER BY MECD) AS rn
    FROM (
        SELECT
            CONCAT(MESEIKANA, MEMEIKANA) AS MEKANA,
            TM_MEMBER_archive.MEUSERID,
            TM_MEMBER_archive.MEFULLNAME,
            U.headquarter AS headquarter,
            H.sort AS sort_headquarter,
            H.name AS name_headquarter,
            U.department AS department,
            D.sort AS sort_department,
            D.name AS name_department,
            TM_MEMBER_archive.MEUNIT,
            U.sort AS sort_MEUNIT,
            U.name AS name_MEUNIT,
            TM_MEMBER_archive.METEAM,
            T.sort AS sort_METEAM,
            T.name AS name_METEAM,
            TM_MEMBER_archive.MEGRADE,
            G.id AS sort_name_g,
            G.name_g AS name_g,
            TM_MEMBER_archive.MEOFFICE_LOAN,
            OL.officename AS name_MEOFFICE_LOAN,
            TM_MEMBER_archive.MEOFFICE_BELONG,
            OB.officename AS name_MEOFFICE_BELONG,
            TM_MEMBER_archive.MEEMPLOYMENT,
            TM_MEMBER_archive.MEAUTHORITY_APP,
            MEDATEOFENTER,
            METEL,
            MEGRADE_sub,
            MA.MEOFFICE_TAX,
            OT.officename AS name_MEOFFICE_TAX,
            MA.MEOFFICE_ACC,
            OA.name AS name_MEOFFICE_ACC,
            CASE
                WHEN H2.pic = TM_MEMBER_archive.MEUSERID THEN 'head-pic'
                WHEN D2.pic = TM_MEMBER_archive.MEUSERID THEN 'depart-pic'
                WHEN MU.manager = TM_MEMBER_archive.MEUSERID THEN 'manager'
                WHEN T.teamleader = TM_MEMBER_archive.MEUSERID THEN 'teamleader'
                ELSE 'member'
            END AS role,
            MECD
        FROM TM_MEMBER_archive
        LEFT JOIN TM_MEMBER_management AS MA ON TM_MEMBER_archive.MEUSERID = MA.MEUSERID
        LEFT JOIN TM_WPOFFICE AS OT ON MA.MEOFFICE_TAX = OT.id
        LEFT JOIN TM_WPOFFICE_ACC AS OA ON MA.MEOFFICE_ACC = OA.id
        LEFT JOIN TM_WPUNIT_archive AS U ON TM_MEMBER_archive.MEUNIT = U.id AND U.date = ?
        LEFT JOIN TM_WPTEAM_archive AS T ON TM_MEMBER_archive.METEAM = T.id AND T.date = ?
        LEFT JOIN TM_WPGRADE AS G ON TM_MEMBER_archive.MEGRADE = G.id
        LEFT JOIN TM_WPDEPARTMENT AS D ON D.id = U.department
        LEFT JOIN TM_WPHEADQUARTER AS H ON H.id = U.headquarter
        LEFT JOIN TM_WPOFFICE AS OL ON TM_MEMBER_archive.MEOFFICE_LOAN = OL.id
        LEFT JOIN TM_WPOFFICE AS OB ON TM_MEMBER_archive.MEOFFICE_BELONG = OB.id
        LEFT JOIN TM_WPHEADQUARTER AS H2 ON H2.pic = TM_MEMBER_archive.MEUSERID
        LEFT JOIN TM_WPDEPARTMENT AS D2 ON D2.pic = TM_MEMBER_archive.MEUSERID
        LEFT JOIN TM_WPUNIT_archive AS MU ON MU.manager = TM_MEMBER_archive.MEUSERID AND MU.invalid = 0 AND MU.date = ?
        LEFT JOIN TM_WPTEAM_archive AS T2 ON (
            T2.teamleader = TM_MEMBER_archive.MEUSERID
        ) AND T2.invalid = 0 AND T2.date = ?
        WHERE TM_MEMBER_archive.date = ?
        AND LEFT(MECD, 2) <> '00'
        AND RIGHT(TM_MEMBER_archive.MEUSERID, 4) <> '_ptn'
        AND MEINVALIDFLAG = 0
    ) AS sub
)
SELECT * FROM MemberWithRowNum WHERE rn = 1
ORDER BY MECD;";

    $params = array($post_Ym, $post_Ym, $post_Ym, $post_Ym, $post_Ym);
    $dyn = sqlsrv_query($con_wpmain, $sql, $params);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $memberArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        if ($row['MEUSERID'] === 'tamura' || $row['MEUSERID'] === 'hayashi') {
            $row['role'] = '';
        }

        // role.nameを探してname_roleに代入
        $row['name_role'] = '';
        $row['sort_role'] = '';
        foreach ($roleArr as $role) {
            if ($role['id'] === ($row['role'] ?? '')) {
                $row['name_role'] = $role['name'];
                $row['sort_role'] = $role['No'];
                break; // 見つかったらループ抜ける
            }
        }

        // name_METEAMに：が含まれているかチェックして、：までを取り除く
        if (strpos($row['name_METEAM'], '：') !== false) {
            // '：'の位置を見つけ、'：'の後ろから文字列を取り出す
            //$row['name_METEAM'] = mb_convert_encoding($row['name_METEAM'], 'UTF-8', 'auto');
            $row['name_METEAM'] = mb_substr($row['name_METEAM'], mb_strpos($row['name_METEAM'], '：')+1);
            //echo $row['name_METEAM'];
        }else{
            $row['name_METEAM']=$row['name_METEAM'];
        }

        //グレードにGをつける
        $row['MEGRADE'] = 'G'.$row['MEGRADE'];

        //入社日フォーマット
        if (!empty($row['MEGRADE_sub'])) {
            $row['MEGRADE_sub'] = 'SPG'.$row['MEGRADE_sub'];
        } else {
            $row['MEGRADE_sub'] = '';
        }

        //入社日フォーマット
        if (!empty($row['MEUSERID'])) {
            $row['Email'] = $row['MEUSERID'].'@workport.co.jp';
        } else {
            $row['Email'] = '';
        }

        //入社日フォーマット
        if (!empty($row['MEDATEOFENTER'])) {
            $dateObj = new DateTime($row['MEDATEOFENTER']);
            $row['formattedDATEOFENTER'] = $dateObj->format('Y年m月d日');
        } else {
            $row['formattedDATEOFENTER'] = '';
        }

        // 入社日が存在する場合に在籍期間を計算
        $row['job_tenure'] = '';
        if (!empty($row['MEDATEOFENTER'])) {
            $today = date("Y-m-d");
            $day1 = new DateTime(date("Y-m-d", strtotime($row["MEDATEOFENTER"])));
            $day2 = new DateTime($today);
            $interval = $day1->diff($day2);
            $year = $interval->format('%y');
            $month = $interval->format('%m');

            if ($year == 0) {
                $row['job_tenure'] = "{$month}ヶ月";
            } else {
                $row['job_tenure'] = "{$year}年{$month}ヶ月";
            }
        }


        $memberArr[] = $row;

    }

    //var_dump($memberArr);


    //■本部情報
    $sql = "SELECT id,name,pic
            FROM TM_WPHEADQUARTER
            ORDER BY sort";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $headquarterArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $headquarterArr[] = $row;
    }
    //var_dump($headquarterArr);


    //■部情報
    /*$sql = "SELECT D.id,D.name,D.pic,D.headquarter,U.officeid,O.officename
                FROM TM_WPDEPARTMENT AS D

                INNER JOIN TM_WPUNIT AS U ON U.department = D.id
                INNER JOIN TM_WPOFFICE AS O ON O.id = U.officeid

                ORDER BY D.sort";*/
    $sql = "WITH RankedData AS (
            SELECT
                D.id,
                D.name,
                D.sort,
                D.pic,
                D.headquarter,
                ROW_NUMBER() OVER (PARTITION BY D.id ORDER BY D.sort) AS row_num
            FROM TM_WPDEPARTMENT AS D
            RIGHT JOIN TM_WPUNIT AS U ON U.department = D.id
            LEFT JOIN TM_WPOFFICE AS O ON O.id = U.officeid
        )
        SELECT id, name, pic, headquarter
        FROM RankedData
        WHERE row_num = 1
        ORDER BY sort;";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $departmentArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $departmentArr[] = $row;
    }
    //var_dump($departmentArr);

    //■ユニット情報
    $sql = "SELECT U.id,U.name,manager ,department,O.officename
            FROM TM_WPUNIT_archive AS U
            INNER JOIN TM_WPOFFICE AS O
            ON U.officeid=O.id
            AND U.date=?
            WHERE U.invalid=0
            ORDER BY U.sort";

    $params = array($post_Ym);
    $dyn = sqlsrv_query($con_wpmain, $sql, $params);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $unitArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $unitArr[] = $row;
    }
    //var_dump($unitArr);

    //チーム情報
    $sql = "SELECT id,name,teamleader as pic,LEFT(id,5) as unit
            FROM TM_WPTEAM_archive
            WHERE invalid=0 AND date=?
            ORDER BY sort";

    $params = array($post_Ym);
    $dyn = sqlsrv_query($con_wpmain, $sql, $params);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $teamArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $row["unit"] = substr($row["id"], 0, 5);
        $teamArr[] = $row;
    }
    //var_dump($teamArr);

    //UNIQOFFICE情報
    $sql = "WITH UniqueNames AS (
                    SELECT id AS uniqID,officename AS id, officename,
                        ROW_NUMBER() OVER (PARTITION BY officename ORDER BY id) AS rn
                    FROM TM_WPOFFICE
                    WHERE invalid = 0
                    and id<>'13GN'
                    and officename<>'本社オフィス'
                    and officename<>'大阪オフィス'
                )
                SELECT uniqID, id, officename
                FROM UniqueNames
                WHERE rn = 1
                ORDER BY uniqID";
    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $officeUniqArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $officeUniqArr[] = $row;
    }

    //●OFFICE_BELONG情報
        /*
        $sql = "SELECT O.id,officename,U.department
                FROM TM_WPOFFICE AS O
                INNER JOIN TM_WPUNIT AS U ON O.id = U.officeid";

        $dyn = sqlsrv_query($con_wpmain, $sql);

        if ($dyn === false) print('connection failed');
        if ($dyn === null) print('no value');

        $officeArr = array();
        while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
            //社内サポート意味わからんユニットに紐づいていない

            $officeArr[] = $row;
        }*/

    //●UNIQ_OFFICE_BELONG情報
    //組織絞り込み用
    $sql = "SELECT O.id, officename, U.department
        FROM TM_WPOFFICE AS O
        INNER JOIN TM_WPUNIT_archive AS U
        ON O.id = U.officeid
        AND U.date =?";

    $params = array($post_Ym);
    $dyn = sqlsrv_query($con_wpmain, $sql, $params);

    if ($dyn === false) {
        print('connection failed');
        exit;  // 接続失敗の場合は処理を停止
    }
    if ($dyn === null) {
        print('no value');
        exit;  // 結果が空の場合も処理を停止
    }

    $officeBelongArr = array();
    $uniqOfficeBelongArr = array();

    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $officeBelongArr[] = $row;
        // officenameをキーにしてユニーク化
        $officename = $row['officename'];
        // officenameがまだ存在しない場合、$uniqOfficeBelongArrに追加
        if (!isset($uniqOfficeBelongArr[$officename])) {
            // uniqIDを追加してデータを格納
            $uniqOfficeBelongArr[$officename] = [
                'uniqID' => $row['id'],
                'id' => $row['officename'],
                'officename' => $row['officename'],
                'department' => $row['department']
            ];
        }
    }

    // 変換後、配列をリセットしてインデックス付き配列にする
    $officeBelongArr = array_values($officeBelongArr);
    $uniqOfficeBelongArr = array_values($uniqOfficeBelongArr);

    // ユニーク化されたデータを$officeArrに再代入
    //$officeArr = array_values($uniqueOffices);

    // $officeArr の内容を確認するためにデバッグ
    //var_dump($officeBelongArr);
    //var_dump($uniqOfficeBelongArr);


    //GRADE情報
    $sql = "WITH UniqueNames AS (
                    SELECT id, name_g,
                        ROW_NUMBER() OVER (PARTITION BY name_g ORDER BY id) AS rn
                    FROM TM_WPGRADE
                    WHERE invalid = 0
                    and name_g<>''
                )
                SELECT id, name_g
                FROM UniqueNames
                WHERE rn = 1
                ORDER BY id DESC";

    $dyn = sqlsrv_query($con_wpmain, $sql);

    if ($dyn === false) print('connection failed');
    if ($dyn === null) print('no value');

    $gradeArr = array();
    while ($row = sqlsrv_fetch_array($dyn, SQLSRV_FETCH_ASSOC)) {
        $gradeArr[] = $row;
    }
    //var_dump($gradeArr);


        echo json_encode([
            'memberArr' => $memberArr,
            'headquarterArr' => $headquarterArr,
            'departmentArr' => $departmentArr,
            'unitArr' => $unitArr,
            'teamArr' => $teamArr,
            'officeUniqArr' => $officeUniqArr,
            'officeBelongArr' => $officeBelongArr,
            'uniqOfficeBelongArr' => $uniqOfficeBelongArr,
            'gradeArr' => $gradeArr,
            'roleArr' => $roleArr,
        ]);
}
?>
