var globalTotalItem = "";
var PER_PAGE = "";
var initialPage = "";
var totalPages = "";
var currentPage = "";


    // 前へ_DOM指定
    const prevButton = document.getElementById("js-button-prev");
    // 次へ_DOM指定
    const nextButton = document.getElementById("js-button-next");


    // 前へ_DOM指定
    const prevButton2 = document.getElementById("js-button-prev2");
    // 次へ_DOM指定
    const nextButton2 = document.getElementById("js-button-next2");









//console.log("kokomade");
     // レンダリング
     function render(){
        //検索条件表示用
       // document.getElementById(　　　
        //    "terms"
       // ).innerHTML = displayHiddenField.value;

        
        document.getElementById(
            "js-pagination-result-total"
        ).innerHTML = globalTotalItem;
      
        document.getElementById(
            "js-pagination-result-range-text"
        ).innerHTML = rangeCurrentPage();
       


        document.getElementById(
            "js-pagination-result-total2"
        ).innerHTML = globalTotalItem;
      
        document.getElementById(
            "js-pagination-result-range-text2"
        ).innerHTML = rangeCurrentPage();
        

    };

         // 閲覧中の情報の件数の範囲を表示
         function rangeCurrentPage(){
            if (!globalTotalItem) return;
            const start = (currentPage-1) * PER_PAGE + 1;
            開始位置 = start - 1;
                
            const text =
                (currentPage ) * PER_PAGE < globalTotalItem
                ? `${start}件〜${(currentPage) * PER_PAGE}件目`
                : `${start}件〜${globalTotalItem}件目`;
            return text;
        };


        function handleButtonActionPrev() {
            if (initialPage >= currentPage) return;
            currentPage = currentPage - 1;
            paginationSearch(currentPage)
            render();
            updatePaginationWord();
            updateStyles(); // クリック時にスタイルを更新
            window.scrollTo(0, 0);
            //SORT処理();
        }
        
        function handleButtonActionNext() {
            if (currentPage + 1 > totalPages) return;
            currentPage = currentPage + 1;
            paginationSearch(currentPage)
            render();
            updatePaginationWord();
            updateStyles(); // クリック時にスタイルを更新
            window.scrollTo(0, 0);
            //SORT処理();
        }

        


//数字ボタン更新用
function updatePaginationNum(event) {
    currentPage = Number(event.target.value);
   //const totalPages = 10; // 合計ページ数
   const pagination = generatePagination(currentPage, totalPages);
   document.getElementById('pagination').innerHTML = pagination;
   const pagination2 = generatePagination2(currentPage, totalPages);
   document.getElementById('pagination2').innerHTML = pagination2;

   render();
   //updateStyles();
 }



//前へ次へボタン更新用
 function updatePaginationWord() {
   
  //const totalPages = 10; // 合計ページ数
  const pagination = generatePagination(currentPage, totalPages);
  document.getElementById('pagination').innerHTML = pagination;
  const pagination2 = generatePagination2(currentPage, totalPages);
  document.getElementById('pagination2').innerHTML = pagination2;

  render();
  //updateStyles();
}



