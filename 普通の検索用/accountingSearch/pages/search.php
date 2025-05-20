<?php error_reporting(E_ALL);?>
<!DOCTYPE html>

<html>


<head>
    <meta charset="utf-8">
    <title>社員検索システム</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" rel="stylesheet">

    <!-- jQuery（twbsPaginationに必要） -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS（必要であれば） -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- twbsPagination -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>

    <!---<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>--->



    <script src="../modules/select2.js"></script>
    <link href="../modules/select2.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/ja.js"></script> <!-- ←日本語化ファイルを読み込み -->

</head>



<body class="bg-light">
    <button class="btn btn-outline-dark btn-sm position-absolute top-0 end-0 m-2" accesskey="q" onclick="window.open('', '_self').close();">閉じる(Q)</button>

    <div class="container py-4">
        <div class="text-center mb-3">
            <h1 class="h3">社員検索システム</h1>
            <p class="text-muted small text-start" style="display:inline-block; margin: 0 auto;">
                ※条件を入力することで、それに属する組織や役職などを絞り込めます<br>
                ※同じカテゴリー内で、複数の選択肢を選ぶことができます<br>
                ※ボタンで選択中条件の全表示・一部表示の切り替えができます
            </p>
        </div>

        <!--条件指定フォーム -->
        <form method="post" name="sForm">
            <div class="item-form-wrapper" id="item-form-wrapper" style="">




                <div class="input-block" style="display: flex;  flex-direction: column; ">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3 border-bottom pb-3">
                        <button type="button" onclick="search();" name="search-button" id="search-button" class="btn btn-primary btn-sm" accesskey="s">検索(s)</button>
                        <button type="button" onclick="Clear();" class="btn btn-secondary btn-sm" name="clear" accesskey="c">クリア(c)</button>

                        <input type="button" id="csv-btn" value="CSV出力" class="btn btn-success btn-sm" name="出力" onclick="exportCsvAction()" disabled>

                        <select id="display-count" class="form-select form-select-sm w-auto">
                            <option value="10">表示10件</option>
                            <option value="25">表示25件</option>
                            <option value="50">表示50件</option>
                            <option value="100">表示100件</option>
                        </select>
                        <?php
                            $nowMonth = date('Y-m');
                        ?>
                        <input type="month" id="specified-month" class="form-control form-control-sm w-auto" min="2024-03" max="<?= $nowMonth ?>" value="<?= $nowMonth ?>">
                    </div>
                    <p style=" margin-bottom:-5px;text-decoration:underline;">組織絞り込み</p>
                    <div class="form-narrowdown" id="form-narrowdown-1" style="margin-left:5px;">
                        <div class="form" style="width: 15%; position:relative; color:black;" id="departmentnameform">
                            <label style="font-size: 14px;">部
                                <select class="pulldown" id='departmentname' name="departmentname" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="departmentnametgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--トグル記号版-->
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="areaplus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>
                                    <i class="toggle2 fa-solid fa-chevron-left " id="areaminus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>-->
                                <button type="button" class="toggle1  hidden" id="departmentnameplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="departmentnameminus" >選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 15%; position:relative; color:black;" id="officenameform">
                            <label style="font-size: 14px;">所属拠点
                                <select class="pulldown" id="officename" name="officename" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="officenametgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="officenameplus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>
                                <i class="toggle2 fa-solid fa-chevron-left " id="officenameminus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>  -->
                                <button type="button" class="toggle1  hidden" id="officenameplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="officenameminus" >選択中を隠す</button>
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
                                <button type="button" class="toggle1  hidden" id="unitnameplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="unitnameminus" >選択中を隠す</button>
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
                                <button type="button" class="toggle1  hidden" id="teamnameplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="teamnameminus" >選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 20%; position:relative; color:black;" id="MEFULLNAMEform">
                            <label style="font-size: 14px;">氏名
                                <select class="pulldown" id="MEFULLNAME" name="MEFULLNAME" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="MEFULLNAMEtgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <!--<i class="toggle1 fa-solid fa-chevron-down hidden" id="MEFULLNAMEplus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>
                                    <i class="toggle2 fa-solid fa-chevron-left " id="MEFULLNAMEminus" style="position: absolute; top:7px; right:10px; font-size:15px; color: #6c7686; "></i>-->
                                <button type="button" class="toggle1  hidden" id="MEFULLNAMEplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="MEFULLNAMEminus" >選択中を隠す</button>
                            </p>
                        </div>
                    </div>

                    <p style=" margin-bottom:-5px;text-decoration:underline;">個別情報絞り込み</p>
                    <div class="form-narrowdown" id="form-narrowdown-2" style="margin-left:5px;">
                        <div class="form" style="width: 15%; position:relative; color:black; float:left;" id="positionform">
                            <label style="font-size: 14px;">職位
                                <select class="pulldown" id="position" name="position" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="positiontgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <button type="button" class="toggle1  hidden" id="positionplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="positionminus" >選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 15%; position:relative; color:black; float:left;" id="roleform">
                            <label style="font-size: 14px;">役職
                                <select class="pulldown" id="role" name="role" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="roletgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <button type="button" class="toggle1  hidden" id="roleplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="roleminus" >選択中を隠す</button>
                            </p>
                        </div>

                        <div class="form" style="width: 15%; position:relative; color:black; float:left;" id="MEOFFICE_LOANform">
                            <label style="font-size: 14px;">勤務拠点
                                <select class="pulldown" id="MEOFFICE_LOAN" name="MEOFFICE_LOAN" multiple>
                                    <option value=""></option>
                                </select>
                            </label>
                            <p class="pulltgl" id="MEOFFICE_LOANtgl" style=" z-index:1010; background-color: rgba(0, 0, 0, 0); border-style: none;">
                                <button type="button" class="toggle1  hidden" id="MEOFFICE_LOANplus" >選択中を見る</button>
                                <button type="button" class="toggle2  " id="MEOFFICE_LOANminus" >選択中を隠す</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- ページネーションボタン表示領域 -->

        <div class="d-flex justify-content-between align-items-center" style="width:94%; margin:auto; margin-top:10px;">
            <div id="resultInfoTop" class="text-start"></div>
            <ul id="pagination" class="pagination pagination-sm mb-0"></ul>
        </div>
        <div class="result" id="result" style=" width:94%; margin:auto;"></div>

        <div class="d-flex justify-content-end align-items-center" style="width:94%; margin:auto; margin-top:10px; padding-bottom:40px">
            <ul id="paginationBottom" class="pagination pagination-sm mb-0"></ul>
        </div>

    <!--トップへ戻るボタン-->
    <div class="pagetop">↑</div>


</body>
</html>


<script src="../js/data.js"></script>
<script src="../js/function.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/encoding-japanese/1.0.30/encoding.min.js"></script>
<script src="../js/exportCSV.js"></script>