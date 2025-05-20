const toggleButton1 = document.getElementById('departmentnametgl');
const toggleButton2 = document.getElementById('officenametgl');
const toggleButton3 = document.getElementById('unitnametgl');
const toggleButton4 = document.getElementById('teamnametgl');
const toggleButton5 = document.getElementById('MEFULLNAMEtgl');
const toggleButton6 = document.getElementById('positiontgl');
const toggleButton7 = document.getElementById('roletgl');

    toggleButton1.addEventListener('click', function() {
        const plusIcon = document.getElementById('departmentnameplus');
        const minusIcon = document.getElementById('departmentnameminus');
        const $departmentnameelm = $("#departmentnameform .select2-container");

        //var check = $areaelm.hasClass('normal');
        

        //const toggleElement = document.getElementById('areaform');
        plusIcon.classList.toggle('hidden');
        minusIcon.classList.toggle('hidden');
        $departmentnameelm.toggleClass('normal');
        $departmentnameelm.toggleClass('no-whitespace');
    //    var check = $areaelm.hasClass('normal');

        //動作簡略化用
    /*    if (check == true) {
            $('#areaform .pulldown').select2('open');
        } else {
            $('#areaform .pulldown').select2('close');

        }*/
    });

/*    $(document).ready(function() {
    const $Checkbox2 = $("#check2");
    const $officenameelm = $("#officenameform .select2-container");
    
    $Checkbox2.on('change', function() {
        if (this.checked) {
            console.log('ボタンはオンです');
            $officenameelm.removeClass('no-whitespace').addClass('normal');
        } else {
            console.log('ボタンはオフです');
            $officenameelm.removeClass('normal').addClass('no-whitespace');
        }
    });
    });
*/







    toggleButton2.addEventListener('click', function() {
        const plusIcon = document.getElementById('officenameplus');
        const minusIcon = document.getElementById('officenameminus');
        const $officenameelm = $("#officenameform .select2-container");

        //const toggleElement = document.getElementById('areaform');
        plusIcon.classList.toggle('hidden');
        minusIcon.classList.toggle('hidden');
        $officenameelm.toggleClass('normal');
        $officenameelm.toggleClass('no-whitespace');
    //    var check = $officenameelm.hasClass('normal');


        //動作簡略化用
    /*    if (check == true) {
            $('#officenameform .pulldown').select2('open');
        } else {
            $('#officenameform .pulldown').select2('close');
        
        }*/

    });


    toggleButton3.addEventListener('click', function() {
        const plusIcon = document.getElementById('unitnameplus');
        const minusIcon = document.getElementById('unitnameminus');
        const $unitnameelm = $("#unitnameform .select2-container");

        //const toggleElement = document.getElementById('areaform');
        plusIcon.classList.toggle('hidden');
        minusIcon.classList.toggle('hidden');
        $unitnameelm.toggleClass('normal');
        $unitnameelm.toggleClass('no-whitespace'); 
    //    var check = $unitnameelm.hasClass('normal');


        
        //動作簡略化用
     /*   if (check == true) {
            $('#unitnameform .pulldown').select2('open');
        } else {
            $('#unitnameform .pulldown').select2('close');
        
        }*/

    });


/*    $(document).ready(function() {
        const $Checkbox3 = $("#check3");
        const $unitnameelm = $("#unitnameform .select2-container");
        
        $Checkbox3.on('change', function() {
            if (this.checked) {
                console.log('ボタンはオンです');
                $unitnameelm.removeClass('no-whitespace').addClass('normal');
            } else {
                console.log('ボタンはオフです');
                $unitnameelm.removeClass('normal').addClass('no-whitespace');
            }
        });
        });

*/



    toggleButton4.addEventListener('click', function() {
        const plusIcon = document.getElementById('teamnameplus');
        const minusIcon = document.getElementById('teamnameminus');
        const $teamnameelm = $("#teamnameform .select2-container");


        //const toggleElement = document.getElementById('areaform');
        plusIcon.classList.toggle('hidden');
        minusIcon.classList.toggle('hidden');
        $teamnameelm.toggleClass('normal');
        $teamnameelm.toggleClass('no-whitespace');
      //  var check = $teamnameelm.hasClass('normal');


        
        //動作簡略化用
    /*    if (check == true) {
            $('#teamnameform .pulldown').select2('open');
        } else {
            $('#teamnameform .pulldown').select2('close');
        
        }*/

    });


