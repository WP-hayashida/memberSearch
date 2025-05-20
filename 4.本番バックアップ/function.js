

//トップへ戻るボタン
jQuery(document).ready(function() {
    const offset = 100;
    const duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.pagetop').fadeIn(duration);
        } else {
            jQuery('.pagetop').fadeOut(duration);
        }
    });

    jQuery('.pagetop').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, duration);
        return false;
    })
});




    // 初期状態：表示する（必要なら非表示にもできる）
    // narrowdownDiv.style.display = 'none';
    // arrow.textContent = '▲';
    //なぞにロードが入る


//動作待機
$(document).ready(function() {
    ////////////////////////////////////////////////
    //プルダウンの挙動
    ////////////////////////////////////////////////
    $('.pulldown').select2({
        language: "ja",
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: "選択or直接入力",
        closeOnSelect: false,
        dropdownPosition: 'above'
    });


    // Select2の選択肢が解除されたときのイベント
    $('.pulldown').on('select2:unselect', function(e) {
        //var unselectedValue = e.params.data.id;  // 解除された値を取得
        //console.log('解除されました:', unselectedValue);

        var searchField = $(this).siblings('.select2').find('.select2-selection__choice');
        //console.log(this);
        //console.log(e);
        //console.log(parentId);
        //console.log(searchField.length);

        if (searchField.length > 0) {
            //console.log('select2-selection__choiceが存在します。');
        } else {
            //console.log('select2-selection__choiceは存在しません。');
            //console.log('nasi');
            $('.pulldown').select2('close');
        }
    });

    /*
    ["departmentname", "officename", "unitname", "teamname", "MEFULLNAME"].forEach(id => {
        document.getElementById(id).addEventListener("change", function () {
            console.log(this, id);
            applyFilters(this, id);
        });
    });
    */

    $('.pulldown').on('change', function() {
        let id = $(this).attr('id');
        console.log(this, id);
        //applyFilters(this, id);
        applyFiltersRecursively(this, id);
    });



});


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