function updateStyles(value) {

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.getElementById('btn' + i);
        const btn2 = document.getElementById('2btn' + i);

        if (i === currentPage ) {
            btn.style.pointerEvents = 'none';
            btn.style.color = '#ff8080';
            btn.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
            btn.style.border = '1px solid rgba(120, 120, 120, 0.1)';
            btn.style.borderRadius ='5%';
            
        } else if(!btn) {
            continue;
        }else{
        
            btn.style.pointerEvents = 'auto';
            btn.style.color = ''; // デフォルトの文字色に戻す
            btn.style.backgroundColor = ''; // デフォルトの背景色に戻す
            btn.style.border = '';
            btn.style.borderRadius ='';
        }

        if (i === currentPage ) {
            btn2.style.pointerEvents = 'none';
            btn2.style.color = '#ff8080';
            btn2.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
            btn2.style.border = '1px solid rgba(120, 120, 120, 0.1)';
            btn2.style.borderRadius ='5%';
            
        } else if(!btn) {
            continue;
        }else {
            btn2.style.pointerEvents = 'auto';
            btn2.style.color = ''; // デフォルトの文字色に戻す
            btn2.style.backgroundColor = ''; // デフォルトの背景色に戻す
            btn2.style.border = '';
            btn2.style.borderRadius ='';
        }


    }


    //前へボタンのスタイル変更
    if(currentPage  == 1){
        prevButton.style.pointerEvents = 'none';
        prevButton.style.color = '#b4b4b4';
        prevButton.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        prevButton.style.border = '1px solid rgba(120, 120, 120, 0.1)';
        prevButton.style.borderRadius ='5%';
    }else{
        prevButton.style.pointerEvents = '';
        prevButton.style.color = '';
        prevButton.style.backgroundColor = '';
        prevButton.style.border = '';
        prevButton.style.borderRadius ='';
    }

    if(currentPage  == 1){
        prevButton2.style.pointerEvents = 'none';
        prevButton2.style.color = '#b4b4b4';
        prevButton2.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        prevButton2.style.border = '1px solid rgba(120, 120, 120, 0.1)';
        prevButton2.style.borderRadius ='5%';
    }else{
        prevButton2.style.pointerEvents = '';
        prevButton2.style.color = '';
        prevButton2.style.backgroundColor = '';
        prevButton2.style.border = '';
        prevButton2.style.borderRadius ='';
    }

    //次へボタンのスタイル変更
    if((currentPage ) * PER_PAGE >= globalTotalItem){
        nextButton.style.pointerEvents = 'none';
        nextButton.style.color = '#b4b4b4';
        nextButton.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        nextButton.style.border = '1px solid rgba(120, 120, 120, 0.1)';
        nextButton.style.borderRadius ='5%';
    }else{
        nextButton.style.pointerEvents = '';
        nextButton.style.color = '';
        nextButton.style.backgroundColor = '';
        nextButton.style.border = '';
        nextButton.style.borderRadius ='';
    }

    //次へボタンのスタイル変更
    if((currentPage ) * PER_PAGE >= globalTotalItem){
        nextButton2.style.pointerEvents = 'none';
        nextButton2.style.color = '#b4b4b4';
        nextButton2.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        nextButton2.style.border = '1px solid rgba(120, 120, 120, 0.1)';
        nextButton2.style.borderRadius ='5%';
    }else{
        nextButton2.style.pointerEvents = '';
        nextButton2.style.color = '';
        nextButton2.style.backgroundColor = '';
        nextButton2.style.border = '';
        nextButton2.style.borderRadius ='';
    }



}


if(currentPage  == 1){
    prevButton.style.pointerEvents = 'none';
    prevButton.style.color = '#b4b4b4';
    prevButton.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
    prevButton.style.border = '1px solid rgba(120, 120, 120, 0.1)';
    prevButton.style.borderRadius ='5%';
}

if(currentPage  == 1){
    prevButton2.style.pointerEvents = 'none';
    prevButton2.style.color = '#b4b4b4';
    prevButton2.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
    prevButton2.style.border = '1px solid rgba(120, 120, 120, 0.1)';
    prevButton2.style.borderRadius ='5%';
}