/*    $(document).ready(function() {
        const $Checkbox4 = $("#check41");
        const $teamnameelm = $("#teamnameform .select2-container");
        
        $Checkbox4.on('change', function() {
            if (this.checked) {
                console.log('ボタンはオンです');
                $teamnameelm.removeClass('no-whitespace').addClass('normal');
            } else {
                console.log('ボタンはオフです');
                $teamnameelm.removeClass('normal').addClass('no-whitespace');
            }
        });
        });  */

    toggleButton5.addEventListener('click', function() {
        const plusIcon = document.getElementById('MEFULLNAMEplus');
        const minusIcon = document.getElementById('MEFULLNAMEminus');
        const $MEFULLNAMEelm = $("#MEFULLNAMEform .select2-container");

        //const toggleElement = document.getElementById('areaform');
        plusIcon.classList.toggle('hidden');
        minusIcon.classList.toggle('hidden');
        $MEFULLNAMEelm.toggleClass('normal');
        $MEFULLNAMEelm.toggleClass('no-whitespace');
    //    var check = $MEFULLNAMEelm.hasClass('normal');



        
        //動作簡略化用
     /*   if (check == true) {
            $('#MEFULLNAMEform .pulldown').select2('open');
        } else {
            $('#MEFULLNAMEform .pulldown').select2('close');
        
        }*/

    });



    toggleButton6.addEventListener('click', function() {
        const plusIcon = document.getElementById('positionplus');
        const minusIcon = document.getElementById('positionminus');
        const $positionelm = $("#positionform .select2-container");

        //const toggleElement = document.getElementById('areaform');
        plusIcon.classList.toggle('hidden');
        minusIcon.classList.toggle('hidden');
        $positionelm.toggleClass('normal');
        $positionelm.toggleClass('no-whitespace');
    });


    toggleButton7.addEventListener('click', function() {
        const plusIcon = document.getElementById('roleplus');
        const minusIcon = document.getElementById('roleminus');
        const $roleelm = $("#roleform .select2-container");

        //const toggleElement = document.getElementById('areaform');
        plusIcon.classList.toggle('hidden');
        minusIcon.classList.toggle('hidden');
        $roleelm.toggleClass('normal');
        $roleelm.toggleClass('no-whitespace');
    });


    function closetoggle(){
        $(".toggle1").removeClass('hidden');
        $(".toggle2").removeClass('hidden');
        $(".toggle2").addClass('hidden');
        $(".select2-container").removeClass('no-whitespace');
        $(".select2-container").removeClass('normal');
        $(".select2-container").addClass('no-whitespace');




        //動作簡略化用
        
    }



    //動作簡略化用
    // プルダウンとテキストボックスの要素を取得
/*  
// 別の方法で$selectbox1を取得する
var $selectbox1 = $("#areaform .select2-container");

// 関数を作成してクラスの確認を行う



function checkSelectboxClass() {
    if ($selectbox1.hasClass('normal')) {
        console.log("aaaa");
        //textBoxContainer.style.display = 'block'; // テキストボックスを表示
        $selectbox1.siblings('.pulldown').select2('open');
    } else {
        //textBoxContainer.style.display = 'none'; // テキストボックスを非表示
        $selectbox1.siblings('.pulldown').select2('close');
    }
}

// 初期状態でクラスをチェックする
checkSelectboxClass();

// $selectbox1の変更に対応するための監視
$("#areatgl").on('click', function() {
    // 変更があったら再度クラスを確認する
    console.log("sssss");
    checkSelectboxClass();
});*/