//■条件クリア関数
function Clear(){
    $('.pulldown').empty().trigger('change');
    resettoggle();
    createPull();
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


const toggleConfigs = [
    { button: 'departmentnametgl', plus: 'departmentnameplus', minus: 'departmentnameminus', form: '#departmentnameform' },
    { button: 'officenametgl', plus: 'officenameplus', minus: 'officenameminus', form: '#officenameform' },
    { button: 'unitnametgl', plus: 'unitnameplus', minus: 'unitnameminus', form: '#unitnameform' },
    { button: 'teamnametgl', plus: 'teamnameplus', minus: 'teamnameminus', form: '#teamnameform' },
    { button: 'MEFULLNAMEtgl', plus: 'MEFULLNAMEplus', minus: 'MEFULLNAMEminus', form: '#MEFULLNAMEform' },
    { button: 'positiontgl', plus: 'positionplus', minus: 'positionminus', form: '#positionform' },
    { button: 'roletgl', plus: 'roleplus', minus: 'roleminus', form: '#roleform' },
    { button: 'MEOFFICE_LOANtgl', plus: 'MEOFFICE_LOANplus', minus: 'MEOFFICE_LOANminus', form: '#MEOFFICE_LOANform' }
];

toggleConfigs.forEach(({ button, plus, minus, form }) => {
    const toggleButton = document.getElementById(button);
    toggleButton.addEventListener('click', () => {
        document.getElementById(plus).classList.toggle('hidden');
        document.getElementById(minus).classList.toggle('hidden');
        const $elm = $(`${form} .select2-container`);
        $elm.toggleClass('normal');
        $elm.toggleClass('no-whitespace');
    });
});

function closetoggle() {
    $(".toggle1").removeClass('hidden');
    $(".toggle2").removeClass('hidden').addClass('hidden');
    $(".select2-container").removeClass('normal').addClass('no-whitespace');
}




//■検索
function getSelectedPulls(){

    let MEFULLNAMESelectedValues = new Set(
        Array.from(MEFULLNAMEElm.options)
            .filter(option => option.selected)
            .map(option => option.value)
            .filter(value => value !== '')
    );
    if(MEFULLNAMESelectedValues.size===0){
        MEFULLNAMESelectedValues = new Set(
            Array.from(MEFULLNAMEElm.options)
                .map(option => option.value)
                .filter(value => value !== '')
        );
    }
    let positionSelectedValues = new Set(
        Array.from(positionElm.options)
            .filter(option => option.selected)
            .map(option => option.value)
            .filter(value => value !== '')
    );
    let roleSelectedValues = new Set(
        Array.from(roleElm.options)
            .filter(option => option.selected)
            .map(option => option.value)
            .filter(value => value !== '')
    );

    let MEOFFICE_LOANSelectedValues = new Set(
        Array.from(MEOFFICE_LOANElm.options)
            .filter(option => option.selected)
            .map(option => option.value)
            .filter(value => value !== '')
    );
    return {
        'MEFULLNAME':MEFULLNAMESelectedValues,
        'position':positionSelectedValues,
        'role':roleSelectedValues,
        'MEOFFICE_LOAN':MEOFFICE_LOANSelectedValues
    }

}
/*

    // ソート用ボタン（上矢印）
    const sortButtonUp = document.createElement("button");
    sortButtonUp.classList.add("sortbutton");
    sortButtonUp.name = "sort1";
    sortButtonUp.type = "submit";
    sortButtonUp.style.cursor = "pointer";
    sortButtonUp.value = "sort1";

    const upIcon = document.createElement("i");
    upIcon.classList.add("fa-solid", "fa-caret-up", "fa-xs");
    sortButtonUp.appendChild(upIcon);

    // ソート用ボタン（下矢印）
    const sortButtonDown = document.createElement("button");
    sortButtonDown.classList.add("sortbutton");
    sortButtonDown.name = "sort2";
    sortButtonDown.type = "submit";
    sortButtonDown.style.cursor = "pointer";
    sortButtonDown.value = "sort2";

    const downIcon = document.createElement("i");
    downIcon.classList.add("fa-solid", "fa-caret-down", "fa-xs");
    sortButtonDown.appendChild(downIcon);

    // ボタンをspanに追加
    const buttonSpan = document.createElement("span");
    buttonSpan.style.display = "inline-block";
    buttonSpan.style.verticalAlign = "middle";
    buttonSpan.style.fontSize = "0";
    buttonSpan.appendChild(sortButtonUp);
    buttonSpan.appendChild(sortButtonDown);

    headerCell2.appendChild(nameSpan);
    headerCell2.appendChild(buttonSpan);
    headerRow1.appendChild(headerCell2);

*/
const headerColmunArr =[
    {'id':'userid','name':'USERID','sort':false,'sortCol':'','sortAorD':0,'header':1,'rowspan':1,'width':'12%','csvNo':0,'data':'MEUSERID'},
    //{'name':'氏名','toggle':true,'header':2,'rowspan':1,'width':'9%','csvNo':1,'data':'MEFULLNAME'},

    {'id':'department','name':'部','sort':true,'sortCol':'sort_department','sortAorD':0,'header':1,'rowspan':1,'width':'12%','csvNo':2,'data':'name_department'},
    {'id':'unit','name':'ユニット','sort':true,'sortCol':'sort_MEUNIT','sortAorD':0,'header':1,'rowspan':1,'width':'15%','csvNo':4,'data':'name_MEUNIT'},
    {'id':'email','name':'メールアドレス','sort':false,'sortCol':'','sortAorD':0,'header':1,'rowspan':1,'width':'19%','csvNo':6,'data':'Email'},
    {'id':'dateOfEnter','name':'入社日','sort':true,'sortCol':'MEDATEOFENTER','sortAorD':0,'header':1,'rowspan':1,'width':'10%','csvNo':8,'data':'formattedDATEOFENTER'},
    {'id':'name_g','name':'職位','sort':true,'sortCol':'sort_name_g','sortAorD':1,'header':1,'rowspan':1,'width':'12%','csvNo':10,'data':'name_g'},
    {'id':'grade','name':'グレード','sort':true,'sortCol':'sort_name_g','sortAorD':1,'header':1,'rowspan':1,'width':'10%','csvNo':12,'data':'MEGRADE'},
    {'id':'officeTax','name':'拠点(税務)','sort':true,'sortCol':'MEOFFICE_TAX','sortAorD':0,'header':1,'rowspan':1,'width':'10%','csvNo':14,'data':'name_MEOFFICE_TAX'},

    {'id':'fullname','name':'氏名','sort':true,'sortCol':'MEKANA','sortAorD':0,'header':2,'rowspan':1,'width':'12%','csvNo':1,'data':'MEFULLNAME'},
    {'id':'office','name':'拠点(所属)','sort':true,'sortCol':'MEOFFICE_BELONG','sortAorD':0,'header':2,'rowspan':1,'width':'12%','csvNo':3,'data':'name_MEOFFICE_BELONG'},
    {'id':'team','name':'チーム','sort':true,'sortCol':'sort_METEAM','sortAorD':0,'header':2,'rowspan':1,'width':'15%','csvNo':5,'data':'name_METEAM'},
    {'id':'tell','name':'社用TEL','sort':false,'sortCol':'','sortAorD':0,'header':2,'rowspan':1,'width':'19%','csvNo':7,'data':'METEL'},
    {'id':'jobTenure','name':'社歴','sort':true,'sortCol':'MEDATEOFENTER','sortAorD':0,'header':2,'rowspan':1,'width':'10%','csvNo':9,'data':'job_tenure'},
    {'id':'role','name':'役職','sort':true,'sortCol':'sort_role','sortAorD':0,'header':2,'rowspan':1,'width':'12%','csvNo':11,'data':'name_role'},
    {'id':'gradeSub','name':'SPグレード','sort':true,'sortCol':'gradeSub','sortAorD':0,'header':2,'rowspan':1,'width':'10%','csvNo':13,'data':'MEGRADE_sub'},
    {'id':'officeAccg','name':'拠点(会計)','sort':true,'sortCol':'','sortAorD':0,'header':2,'rowspan':1,'width':'10%','csvNo':15,'data':'officename'}
];



//ソートボタン作成
function createSortButton(row,cellElm){

    if(row.sort===false) return;

    const id = row.sortCol;
    const AorD = row.sortAorD;
    const spanElm = document.createElement("span");
    spanElm.className = "sort-span";

    const iconUP="fa-solid fa-caret-up fa-xs";
    const iconDown="fa-solid fa-caret-down fa-xs";

    const ascButtonElm = document.createElement("button");
    ascButtonElm.className = "sortbutton";
    ascButtonElm.type = "button";
    if(AorD===0){
        ascButtonElm.id = id+"-asc";
    }else{
        ascButtonElm.id = id+"-dsc";
    }
    ascButtonElm.setAttribute("onclick", "search(this.id)");

    const upElm = document.createElement("i");
    upElm.className = iconUP;

    const dscButtonElm = document.createElement("button");
    dscButtonElm.className = "sortbutton";
    dscButtonElm.type = "button";
    if(AorD===0){
        dscButtonElm.id = id+"-dsc";
    }else{
        dscButtonElm.id = id+"-asc";
    }
    dscButtonElm.setAttribute("onclick", "search(this.id)");

    const downElm = document.createElement("i");
    downElm.className = iconDown;

    ascButtonElm.appendChild(upElm);
    dscButtonElm.appendChild(downElm);
    spanElm.appendChild(ascButtonElm);
    spanElm.appendChild(dscButtonElm);
    cellElm.appendChild(spanElm);

}

//テーブルのヘッダーセル作成
function createHeaderCell(headerRow1,headerRow2){
    headerColmunArr.forEach(row=>{
        const header = row.header;

        const headerCell = document.createElement("th");
        headerCell.style.width = row.width;
        headerCell.rowSpan = row.rowspan;
        const span = document.createElement("span");
        span.style.verticalAlign = "middle";
        span.textContent = row.name;

        headerCell.appendChild(span);

        createSortButton(row,headerCell);

        if(header===1){
            headerRow1.appendChild(headerCell);
        }else{
            headerRow2.appendChild(headerCell);
        }

    })

}

//テーブルの行作成
function createResultRow(tableElm,result){
    result.forEach(member=>{
        // テーブルのヘッダー行作成１
        const resultRow1 = document.createElement("tr");
        resultRow1.style.height = "28px";
        resultRow1.className = "resultRow1";
        tableElm.appendChild(resultRow1);

        // テーブルのヘッダー行作成２
        const resultRow2 = document.createElement("tr");
        resultRow2.style.height = "28px";
        resultRow2.className = "resultRow2";
        tableElm.appendChild(resultRow2);

        createResultCell(resultRow1,resultRow2,member);
    })

}

//テーブルの各データセル作成
function createResultCell(resultRow1,resultRow2,memberIdlArr){
    headerColmunArr.forEach(row=>{
        const header = row.header;
        const columnName = row.data;

        const resultCell = document.createElement("th");
        resultCell.style.width = row.width;
        resultCell.rowSpan = row.rowspan;
        const span = document.createElement("span");
        span.style.verticalAlign = "middle";
        span.textContent = memberIdlArr[columnName];

        resultCell.appendChild(span);


        if(header===1){
            resultRow1.appendChild(resultCell);
        }else{
            resultRow2.appendChild(resultCell);
        }

    })

}

function exportCsvAction(){
    exportCsv('', resultCSVArr);
}
function updateCSVButtonState(resultCSVArr) {
    const csvButton = document.getElementById('csv-btn');
    if (resultCSVArr.length > 0) {
        csvButton.disabled = false;
    } else {
        csvButton.disabled = true;
    }
}

function createResultCSV(resultArr, Ym) {
    //console.log(Ym)
    const today = new Date();
    const outputDate = today.toISOString().split('T')[0]; // 出力日 YYYY-MM-DD
    //Ym = Ym.getFullYear() + "-" + String(Ym.getMonth() + 1).padStart(2, '0');

    const resultCSVArr = resultArr.map(item => {
        const dateStr = item.MEDATEOFENTER;
        const formattedDate = `${dateStr.slice(0,4)}-${dateStr.slice(4,6)}-${dateStr.slice(6,8)}`;
        const enterDate = new Date(formattedDate); 
        console.log(enterDate);
        const diffTime = today - enterDate;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)); // 社歴（日数）

        // 年月の差（日切り捨て）
        let year = today.getFullYear() - enterDate.getFullYear();
        let month = today.getMonth() - enterDate.getMonth();
        if (month < 0) {
            year -= 1;
            month += 12;
        }

        return {
            MEUSERID: item.MEUSERID,
            氏名: item.MEFULLNAME,
            部: item.name_department,
            所属拠点: item.name_MEOFFICE_BELONG,
            勤務拠点: item.name_MEOFFICE_LOAN,
            ユニット: item.name_MEUNIT,
            チーム: item.name_METEAM,
            社用TELL : item.METEL,
            メールアドレス : item.Email,
            入社日: item.formattedDATEOFENTER,
            職位: item.name_g,
            役職: item.name_role,
            グレード: item.MEGRADE,
            SPグレード: item.MEGRADE_sub,
            社歴_年月: `${year > 0 ? year + '年' : ''}${month}ヶ月`,
            社歴_日数: `${diffDays}日`,
            税務拠点コード: item.MEOFFICE_TAX,
            税務拠点名: item.name_MEOFFICE_TAX,
            出力日: outputDate,
            対象年月: Ym
        };
    });
    updateCSVButtonState(resultCSVArr);
    return resultCSVArr;
}