function generatePagination(currentPage, totalPages) {
    function createPageNumber(number) {
      return `<li><button id="btn${number}" style="width:17px; margin-right:5px; font-size:12px;"  onclick="updatePaginationAndStyles(event, value); " value="${number}">${number}</button></li>`;
    }
 
    const pagination = [];
 
    if (totalPages <= 7) {
      for (let i = 1; i <= totalPages; i++) {
        pagination.push(createPageNumber(i));
      }
    } else {
      if (currentPage < 5) {
        pagination.push(createPageNumber(1), createPageNumber(2), createPageNumber(3), createPageNumber(4), createPageNumber(5), '<li>...</li>', createPageNumber(totalPages));
      } else if (currentPage > totalPages - 4) {
        pagination.push(createPageNumber(1), '<li style="width:17px; margin-right:5px;">...</li>', createPageNumber(totalPages - 4), createPageNumber(totalPages - 3), createPageNumber(totalPages - 2), createPageNumber(totalPages - 1), createPageNumber(totalPages));
      } else {
        pagination.push(createPageNumber(1), '<li style="width:17px; margin-right:5px;">...</li>', createPageNumber(currentPage - 1), createPageNumber(currentPage), createPageNumber(currentPage + 1), '<li>...</li>', createPageNumber(totalPages));
      }
    }
 
    return pagination.join('');
    
 
    
  }
 
 
  function generatePagination2(currentPage, totalPages) {
 
     function createPageNumber2(number) {
      return `<li><button id="2btn${number}" style="width:17px; margin-right:5px; font-size:12px;"  onclick="updatePaginationAndStyles(event, value);" value="${number}">${number}</button></li>`;
    }
 
     const pagination2 = [];
  
     if (totalPages <= 7) {
       for (let i = 1; i <= totalPages; i++) {
         pagination2.push(createPageNumber2(i));
       }
     } else {
       if (currentPage < 5) {
         pagination2.push(createPageNumber2(1), createPageNumber2(2), createPageNumber2(3), createPageNumber2(4), createPageNumber2(5), '<li>...</li>', createPageNumber2(totalPages));
       } else if (currentPage > totalPages - 4) {
         pagination2.push(createPageNumber2(1), '<li style="width:17px; margin-right:5px;">...</li>', createPageNumber2(totalPages - 4), createPageNumber2(totalPages - 3), createPageNumber2(totalPages - 2), createPageNumber2(totalPages - 1), createPageNumber2(totalPages));
       } else {
         pagination2.push(createPageNumber2(1), '<li style="width:17px; margin-right:5px;">...</li>', createPageNumber2(currentPage - 1), createPageNumber2(currentPage), createPageNumber2(currentPage + 1), '<li>...</li>', createPageNumber2(totalPages));
       }
     }
  
     return pagination2.join('');
     
  
     
   }
 

   function updatePaginationAndStyles(event, value) {
    paginationSearch(value)
    render();
    updatePaginationNum(event);
    updateStyles(value);
    window.scrollTo(0, 0);
   // SORT処理();
}

 



    // prevButton のイベントリスナーとして登録
prevButton.addEventListener("click", handleButtonActionPrev);

// nextButton のイベントリスナーとして登録
nextButton.addEventListener("click", handleButtonActionNext);

// prevButton2 のイベントリスナーとして登録
prevButton2.addEventListener("click", handleButtonActionPrev);

// nextButton2 のイベントリスナーとして登録
nextButton2.addEventListener("click", handleButtonActionNext);



