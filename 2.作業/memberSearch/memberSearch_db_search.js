
var dataToSend = "";
var 開始位置 = "";

// 結果リストエリアを非表示にする
$("#検索結果").hide(); 			

//検索ボタンクリック
$("#検索実行").click(function(a){ 
            a.preventDefault(); 			// 既定の動作をキャンセル ※送信の抑止
            開始位置 = 0;
            window.scrollTo(0, 0);
            
            DB111処理(); 
            closetoggle();

            //csvbtnControl();
        }); 



 //検索条件保存用グローバル変数
var previousSearch = {
    departmentname: "",
    officename: "",
    unitname: "",
    teamname: "",
    fullname: ""
};

var 表示用分岐 = "";
var 表示用検索語 = "";


function DB111処理(){ 
    
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
    dataToSend = "ORDER BY MECD";

    
    表示件数 = document.getElementById('display-count').value;

    //console.log(areaDB);
    //console.log(officenameDB);
    //console.log(teamnameDB);
    //console.log(unitnameDB);
    //console.log(fullnameDB);
    //console.log(positionDB);
    //console.log(roleDB);




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
                        var 分岐 = 'tm_wpdepartment.name';
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




    //console.log(分岐);
    //console.log(検索語);
    //console.log(役職名);
    //console.log(役割名);
                        
    //■結果リストBOXを表示
    $("#検索結果").show(); 

    

    //■隠しフィールド要素を取得
    //    const hiddenField = document.getElementById('example-id');
        
    //■値をセット
    if(検索語 != "" & 役職名 != "" & 役割名 != ""){
        //hiddenField.value = 検索語 + "," + 役職名 + "," + 役割名;
        var filename = 検索語 + "," + 役職名 + "," + 役割名;
    }else if(検索語 != "" & 役職名 != "" & 役割名 == ""){
        //hiddenField.value = 検索語 + "," + 役職名;
        var filename = 検索語 + "," + 役職名;
    }else if(検索語 != "" & 役職名 == "" & 役割名 != ""){
        //hiddenField.value = 検索語 + "," + 役割名;
        var filename = 検索語 + "," + 役割名;
    }else if(検索語 == "" & 役職名 != "" & 役割名 != ""){
        //hiddenField.value = 役職名 + "," + 役割名;
        var filename = 役職名 + "," + 役割名;
    }else if(検索語 != "" & 役職名 == "" & 役割名 == ""){
        //hiddenField.value = 検索語;
        var filename = 検索語;
    }else if(検索語 == "" & 役職名 != "" & 役割名 == ""){
        //hiddenField.value = 役職名;
        var filename = 役職名;
    }else if(検索語 == "" & 役職名 == "" & 役割名 != ""){
        //hiddenField.value = 役割名;
        var filename = 役割名;
    }



       

        if(分岐 == "tm_wpdepartment.name"){
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

    //    if(areaDB == "その他カテゴリー"){
     //       検索語 = null;
     //   }

     var オーダーSQL = dataToSend;

    
                    
    //取得した検索条件をDB_LIST.phpに送信
    $.post("memberSearch_DB_LIST.php", {表示総数:表示件数, 検索語句:検索語,開始:開始位置,分岐値:分岐,役職:役職名,役割:役割名,オーダー:オーダーSQL}, function(data){
                    if(data.length > 0){
                        $("#検索結果").html(data);
                        $("#pagination").empty();
                        $("#pagination2").empty();
                        if(総検索数 == "なし"){
                            return;
                        }else{
                        pagination222();
                        }
                    }
                                         
                    })







  
}


