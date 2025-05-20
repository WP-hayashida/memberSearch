<?php
//■検索条件受け取り
    if(isset($_POST['表示総数'])){$_SESSION['セッション表示件数'] = $_POST['表示総数'];}
    if(isset($_POST['検索語句'])){$_SESSION['セッション検索語'] = $_POST['検索語句'];}
    if(isset($_POST["開始"])){$_SESSION['セッション開始位置'] = $_POST["開始"];}
    if(isset($_POST['分岐値'])){$_SESSION['セッション分岐値'] = strip_tags($_POST['分岐値']);}
    if(isset($_POST['役職'])){$_SESSION['セッション役職'] = ($_POST['役職']);}
    if(isset($_POST['役割'])){$_SESSION['セッション役割'] = ($_POST['役割']);}
    if(isset($_POST['オーダー'])){$_SESSION['セッションオーダー'] = strip_tags($_POST['オーダー']);};
?>