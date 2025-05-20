//■条件クリア関数
function Clear() {
    resettoggle();
    clearPullGenerate();
}

//■トグルボタンの制御
function resettoggle() {
    $(".toggle1").removeClass('hidden');
    $(".toggle2").removeClass('hidden');
    $(".toggle1").addClass('hidden');
    $(".select2-container").removeClass('no-whitespace');
    $(".select2-container").removeClass('normal');
    $(".select2-container").addClass('normal');
}