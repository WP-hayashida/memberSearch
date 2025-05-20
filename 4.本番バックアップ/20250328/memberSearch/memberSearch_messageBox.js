//エラーボックス表示
function noDataErrorBox(){
    //$(".overflow").show();
    var modal = document.getElementById("overflow");
    modal.style.display = "block";   
}

//リセットボタン動作
function noDataErrorReset(){
    //$(".overflow").hide(); // 確認ボックスを消す

    var modal = document.getElementById("overflow");
    modal.style.display = "none";
    location.reload();

}


//OKボタン動作
function noDataErrorOK(){
    //$(".overflow").hide(); // 確認ボックスを消す
    var modal = document.getElementById("overflow");
    modal.style.display = "none";

}


//エラーボックス表示
function termsErrorBox(){
    $("#overflow1").show();
}

//リセットボタン動作
function termsErrorReset(){
    //$(".overflow").hide(); // 確認ボックスを消す

    var modal = document.getElementById("overflow1");
    modal.style.display = "none";
    

    location.reload();
}


//OKボタン動作
function termsErrorOK(){
//$(".overflow").hide(); // 確認ボックスを消す


var modal = document.getElementById("overflow1");
modal.style.display = "none";
    

}