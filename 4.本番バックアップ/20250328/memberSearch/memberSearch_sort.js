//ソートボタンクリック処理
$(".sortbutton").click(function(event){
    event.preventDefault();
    
     var inputsort = $(this).val(); // 送信するデータ
     var sortnum = inputsort;// 取得した値をJavaScript変数に格納
     
     
        if(sortnum == 'sort1'){
                dataToSend = "ORDER BY MESEIKANA ASC, MEMEIKANA ASC";//氏名
            
            
        }else if(sortnum == 'sort2'){
                dataToSend = "ORDER BY MESEIKANA DESC, MEMEIKANA DESC";//氏名
         
            
        }else if(sortnum == 'sort3'){
                dataToSend = "ORDER BY CONVERT(DATETIME, MEDATEOFENTER, 112) ASC, MECD ASC";//入社日
            
            
        }else if(sortnum == 'sort4'){
                dataToSend = "ORDER BY CONVERT(DATETIME, MEDATEOFENTER, 112) DESC, MECD DESC";//入社日
           
           
        }else if(sortnum == 'sort5'){
                dataToSend = "ORDER BY CASE WHEN MEFUNCTION = 501 THEN MEGRADE END DESC, MEGRADE DESC, MECD ASC";//役職
           
           
        }else if(sortnum == 'sort6'){
                dataToSend = "ORDER BY CASE WHEN MEFUNCTION = 501 THEN MEGRADE END ASC, MEGRADE ASC, MECD DESC";//役職
            
          
        }else if(sortnum == 'sort7'){
                dataToSend = "ORDER BY MEGRADE DESC, MECD ASC";//グレード
          
           
        }else if(sortnum == 'sort8'){
                dataToSend = "ORDER BY MEGRADE ASC, MECD DESC";//グレード
         
           
        }else if(sortnum == 'sort9'){
                dataToSend = "ORDER BY CONVERT(DATETIME, MEDATEOFENTER, 112) ASC, MECD ASC";//社歴
        
           
        }else if(sortnum == 'sort10'){
                dataToSend = "ORDER BY CONVERT(DATETIME, MEDATEOFENTER, 112) DESC, MECD DESC";//社歴
         
         
        }else if(sortnum == 'sort11'){
                dataToSend = "ORDER BY CASE WHEN MEEMPLOYMENT = 900 THEN 4 WHEN MEAUTHORITY_APP = 900 THEN 3 WHEN MEAUTHORITY_APP = 800 THEN 2 WHEN MEAUTHORITY_APP = 600 THEN 1 ELSE 0 END DESC, MECD ASC";//ユニット長フラグ
         
          
        }else if(sortnum == 'sort12'){
                dataToSend = "ORDER BY CASE WHEN MEEMPLOYMENT = 900 THEN 4 WHEN MEAUTHORITY_APP = 900 THEN 3 WHEN MEAUTHORITY_APP = 800 THEN 2 WHEN MEAUTHORITY_APP = 600 THEN 1 ELSE 0 END ASC, MECD DESC";//ユニット長フラグ
          
            
        }else if(sortnum == 'sort13'){
                dataToSend = "ORDER BY MEGRADE_sub DESC, MEGRADE DESC";//SPグレード
       
           
        }else if(sortnum == 'sort14'){
                dataToSend = "ORDER BY MEGRADE_sub ASC, MEGRADE ASC";//SPグレード


        }else if(sortnum == 'sort15'){
                dataToSend = "ORDER BY tm_wpdepartment.sort ASC, tm_wpunit.sort ASC, tm_wpteam.sort ASC, MECD ASC";//部
        

        }else if(sortnum == 'sort16'){
                dataToSend = "ORDER BY tm_wpdepartment.sort DESC, tm_wpunit.sort DESC, tm_wpteam.sort DESC, MECD DESC";//部

        
        }else if(sortnum == 'sort17'){
                dataToSend = "ORDER BY tm_wpunit.sort ASC, tm_wpoffice.id ASC, tm_wpteam.sort ASC, MECD ASC";//ユニット

        
        }else if(sortnum == 'sort18'){
                dataToSend = "ORDER BY tm_wpunit.sort DESC, tm_wpoffice.id DESC, tm_wpteam.sort DESC, MECD DESC";//ユニット

        }else if(sortnum == 'sort19'){
                dataToSend = "ORDER BY tm_wpunit.sort ASC, tm_wpoffice.id ASC, tm_wpteam.sort ASC, MECD ASC";//拠点

        
        }else if(sortnum == 'sort20'){
                dataToSend = "ORDER BY tm_wpunit.sort DESC, tm_wpoffice.id DESC, tm_wpteam.sort DESC, MECD DESC";//拠点
        
        }else if(sortnum == 'sort21'){
                dataToSend = "ORDER BY tm_wpunit.sort ASC, tm_wpoffice.id ASC, tm_wpteam.sort ASC, MECD ASC";//チーム


        }else if(sortnum == 'sort22'){
                dataToSend = "ORDER BY tm_wpunit.sort DESC, tm_wpoffice.id DESC, tm_wpteam.sort DESC, MECD DESC";//チーム

        }
        ////////
        //メモ//
        ////////
        //最後のMECDソートなしだとページング時に何故か並びがおかしくなる
        //おそらく通し番号？のソートが必要？
        


        if(開始位置 == 0){
                var i = 1;
        }else{
                var i = Math.ceil((開始位置+1)/表示件数);
        }
        console.log(開始位置);
    console.log(i);
    paginationSearch(i);
    window.scrollTo(0, 0);

});