function pagination222(){




    globalTotalItem = 総検索数;
    // 1ページに表示したい件数
    PER_PAGE = 表示件数;
  
    if(globalTotalItem % PER_PAGE == 0){
        totalPages = (globalTotalItem / PER_PAGE) ; // 総ページ数
    }else{
        totalPages = Math.floor((globalTotalItem / PER_PAGE)) + 1; // 総ページ数
    }
  
    
  
     //pagination1
     if(globalTotalItem <= PER_PAGE){
      document.getElementById("paging-button").style.visibility="hidden";
      }else{
          document.getElementById("paging-button").style.visibility="visible";
      }
  
      //pagination2
      if(globalTotalItem <= PER_PAGE){
          document.getElementById("paging-button2").style.visibility="hidden";
      }else{
          document.getElementById("paging-button2").style.visibility="visible";
      }
  
  
  
  
  
  
  
  
  
  
     currentPage = 1; // 初期ページ
     initialPage = 1;
    var totalPageCount = totalPages; // 合計ページ数
    const initialPagination = generatePagination(currentPage, totalPageCount);
    document.getElementById('pagination').innerHTML = initialPagination;
    const initialPagination2 = generatePagination2(currentPage, totalPageCount);
    document.getElementById('pagination2').innerHTML = initialPagination2;
  
    
  
   
  
    
    render();
    //updateStyles();

    if(開始位置 == 0){

        //前へボタンのスタイル変更
        prevButton.style.pointerEvents = 'none';
        prevButton.style.color = '#b4b4b4';
        prevButton.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        prevButton.style.border = '1px solid rgba(120, 120, 120, 0.1)';
        prevButton.style.borderRadius ='5%';

        prevButton2.style.pointerEvents = 'none';
        prevButton2.style.color = '#b4b4b4';
        prevButton2.style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        prevButton2.style.border = '1px solid rgba(120, 120, 120, 0.1)';
        prevButton2.style.borderRadius ='5%';


        document.getElementById('btn1').style.pointerEvents = 'none';
        document.getElementById('btn1').style.color = '#ff8080';
        document.getElementById('btn1').style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        document.getElementById('btn1').style.border = '1px solid rgba(120, 120, 120, 0.1)';
        document.getElementById('btn1').style.borderRadius ='5%';

        document.getElementById('2btn1').style.pointerEvents = 'none';
        document.getElementById('2btn1').style.color = '#ff8080';
        document.getElementById('2btn1').style.backgroundColor = 'rgba(100, 100, 100, 0.1)';
        document.getElementById('2btn1').style.border = '1px solid rgba(120, 120, 120, 0.1)';
        document.getElementById('2btn1').style.borderRadius ='5%';
    
    
    }

        //次へボタン初期
        nextButton.style.pointerEvents = '';
        nextButton.style.color = '';
        nextButton.style.backgroundColor = '';
        nextButton.style.border = '';
        nextButton.style.borderRadius ='';

        //次へボタン初期
        nextButton2.style.pointerEvents = '';
        nextButton2.style.color = '';
        nextButton2.style.backgroundColor = '';
        nextButton2.style.border = '';
        nextButton2.style.borderRadius ='';
  
  
  
  
  }
  



  function paginationSearch(i){

 


    開始位置 = ((i-1) * PER_PAGE) ;



    // 新しい検索条件を取得
    var newSearch = {
        departmentname: $("#departmentname").val(),
        officename: $("#officename").val(),
        unitname: $("#unitname").val(),
        teamname: $("#teamname").val(),
        fullname: $("#MEFULLNAME").val(),
        position: $("#position").val(),
        role: $("#role").val()
    };

    // 以前の検索条件と新しい検索条件を比較
    if (
        previousSearch.departmentname !== newSearch.departmentname ||
        previousSearch.officename !== newSearch.officename ||
        previousSearch.unitname !== newSearch.unitname ||
        previousSearch.teamname !== newSearch.teamname ||
        previousSearch.fullname !== newSearch.fullname ||
        previousSearch.position !== newSearch.position ||
        previousSearch.role !== newSearch.role
        

        ) {
        // 新しい検索条件と異なる場合の処理
        //    console.log ("aaa");
        PAGINATION処理(previousSearch.departmentname,
                        previousSearch.officename, 
                        previousSearch.unitname,
                        previousSearch.teamname,
                        previousSearch.fullname,
                        previousSearch.position,
                        previousSearch.role
                        );

        // 以前の検索条件を更新
    /*    previousSearch = {
            area: newSearch.area,
            officename: newSearch.officename,
            unitname: newSearch.unitname,
            teamname: newSearch.teamname,
            fullname: newSearch.fullname
        };
        */
            
        }else{   
       //    console.log ("bbb");

          SORT処理();

}
  }



function PAGINATION処理(departmentname,officename,unitname,teamname,fullname,position,role){ 

    var 分岐 = '空白';
    
    var departmentnameDB = departmentname;
    var officenameDB = officename;
    var unitnameDB = unitname;
    var teamnameDB = teamname;
    var fullnameDB = fullname;
    var positionDB = position;
    var roleDB = role;

    表示件数 = document.getElementById('display-count').value;

    console.log(departmentnameDB);
    console.log(officenameDB);
    console.log(teamnameDB);
    console.log(unitnameDB);
    console.log(fullnameDB);

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
    console.log(分岐);
    console.log(検索語);
                        
    $("#検索結果").show(); // 結果リストBOXを表示

    var オーダーSQL = dataToSend;
    
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

              
    //取得した検索条件をDB_LIST.phpに送信
    $.post("memberSearch_DB_LIST.php", {表示総数:表示件数,検索語句:検索語,開始:開始位置,分岐値:分岐,役職:役職名,役割:役割名,オーダー:オーダーSQL}, function(data){
                    if(data.length > 0){
                        $("#検索結果").html(data);}
  
                    })
}