//検索結果配列作成
function createResult(data,sortId){
    const resultMembweArr=data.MEFULLNAME;
    const resultPositionArr=data.position;
    const resultRoleArr=data.role;
    const resultMEOFFICE_LOANArr=data.MEOFFICE_LOAN;
    console.log(resultMEOFFICE_LOANArr);
    console.log(resultMembweArr)


    let resultArr;
    if(memberArr.size===0){
        return 'no data'
    }else{
        resultArr = memberArr.filter(member =>
            resultMembweArr.has(member.MEUSERID) &&
            (resultPositionArr.size === 0 || resultPositionArr.has(member.name_g)) &&
            (resultRoleArr.size === 0 || resultRoleArr.has(member.role)) &&
            (resultMEOFFICE_LOANArr.size === 0 || resultMEOFFICE_LOANArr.has(member.name_MEOFFICE_LOAN))
        );
    }
    console.log(resultArr);
    if(sortId != null){
        const [id,order] = sortId.split('-');
        console.log(id,order)
        resultArr.sort((a, b) => {
            const valA = a[id];
            const valB = b[id];

            if (valA == null && valB != null) return order === 'asc' ? -1 : 1;
            if (valA != null && valB == null) return order === 'asc' ? 1 : -1;
            if (valA == null && valB == null) return 0;

            if (typeof valA === 'number' && typeof valB === 'number') {
                return order === 'asc' ? valA - valB : valB - valA;
            }

            // 文字列比較（大文字小文字無視）
            const strA = String(valA).toLowerCase();
            const strB = String(valB).toLowerCase();

            if (strA < strB) return order === 'asc' ? -1 : 1;
            if (strA > strB) return order === 'asc' ? 1 : -1;
            return 0;
        });
    }
    resultCSVArr = createResultCSV(resultArr,Ym);

    console.log(resultCSVArr);
    return resultArr;
    //この配列をテーブルで出力！！！
    //あと空欄の人がいるしゃちょうとかは検索させる多分大丈夫

}