//クリックイベント無効フラグ     
var クリック = false;     
            /*     
//次ボタンクリック処理
$(".次").click(function(a){
        a.preventDefault();//画面リロード防止

        if(!クリック){
          開始位置  = 開始位置 + 表示件数;
          window.scrollTo(0, 0);
          SORT処理();

          クリック = true;//クリックを無効化//クリックイベントのループ防止
         
        }
});

//前ボタンクリック処理
$(".前").click(function(a){
     
        a.preventDefault();//画面リロード防止
        
        if(!クリック){
          if(開始位置 >= 表示件数){開始位置 = 開始位置 - 表示件数} else 開始位置 = 0;
          window.scrollTo(0, 0);
          SORT処理();

          クリック = true;//クリックを無効化//クリックイベントのループ防止
        
        }
});*/

//エラーボックス表示
function termsErrorBox(){
     $("#overflow1").show();
}

//okボタン動作
function termsErrorOK(){
     $("#overflow1").hide(); // 確認ボックスを消す
     
         
}




function SORT処理(){ 


        var 分岐 = '';
        var 検索語 = '';
        var 役職名 = '';
        var 役割名 = '';
        
        //組織絞り込み
        var departmentnameDB = $("#departmentname").val();
        var officenameDB = $("#officename").val();
        var unitnameDB = $("#unitname").val();
        var teamnameDB = $("#teamname").val();
        var fullnameDB = $("#MEFULLNAME").val();
    
        //その他条件
        var positionDB = $("#position").val();
        var roleDB = $("#role").val();

        表示件数 = document.getElementById('display-count').value;
    
        console.log(departmentnameDB);
        console.log(officenameDB);
        console.log(teamnameDB);
        console.log(unitnameDB);
        console.log(fullnameDB);
        console.log(positionDB);
        console.log(roleDB);
    
    
    
    
        previousSearch = {
                departmentname: departmentnameDB,
                officename: officenameDB,
                unitname: unitnameDB,
                teamname: teamnameDB,
                fullname: fullnameDB,
                position: positionDB,
                role: roleDB
        };
    
        if(positionDB != ''){
            var 役職名 = positionDB;
        }
    
        if(roleDB != ''){
            var 役割名 = roleDB;
        }
    
    
    
    
    
        if(fullnameDB != ''){
            var 分岐 = 'MEFULLNAME';
            var 検索語 = fullnameDB;
        }else{
            if(teamnameDB != ''){
                var 分岐 = 'tm_wpteam.name';
                var 検索語 = teamnameDB;
            }else{
                if(unitnameDB != ''){
                    var 分岐 = 'tm_wpunit.name';
                    var 検索語 = unitnameDB;
                }else{
                    if(officenameDB != ''){
                        var 分岐 = 'officename';
                        var 検索語 = officenameDB;
                    }else{
                        if(departmentnameDB != ''){
                            var 分岐 = 'departmentname';
                            var 検索語 = departmentnameDB;
                        }else{
                         if(positionDB != '' || roleDB != ''){
    
                         }else{
                            termsErrorBox();
                            return;
                        
                         }
                        }
                    }
                }
            }
        }
    
    
    
  
                            
        $("#検索結果").show(); // 結果リストBOXを表示
    
        
    
        // まず隠しフィールド要素を取得
        const hiddenField = document.getElementById('example-id');

        //■値をセット
        if(検索語 != "" & 役職名 != "" & 役割名 != ""){
                hiddenField.value = 検索語 + "," + 役職名 + "," + 役割名;
        }else if(検索語 != "" & 役職名 != "" & 役割名 == ""){
                hiddenField.value = 検索語 + "," + 役職名;
        }else if(検索語 != "" & 役職名 == "" & 役割名 != ""){
                hiddenField.value = 検索語 + "," + 役割名;
        }else if(検索語 == "" & 役職名 != "" & 役割名 != ""){
                hiddenField.value = 役職名 + "," + 役割名;
        }else if(検索語 != "" & 役職名 == "" & 役割名 == ""){
                hiddenField.value = 検索語;
        }else if(検索語 == "" & 役職名 != "" & 役割名 == ""){
                hiddenField.value = 役職名;
        }else if(検索語 == "" & 役職名 == "" & 役割名 != ""){
                hiddenField.value = 役割名;
        }
    
            if(分岐 == "departmentname"){
                var 分岐名 = "部";
            }
            if(分岐 == "officename"){
                var 分岐名 = "拠点";
            }
            if(分岐 == "tm_wpunit.name"){
                var 分岐名 = "ユニット";
            }
            if(分岐 == "tm_wpteam.name"){
                var 分岐名 = "チーム";
            }
            if(分岐 == "MEFULLNAME"){
                var 分岐名 = "氏名";
            }
    
            表示用分岐 = 分岐名;
            表示用検索語 = 検索語;
    
    
            var オーダーSQL = dataToSend;
                        
        //取得した検索条件をDB_LIST.phpに送信
        $.post("memberSearch_DB_LIST.php", {表示総数:表示件数,検索語句:検索語,開始:開始位置,分岐値:分岐,役職:役職名,役割:役割名,オーダー:オーダーSQL}, function(data){
                        if(data.length > 0){
                            $("#検索結果").html(data);}
      
                        })
    
    
    
        
    
    
    
    
      
    }


    