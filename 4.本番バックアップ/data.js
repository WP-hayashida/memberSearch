


const hierarchyArr = [
    { id: 0, name: "departmentname" },
    { id: 1, name: "officename" },
    { id: 2, name: "unitname" },
    { id: 3, name: "teamname" },
    { id: 4, name: "MEFULLNAME" }
];


const filterMappings = {
    departmentname: ["officename"],
    officename: ["unitname"],
    unitname: ["teamname"],
    teamname: ["MEFULLNAME"],
    MEFULLNAME: ["position", "role","MEOFFICE_LOAN"]
};

//■組織プルダウン
const departmentnameElm = document.getElementById('departmentname');
const officenameElm = document.getElementById('officename');
const unitnameElm = document.getElementById('unitname');
const teamnameElm = document.getElementById('teamname');
const MEFULLNAMEElm = document.getElementById('MEFULLNAME');

//■その他条件プルダウン
const positionElm = document.getElementById('position');
const roleElm = document.getElementById("role");
const MEOFFICE_LOANElm = document.getElementById("MEOFFICE_LOAN");

function getData(targetKey) {
    switch (targetKey) {
        case "departmentname": return {'arr':departmentArr,'column':'','display':'name','value':'id','elm':departmentnameElm};
        case "officename": return {'arr':officeBelongArr,'column':'department','display':'officename','value':'officename','elm':officenameElm};
        case "officenameBelong": return {'arr':uniqOfficeBelongArr,'column':'department','display':'officename','value':'officename','elm':officenameElm};
        case "officenameUniq": return {'arr':uniqOfficeBelongArr,'column':'department','display':'name_MEOFFICE_BELONG','value':'name_MEOFFICE_BELONG','elm':officenameElm};
        case "unitname": return {'arr':unitArr,'column':'officename','display':'name','value':'id','elm':unitnameElm};
        case "unitnameToDepart": return {'arr':unitArr,'column':'department','display':'name','value':'id','elm':unitnameElm};
        case "teamname": return {'arr':teamArr,'column':'unit','display':'name','value':'id','elm':teamnameElm};
        case "MEFULLNAME": return {'arr':memberArr,'column':'METEAM','display':'MEFULLNAME','value':'MEUSERID','elm':MEFULLNAMEElm};
        case "position": return {'arr':gradeArr,'column':'name_g','display':'name_g','value':'name_g','elm':positionElm};
        case "role": return {'arr':roleArr,'column':'id','display':'name','value':'id','elm':roleElm};
        case "MEOFFICE_LOAN": return {'arr':officeUniqArr,'column':'officename','display':'officename','value':'officename','elm':MEOFFICE_LOANElm};
        default: return [];
    }
}
const createDropdownArr = [
    { id: 0, name: "departmentname", elm:departmentnameElm},
    { id: 1, name: "officenameBelong", elm:officenameElm},
    { id: 2, name: "unitname", elm:unitnameElm},
    { id: 3, name: "teamname", elm:teamnameElm},
    { id: 4, name: "MEFULLNAME", elm:MEFULLNAMEElm},
    { id: 5, name: "position", elm:positionElm},
    { id: 6, name: "role", elm:roleElm},
    { id: 7, name: "MEOFFICE_LOAN", elm:MEOFFICE_LOANElm}

];

let memberArr;
let headquarterArr
let departmentArr;
let unitArr;
let teamArr;
let officeUniqArr;


let officeBelongArr;
let uniqOfficeBelongArr;

let gradeArr;
let roleArr;
let Ym;

let resultCSVArr;
document.getElementById('specified-month').addEventListener('change', fetchDataByMonth);

// 初回ロード時にも実行
window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('specified-month').dispatchEvent(new Event('change'));
});
//日付基準でデータ群取得
function fetchDataByMonth() {
    console.log('get')
    const ym = this.value.replace('-', ''); // 例: 2025-04 → 202504
    Ym = this.value;

    fetch('../api/get_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `ym=${ym}`
    })
    .then(response => response.json())
    .then(data => {
        memberArr = data.memberArr;
        headquarterArr = data.headquarterArr;
        departmentArr = data.departmentArr;
        unitArr = data.unitArr;
        teamArr = data.teamArr;
        officeUniqArr = data.officeUniqArr;


        officeBelongArr = data.officeBelongArr;
        uniqOfficeBelongArr = data.uniqOfficeBelongArr;

        gradeArr = data.gradeArr;
        roleArr = data.roleArr;


        console.log(memberArr);
        console.log(headquarterArr);
        console.log(departmentArr);
        console.log(unitArr);
        console.log(teamArr);
        console.log(officeUniqArr);


        console.log(officeBelongArr);
        console.log(uniqOfficeBelongArr);

        console.log(gradeArr);
        console.log(roleArr);
        console.log(Ym);

        createPull(); // ← ここで必要な処理を行う関数
    })
    .catch(error => {
        console.error('エラー:', error);
    });
}




console.log(memberArr);
console.log(headquarterArr);
console.log(departmentArr);
console.log(unitArr);
console.log(teamArr);
console.log(officeUniqArr);


console.log(officeBelongArr);
console.log(uniqOfficeBelongArr);

console.log(gradeArr);
console.log(roleArr);