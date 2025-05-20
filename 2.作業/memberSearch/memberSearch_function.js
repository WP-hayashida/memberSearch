//■条件クリア関数
function Clear(){

    resettoggle();
    clearPullGenerate();
}
         
//■トグルボタンの制御
function resettoggle(){
    $(".toggle1").removeClass('hidden');
    $(".toggle2").removeClass('hidden');
    $(".toggle1").addClass('hidden');
    $(".select2-container").removeClass('no-whitespace');
    $(".select2-container").removeClass('normal');
    $(".select2-container").addClass('normal');
}








/*
function csvbtnControl(){
    if(総検索数 != 0){
        $("#csv-btn").prop("disabled", false); // csv出力ボタンを無効化
    }else{
        $("#csv-btn").prop("disabled", true); // csv出力ボタンを無効化
    }
}*/


//SELECT2を使わない場合
//条件入力ポップアップ   

//var CHANGE_OBJECT = {
 //   onSearchFieldChange : function(obj,value){
 //       var objid = obj.id;
        /* alert(objid);
        alert(value);*/
//        var selectBox = document.getElementById(objid);
 //       var items = selectBox.children;
 //       if (value === "") {
 //           for(var i=items.length-1; i>=0; i--){
//                items[i].style.display = "";
//                items[i].selected = false;
//            }
            //検索ワードが空なら閉じる
//            close_inputBox(obj.name);
//            return;
//        }
//        var count = 0;
//        var tcount = 0;
//        var reg = new RegExp(".*"+value+".*","i");
//        for(var i=items.length-1; i>=0; i--){
//            if(items[i].textContent.match(reg) != ""){
//                if ( items[i].textContent.match(reg) ){
//                    items[i].style.display = "";
//                    items[i].selected = true;
//                    count = count + 1;
//                } else {
//                    items[i].style.display = "none";
//                }
//            }else{


//            }
//            tcount = tcount + 1;
            //items[i].selected = false;
//        }
//        var textname = objid +"_text";
//        if(count == tcount){
//            selectBox.size= 1;
//        }else if(count <= 3){
//            selectBox.size= count;
//        }else{
//            selectBox.size= 3;
//        }
//        close_inputBox(obj.name);
//    }

//}
//function changeFormat(obj){
//    var objname = obj.id;
//    var textName = objname.replace("_text","");

//    document.getElementById(textName).classList.remove("hidden");
//    document.getElementById(objname).classList.add("hidden");

//}
//function changeFormat2(obj){
//    var objname = obj.id;
    //alert(objname);
//    var selectname = objname+"_text";
//    //alert(selectname);
//    document.getElementById(selectname).classList.remove("hidden");
//    document.getElementById(objname).classList.add("hidden");

//}


//=====================
//　入力欄を出す
//=====================
//function open_inputBox(objName,obj){
    //objName :select要素の名前
//    var child = objName + "_popup";// ポップアップするdivの名前(_popupで名づけておく)
//    var childBox = objName + "_popupBox";// 上記div内inputboxの名前(_popupBoxで名づけておく)
//    var objid = obj.id;
//    var selectBox = document.getElementById(objid);
//    selectBox.size= 1;
    //divを表示させる前に位置を調整する(セレクトボックスのちょうど真下に出るように)
//    /**/var X = document.getElementsByName(objName)[0].getBoundingClientRect().left;//セレクトボックスのX座標
//    /**/var Y = document.getElementsByName(objName)[0].getBoundingClientRect().top;//セレクトボックスのY座標
    /**/
//    /**/var hei_pulldown = document.getElementsByName(objName)[0].offsetHeight;//セレクトボックスの高さ

    /**///x.y座標の調整
//    /**/document.getElementsByName(child)[0].style.top  = (Y + hei_pulldown);
//    /**/document.getElementsByName(child)[0].style.left = X;

    //divを表示させる
//    document.getElementsByName(child)[0].style.display = "block";

    //inputboxにフォーカスをあてる
//    document.getElementsByName(childBox)[0].focus();

    //inputboxにonkeypressイベントを付与
//    document.getElementsByName(childBox)[0].onkeypress = function(){return check_key(this.value, event, objName,obj);};

    
    

    

    //いまのままだと入力しないと閉じる関数動かないので、
    //inputboxをonblurで閉じさせるようにする
//    document.getElementsByName(childBox)[0].onblur = function(){close_inputBox(objName)};
//}

//=====================
//　入力欄を閉じる
//=====================
//function close_inputBox(objName){
    //子供たちの要素名を再定義
//    var child = objName + "_popup";
//    var childBox = objName + "_popupBox";

//    document.getElementsByName(childBox)[0].value = "";
//    document.getElementsByName(child)[0].style.display = "none";
//}

//=====================
//　入力判定
//=====================
//function check_key(value, e, objName,obj){
    //子供たちの要素名を再定義
//    var child = objName + "_popup";
//    var childBox = objName + "_popupBox";


//    if(!e){
//        var e = window.event;
//    }

    //enterが押されたら検索させる
//    if(e.keyCode == 13){

//        CHANGE_OBJECT.onSearchFieldChange(obj, value);
//        return false;

//    }


//}





/*

const targetNode = document.getElementById('検索結果');



const observer = new MutationObserver(mutationsList => {
    for(let mutation of mutationsList) {
        if (mutation.type === 'childList') {
            console.log('HTMLが書き換えられました');
            // ここで適切な処理を実行する
            document.getElementById('item-form-wrapper').style.setProperty('border-bottom', '0px solid green', 'important');
            document.getElementById('box').style.setProperty('border-bottom', '5px solid green', 'important');
            document.getElementById('line').style.setProperty('border-bottom', '0px solid green', 'important');
            


        }
    }
});

observer.observe(targetNode, { attributes: true, childList: true, subtree: true });

*/