// 検索トリガー
function search(sortId) {
    const dataArr = getSelectedPulls();
    const resultArr = createResult(dataArr, sortId); // ソート済み配列
    const itemsPerPage = document.getElementById('display-count').value;

    setupPagination(resultArr, itemsPerPage); // ← 表示件数50件ずつ
}


function setupPagination(resultArr, itemsPerPage) {
    const totalPages = Math.ceil(resultArr.length / itemsPerPage);

    // ページネーションとメッセージのエリアをクリア
    $('#pagination, #paginationBottom').empty();
    $('#resultInfoTop').empty();
    $('#result').empty(); // テーブルもクリア

    if (totalPages === 0) {
        // 結果がない場合の表示
        $('#resultInfoTop').text('検索結果：0件　対象者はいません');
        return;
    }

    // ページネーション初期化（複数箇所対応）
    $('#pagination, #paginationBottom').twbsPagination('destroy');
    $('#pagination, #paginationBottom').twbsPagination({
        totalPages: totalPages,
        visiblePages: 5,
        first: '«',
        prev: '‹',
        next: '›',
        last: '»',
        onPageClick: function (event, page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, resultArr.length);
            const pageItems = resultArr.slice(startIndex, endIndex);

            generateTable(pageItems);

            const displayStart = startIndex + 1;
            const displayEnd = endIndex;
            $('#resultInfoTop, #resultInfoBottom').text(`検索結果：${resultArr.length}件　${displayStart}～${displayEnd}件表示`);
        }
    });

    // 初期表示（1ページ目）
    const initialItems = resultArr.slice(0, itemsPerPage);
    generateTable(initialItems);

    const displayStart = 1;
    const displayEnd = Math.min(itemsPerPage, resultArr.length);
    $('#resultInfoTop, #resultInfoBottom').text(`検索結果：${resultArr.length}件　${displayStart}～${displayEnd}件表示`);
}

