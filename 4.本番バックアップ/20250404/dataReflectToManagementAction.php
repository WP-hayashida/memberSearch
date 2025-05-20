<?php
session_start();

$mecd = $_POST['MECD'];

//wpdb01
require "../../DB/connect_wpmain_utf8.php";
//DB01のデータ取得
$select = "SELECT MEUSERID,MESEI,MEMEI,MESEIKANA,MEMEIKANA,MESEX,MEBIRTHDATE,MEZIPCODE,MEPREFECTURECD,MEADDRESS1,MEADDRESS2,MEMOBILENUM,MEPHONENUM,MEMOBILEMAIL,MEDATEOFENTER,MEDATEOFQUIT,MEGROUP,MEEXTERNALGROUP,MEGROUP_FORCANDI,MEAUTHCD_FORCANDI,MEPOSITION,MEGRADE,MEEMPLOYMENT,MEBASE,MEOFFICE_BELONG,MEOFFICE_LOAN,MEUNIT,METEAM,MEJOB,MEAUTHORITY_APP,MEJOB_CC,MEJOB_RA,MEJOB_ENTRY,MEJOB_GENERALAFFAIRS,MEJOB_REVIEW FROM TM_MEMBER WHERE MECD = '" . $mecd . "'";
$dyn = sqlsrv_query($con_wpmain, $select);

if ($rec = sqlsrv_fetch_array($dyn)) {

	if (empty($rec[30])) {

		$mejob_cc = 0;
	} else {

		$mejob_cc = 1;
	}

	if (empty($rec[31])) {

		$mejob_ra = 0;
	} else {

		$mejob_ra = 1;
	}

	if (empty($rec[32])) {

		$mejob_entry = 0;
	} else {

		$mejob_entry = 1;
	}

	if (empty($rec[33])) {

		$mejob_generalaffairs = 0;
	} else {

		$mejob_generalaffairs = 1;
	}

	if (empty($rec[34])) {

		$mejob_review = 0;
	} else {

		$mejob_review = 1;
	}

	//更新
	$UPDATE = "UPDATE TM_MEMBER_management SET MEUSERID = '" . $rec[0] . "',姓 = '" . $rec[1] . "',名 = '" . $rec[2] . "',姓カナ = '" . $rec[3] . "',名カナ = '" . $rec[4] . "',性別 = '" . $rec[5] . "',生年月日 = '" . $rec[6] . "',住所_郵便番号 = '" . $rec[7] . "',住所_都道府県 = '" . $rec[8] . "',住所_区市町村 = '" . $rec[9] . "',住所_詳細 = '" . $rec[10] . "',携帯電話番号 = '" . $rec[11] . "',自宅電話番号 = '" . $rec[12] . "',携帯電話メールアドレス = '" . $rec[13] . "',退社日 = '" . $rec[15] . "',所属部署 = '" . $rec[16] . "',所属ユニット = '" . $rec[17] . "',所属グループ = '" . $rec[18] . "',権限 = '" . $rec[19] . "',MEPOSITION = '" . $rec[20] . "',MEGRADE = '" . $rec[21] . "',MEEMPLOYMENT = '" . $rec[22] . "',MEBASE = '" . $rec[23] . "',MEOFFICE_BELONG = '" . $rec[24] . "',MEOFFICE_LOAN = '" . $rec[25] . "',MEUNIT = '" . $rec[26] . "',METEAM = '" . $rec[27] . "',MEJOB = '" . $rec[28] . "',MEAUTHORITY_APP = '" . $rec[29] . "',MEJOB_CC= '" . $mejob_cc . "',MEJOB_RA= '" . $mejob_ra . "',MEJOB_ENTRY= '" . $mejob_entry . "',MEJOB_GENERALAFFAIRS= '" . $mejob_generalaffairs . "',MEJOB_REVIEW= '" . $mejob_review . "' WHERE MEUSERID = '" . $rec[0] . "'";

	// print $UPDATE . "<br><br>";
	sqlsrv_query($con_wpmain, $UPDATE);
	// sqlsrv_query($con_wpmain,$UPDATE, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET )) or die( print_r( sqlsrv_errors(), true));

	$UPDATE2 = "UPDATE TM_MEMBER SET MEJOB_CC= '" . $mejob_cc . "',MEJOB_RA= '" . $mejob_ra . "',MEJOB_ENTRY= '" . $mejob_entry . "',MEJOB_GENERALAFFAIRS= '" . $mejob_generalaffairs . "',MEJOB_REVIEW= '" . $mejob_review . "' WHERE MEUSERID = '" . $rec[0] . "'";

	// print $UPDATE2 . "<br><br>";
	sqlsrv_query($con_wpmain, $UPDATE2);
}
