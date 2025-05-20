<?php
session_start();
// error_reporting(E_ALL);


require "../../DB/connect_wpmain_utf8.php";
require "../../DB/connect_econcier_wpmain.php";
require_once "function_encoding.php";

?>
<!doctype html>
<html>

<head>
	<script type="text/javascript" src="messagebox.js"></script>
	<link rel="stylesheet" href="base.css">
	<link rel="stylesheet" type="text/css" href="messagebox.css">
	<script type="text/javascript" src="inputPulldown.js"></script>
	<script type="text/javascript" src="jquery-1.9.1.js"></script>

	<meta charset="utf-8">
	<title>データ反映(TM_MEMBER⇔TM_MEMBER_management)</title>

	<script>
		function dataReflect1(cd, name) {


			if (name == '') {

				MessageBox.Alert_Yes("対象者が選択されていません。");

			} else {

				MessageBox.Confirm_YesNo(name + "さんの【TM_MEMBER】のデータを【TM_MEMBER_management】に反映しますか？", function() {
					jQuery.ajax({
						type: "POST",
						url: "dataReflectToManagementAction.php",
						dataType: "text",
						data: {
							"MECD": cd
						},
						timeout: 10000,
						async: false,
						success: function(code) {
							// console.log(code);
							MessageBox.Alert("反映しました。" + code);
							location.reload();
						},
						error: function(code) {

							alert("エラーが発生しました。もう一度やり直してください。");
						},
						complete: function(code) {

						}
					});
				}, function() {});
			}

		}

		function dataReflect2(userid, name) {


			if (name == '') {

				MessageBox.Alert_Yes("対象者が選択されていません。");

			} else {

				MessageBox.Confirm_YesNo(name + "さんの【TM_MEMBER_management】のデータを【TM_MEMBER】に反映しますか？", function() {
					jQuery.ajax({
						type: "POST",
						url: "dataReflectToManagementAction2.php",
						dataType: "text",
						data: {
							"MEUSERID": userid
						},
						timeout: 10000,
						async: false,
						success: function(code) {
							MessageBox.Alert("反映しました。" + code);
							location.reload();
						},
						error: function(code) {

							alert("エラーが発生しました。もう一度やり直してください。");
						},
						complete: function(code) {

						}
					});
				}, function() {});
			}

		}

		function dataReflectSelected() {
			//selectされてる人
			var MEUSERID = [];
			var elements = document.getElementsByName('dataReflecter');

			for (var i = 0; i < elements.length; i++) {
				if (elements[i].checked == true) {
					MEUSERID.push(elements[i].value);
				}
			}

			MessageBox.Confirm_YesNo("選択された方の【TM_MEMBER】のデータを【TM_MEMBER_management】に反映しますか？",

				function() {
					jQuery.ajax({
						type: "POST",
						url: "dataReflectToManagementSelected.php",
						dataType: "text",
						data: {
							"MEUSERID": MEUSERID
						},
						timeout: 10000,
						async: false,
						success: function(code) {
							// console.log(code);
							//alert(code);
							MessageBox.Alert("反映しました。" + code);
							location.reload();

						},
						error: function() {

							MessageBox.Alert("エラーが発生しました。もう一度やり直してください。");
						}
					})
				},
				function() {},
				function() {}

			)

		}

		function dataReflectSelected2() {
			//selectされてる人
			var MEUSERID = [];
			var elements = document.getElementsByName('dataReflecter');

			for (var i = 0; i < elements.length; i++) {
				if (elements[i].checked == true) {
					MEUSERID.push(elements[i].value);
				}
			}

			MessageBox.Confirm_YesNo("選択された方の【TM_MEMBER_management】のデータを【TM_MEMBER】に反映しますか？",

				function() {
					jQuery.ajax({
						type: "POST",
						url: "dataReflectToManagementSelected2.php",
						dataType: "text",
						data: {
							"MEUSERID": MEUSERID
						},
						timeout: 10000,
						async: false,
						success: function(code) {
							//alert(code);
							MessageBox.Alert("反映しました。" + code);
							location.reload();
						},
						error: function() {

							MessageBox.Alert("エラーが発生しました。もう一度やり直してください。");
						}
					})
				},
				function() {},
				function() {}

			)

		}
	</script>
</head>

<body style="background: #f5f5f5;">
	<div id="screenLock"></div>
	<div id="messageBox">
		<div id="messageTitle"><br></div>
		<div id="messageBody">ここにメッセージが入ります。</div>
		<div id="messageButton">
			<button id="yesBtn">はい</button>
			<button id="noBtn">いいえ</button>
			<button id="cslBtn">キャンセル</button>
		</div>
	</div>
	<div style="text-align:right;width:930px; margin: 0 auto"><input type="button" value="選択者のデータをTM_MEMBER_managementへ反映" onclick="dataReflectSelected()" style="margin-right: 3px;"><input type="button" value="選択者のデータをTM_MEMBERへ反映" onclick="dataReflectSelected2()"><input type="button" style="margin-left: 3px;" onClick="window.close();" value="閉(Q)" accesskey="q"></div>
	<div style="border: none"></div>
	<br><br>
	<div style="width:930px; margin: 0 auto">
		<table border="1" style="font-size:15px; border-collapse:collapse">
			<!--
	<thead style="background:silver">
	<tr>
		<td width="40px;"> </td>
		<td width="150px" style="text-align:center">姓名</td>
		<td width="300px" style="text-align:center">TM_MEMBER</td>
		<td width="80px"> </td>
		<td width="300px" style="text-align:center">TM_MEMBER_management</td>


	</tr>
	</thead>
