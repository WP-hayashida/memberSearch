<?php
session_start();

//wpdb01
require "../../DB/connect_wpmain_utf8.php";

foreach ($_POST['MEUSERID'] as $meuserid) {

	$select = "SELECT MEUSERID,姓,名,姓カナ,名カナ,性別,生年月日,住所_郵便番号,住所_都道府県,住所_区市町村,住所_詳細,携帯電話番号,自宅電話番号,携帯電話メールアドレス,入社日,退社日,所属部署,所属ユニット,所属グループ,権限,MEPOSITION,MEGRADE,MEEMPLOYMENT,MEBASE,MEOFFICE_BELONG,MEOFFICE_LOAN,MEUNIT,METEAM,MEJOB,MEAUTHORITY_APP,MEJOB_CC,MEJOB_RA,MEJOB_ENTRY,MEJOB_GENERALAFFAIRS,MEJOB_REVIEW FROM TM_MEMBER_management WHERE MEUSERID = '" . $meuserid . "'";
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
		$UPDATE = "UPDATE TM_MEMBER SET MEUSERID = '" . $rec[0] . "',MESEI = '" . $rec[1] . "',MEMEI = '" . $rec[2] . "',MESEIKANA = '" . $rec[3] . "',MEMEIKANA = '" . $rec[4] . "',MESEX = '" . $rec[5] . "',MEBIRTHDATE = '" . $rec[6] . "',MEZIPCODE = '" . $rec[7] . "',MEPREFECTURECD = '" . $rec[8] . "',MEADDRESS1 = '" . $rec[9] . "',MEADDRESS2 = '" . $rec[10] . "',MEMOBILENUM = '" . $rec[11] . "',MEPHONENUM = '" . $rec[12] . "',MEMOBILEMAIL = '" . $rec[13] . "',MEDATEOFQUIT = '" . $rec[15] . "',MEGROUP = '" . $rec[16] . "',MEEXTERNALGROUP = '" . $rec[17] . "',MEGROUP_FORCANDI = '" . $rec[18] . "',MEAUTHCD_FORCANDI = '" . $rec[19] . "',MEPOSITION = '" . $rec[20] . "',MEGRADE = '" . $rec[21] . "',MEEMPLOYMENT = '" . $rec[22] . "',MEBASE = '" . $rec[23] . "',MEOFFICE_BELONG = '" . $rec[24] . "',MEOFFICE_LOAN = '" . $rec[25] . "',MEUNIT = '" . $rec[26] . "',METEAM = '" . $rec[27] . "',MEJOB = '" . $rec[28] . "',MEAUTHORITY_APP = '" . $rec[29] . "',MEJOB_CC= '" . $mejob_cc . "',MEJOB_RA= '" . $mejob_ra . "',MEJOB_ENTRY= '" . $mejob_entry . "',MEJOB_GENERALAFFAIRS= '" . $mejob_generalaffairs . "',MEJOB_REVIEW= '" . $mejob_review . "' WHERE MEUSERID = '" . $meuserid . "'";

		//print $UPDATE."<br><br>";
		sqlsrv_query($con_wpmain, $UPDATE);
		// sqlsrv_query($con_wpmain,$UPDATE, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET )) or die( print_r( sqlsrv_errors(), true));

		$UPDATE2 = "UPDATE TM_MEMBER_management SET MEJOB_CC= '" . $mejob_cc . "',MEJOB_RA= '" . $mejob_ra . "',MEJOB_ENTRY= '" . $mejob_entry . "',MEJOB_GENERALAFFAIRS= '" . $mejob_generalaffairs . "',MEJOB_REVIEW= '" . $mejob_review . "' WHERE MEUSERID = '" . $meuserid . "'";
		sqlsrv_query($con_wpmain, $UPDATE2);
	}
}
