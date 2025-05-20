
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