-->
			<tbody>
				<?php

				$array = array('MEUSERID', 'MESEI', 'MEMEI', 'MESEIKANA', 'MEMEIKANA', 'MESEX', 'MEBIRTHDATE', 'MEZIPCODE', 'MEPREFECTURECD', 'MEADDRESS1', 'MEADDRESS2', 'MEMOBILENUM', 'MEPHONENUM', 'MEMOBILEMAIL', 'MEDATEOFQUIT', 'MEGROUP', 'MEEXTERNALGROUP', 'MEGROUP_FORCANDI', 'MEAUTHCD_FORCANDI', 'MEPOSITION', 'MEGRADE', 'MEEMPLOYMENT', 'MEBASE', 'MEOFFICE_BELONG', 'MEOFFICE_LOAN', 'MEUNIT', 'METEAM', 'MEJOB', 'MEAUTHORITY_APP', 'MEJOB_CC', 'MEJOB_RA', 'MEJOB_ENTRY', 'MEJOB_GENERALAFFAIRS', 'MEJOB_REVIEW');

				$array2 = array('MEUSERID', '姓', '名', '姓カナ', '名カナ', '性別', '生年月日', '住所_郵便番号', '住所_都道府県', '住所_区市町村', '住所_詳細', '携帯電話番号', '自宅電話番号', '携帯電話メールアドレス', '退社日', '所属部署', '所属ユニット', '所属グループ', '権限', 'MEPOSITION', 'MEGRADE', 'MEEMPLOYMENT', 'MEBASE', 'MEOFFICE_BELONG', 'MEOFFICE_LOAN', 'MEUNIT', 'METEAM', 'MEJOB', 'MEAUTHORITY_APP', 'MEJOB_CC', 'MEJOB_RA', 'MEJOB_ENTRY', 'MEJOB_GENERALAFFAIRS', 'MEJOB_REVIEW');

				$select = "select MEUSERID,MESEI,MEMEI,MESEIKANA,MEMEIKANA,MESEX,MEBIRTHDATE,MEZIPCODE,MEPREFECTURECD,MEADDRESS1,MEADDRESS2,MEMOBILENUM,MEPHONENUM,MEMOBILEMAIL,MEDATEOFQUIT,MEGROUP,MEEXTERNALGROUP,MEGROUP_FORCANDI,MEAUTHCD_FORCANDI,MEPOSITION,MEGRADE,MEEMPLOYMENT,MEBASE,MEOFFICE_BELONG,MEOFFICE_LOAN,MEUNIT,METEAM,MEJOB,MEAUTHORITY_APP,MEJOB_CC,MEJOB_RA,MEJOB_ENTRY,MEJOB_GENERALAFFAIRS,MEJOB_REVIEW,MECD from TM_MEMBER where MECD > 03000 and MEINVALIDFLAG = 0";
				$dyn = sqlsrv_query($con_wpmain, $select);

				while ($rec = sqlsrv_fetch_array($dyn)) {

					$tm = '';
					$tmM = '';

					if ($rec['MESEX'] == '1') {

						$color = "blue";
					} else {

						$color = "red";
					}

					$select2 = "select MEUSERID,姓,名,姓カナ,名カナ,性別,生年月日,住所_郵便番号,住所_都道府県,住所_区市町村,住所_詳細,携帯電話番号,自宅電話番号,携帯電話メールアドレス,退社日,所属部署,所属ユニット,所属グループ,権限,MEPOSITION,MEGRADE,MEEMPLOYMENT,MEBASE,MEOFFICE_BELONG,MEOFFICE_LOAN,MEUNIT,METEAM,MEJOB,MEAUTHORITY_APP,MEJOB_CC,MEJOB_RA,MEJOB_ENTRY,MEJOB_GENERALAFFAIRS,MEJOB_REVIEW from TM_MEMBER_management where MEUSERID = '" . $rec['MEUSERID'] . "'";
					$dyn2 = sqlsrv_query($con_wpmain, $select2);

					if ($rec2 = sqlsrv_fetch_array($dyn2)) {
						for ($i = 0; $i < 34; $i++) {

							if ($rec[$i] != $rec2[$i]) {

								$tm .= $array[$i] . "【" . $rec[$i] . "】<br>";
								$tmM .= $array2[$i] . "【" . $rec2[$i] . "】<br>";
							}
						}

						if (!empty($tm) || !empty($tmM)) {

							print <<< EOM
	<thead style="background:silver">
	<tr>
		<td width="40px;"> </td>
		<td style="text-align:center;width:150px">姓名</td>
		<td style="text-align:center;width:350px">TM_MEMBER</td>
		<td style="text-align:center;width:80px"> </td>
		<td style="text-align:center;width:350px">TM_MEMBER_management</td>


	</tr>
	</thead>
	<tr>
		<td style='text-align:center'><input type="checkbox" name="dataReflecter" value="{$rec['MEUSERID']}"></td>
		<td style="color:{$color};text-align:center;width:150px;">{$rec['MESEI']} {$rec['MEMEI']}</td>
		<td style="width:350px">{$tm}</td>
		<td style="width:80px;"><input type='button' style='width:100%;height:100%;margin-bottom:5px' value='▶へ反映' onClick='dataReflect1("{$rec['MECD']}","{$rec['MESEI']} {$rec['MEMEI']}")'><input type='button' style='width:100%;height:100%;' value='◀へ反映' onClick='dataReflect2("{$rec['MEUSERID']}","{$rec['MESEI']} {$rec['MEMEI']}")'></td>
		<td style="width:350px;">{$tmM}</td>

	</tr>
EOM;
						}
					}
				}

				?>
			</tbody>
		</table>
	</div>
</body>

</html>