// テーブル出力用関数
function generateTable(data) {
    const resultElm = document.getElementById('result');

    // テーブルクリア
    while (resultElm.firstChild) {
        resultElm.removeChild(resultElm.firstChild);
    }

    const tableElm = document.createElement("table");
    tableElm.classList.add("LIST");
    tableElm.style.marginTop = "15px";
    tableElm.style.border = "1px solid #999";
    tableElm.style.borderCollapse = "collapse";

    // テーブルのヘッダー行作成１
    const headerRow1 = document.createElement("tr");
    headerRow1.style.height = "28px";
    headerRow1.style.backgroundColor = "lightslategray";
    headerRow1.className = 'headerRow1';
    tableElm.appendChild(headerRow1);

    // テーブルのヘッダー行作成２
    const headerRow2 = document.createElement("tr");
    headerRow2.style.height = "28px";
    headerRow2.style.backgroundColor = "lightslategray";
    headerRow2.className = 'headerRow2';
    tableElm.appendChild(headerRow2);

    // ヘッダー生成
    createHeaderCell(headerRow1, headerRow2);

    // データ行生成（そのページ分だけ）
    createResultRow(tableElm, data);

    // テーブルをDOMに追加
    resultElm.appendChild(tableElm);
}


//////////////////////////////
// プルダウン
//////////////////////////////

function optionClear(targetElm) {
    while (targetElm.firstChild) {
        targetElm.removeChild(targetElm.firstChild);
    }
}

function firstOption() {
    const option = document.createElement('option');
    option.textContent = "";
    option.value = "";
    return option;
}


//プルダウン生成関数
function createPulldown(target) {
    //console.log(target)
    const elm = getData(target).elm;
    const arr = getData(target).arr;
    const display = getData(target).display;
    const value = getData(target).value;

    console.log(arr)
    arr.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row[display];
        option.value = row[value];
        elm.appendChild(option);
    });
}

//初回作成
function createPull(){
    createDropdownArr.forEach(key => {
        createPulldown(key.name);
    })
}

//createPull();


function updatePull (currentKey){
    const index = hierarchyArr.findIndex(arr => arr.name === currentKey);
    if(index===0){
        clearPullGenerate();
    }else{
        console.log(currentKey)
        for (let i = index ; i < hierarchyArr.length; i++) {
            const parentID = hierarchyArr[index-1];
            const parentElm = document.getElementById(parentID);
            applyFiltersRecursively(parentElm, parentID);
        }
    }
}
function applyFiltersRecursively(triggerElm, filterKey) {
    if (!filterMappings[filterKey]) return;

    filterMappings[filterKey].forEach(targetKey => {
        let targetElm = document.getElementById(targetKey);
        let dataArr = getData(targetKey).arr;
        let dataColumn = getData(targetKey).column;
        let dataDisplay = getData(targetKey).display;
        let dataValue = getData(targetKey).value;
        let selectedValues = new Set(
            Array.from(triggerElm.options)
                .filter(option => option.selected)
                .map(option => option.value)
                .filter(value => value !== '')
        );
        console.log(selectedValues,dataArr,dataColumn,dataDisplay,dataValue,targetKey)
        if (selectedValues.size === 0) {
                selectedValues = new Set(
                    Array.from(triggerElm.options)
                        .map(option => option.value)
                        .filter(value => value !== '')
                );
        }

        if(targetKey==='position'){
            console.log(selectedValues)
            let tempArray = Array.from(selectedValues);

            tempArray = tempArray.map(key => {
                const member = memberArr.find(m => m.MEUSERID === key);
                return member ? member.name_g : key; // 見つかったら MEUSERID に置換
            });

            // 配列を Set に戻す
            selectedValues = new Set(tempArray);
            console.log(selectedValues)
        }
        if(targetKey==='role'){
            console.log(selectedValues)
            let tempArray = Array.from(selectedValues);

            tempArray = tempArray.map(key => {
                const member = memberArr.find(m => m.MEUSERID === key);
                return member ? member.role : key; // 見つかったら MEUSERID に置換
            });

            // 配列を Set に戻す
            selectedValues = new Set(tempArray);
            console.log(selectedValues)
        }
        if(targetKey==='MEOFFICE_LOAN'){
            console.log(selectedValues)
            let tempArray = Array.from(selectedValues);

            tempArray = tempArray.map(key => {
                const member = memberArr.find(m => m.MEUSERID === key);
                return member ? member.name_MEOFFICE_LOAN : key; // 見つかったら MEUSERID に置換
            });

            // 配列を Set に戻す
            selectedValues = new Set(tempArray);
            console.log(selectedValues)
        }


        //拠点かつ部の計算にする

        if(targetKey==='unitname'){//ユニットは部と拠点のアンド検索
            pullFilterUnit(selectedValues, targetElm, dataArr, dataColumn,dataDisplay,dataValue);
        }else{
            pullFilter(selectedValues, targetElm, dataArr, dataColumn,dataDisplay,dataValue);
        }

        applyFiltersRecursively(targetElm, targetKey);
    });
}

function pullFilter(selectedValues, targetElm, dataArr, colKey, displayKey, valueKey) {
    console.log(selectedValues, targetElm, dataArr,colKey, displayKey);
    optionClear(targetElm);
    targetElm.appendChild(firstOption());

    const processedValues = new Set();
    
    dataArr.forEach(row => {
        //console.log(selectedValues)
        //console.log(row,row[colKey],row[displayKey])
        if (selectedValues.has(row[colKey]) && !processedValues.has(row[displayKey])) {
            const option = document.createElement('option');
            option.textContent = row[displayKey];
            option.value = row[valueKey];
            targetElm.appendChild(option);
            processedValues.add(row[displayKey]);
        }
    });
}
function pullFilterUnit(selectedValues, targetElm, dataArr, colKey, displayKey, valueKey) {
    optionClear(targetElm);
    targetElm.appendChild(firstOption());

    const departmentElm = document.getElementById('departmentname');
    const processedValues = new Set();
    let departmentSelectedValues = new Set(
        Array.from(departmentElm.options)
            .filter(option => option.selected)
            .map(option => option.value)
            .filter(value => value !== '')
    );
    if(departmentSelectedValues.size===0){
            dataArr.forEach(row => {
                if (selectedValues.has(row[colKey]) && !processedValues.has(row[displayKey])) {
                    const option = document.createElement('option');
                    option.textContent = row[displayKey];
                    option.value = row[valueKey];
                    targetElm.appendChild(option);
                    processedValues.add(row[displayKey]);
                }
            });
    }else{
        dataArr.forEach(row => {
            if (selectedValues.has(row[colKey]) && !processedValues.has(row[displayKey]) && departmentSelectedValues.has(row.department)) {
                const option = document.createElement('option');
                option.textContent = row[displayKey];
                option.value = row[valueKey];
                targetElm.appendChild(option);
                processedValues.add(row[displayKey]);
            }
        });
    }

}

