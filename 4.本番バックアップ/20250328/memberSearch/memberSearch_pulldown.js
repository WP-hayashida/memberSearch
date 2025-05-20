  //■「""」というプルダウンの選択肢を作成する関数
  function firstOption() {
    const first = document.createElement('option');
    first.textContent = '';
  
    return first;
  }
  
  //■引数に指定されたノードをすべて削除する関数
  function optionClear(node) {
    const options = document.querySelectorAll(node);
    options.forEach(option => {
      option.remove();
    });
  }
  
  //■組織プルダウン
  const departmentname1 = document.getElementById('departmentname');
  const officename1 = document.getElementById('officename');
  const unitname1 = document.getElementById('unitname');
  const teamname1 = document.getElementById('teamname');
  const MEFULLNAME1 = document.getElementById('MEFULLNAME');

  //■その他条件プルダウン
  const position1 = document.getElementById('position');
  const role1 = document.getElementById("role");

  //■プルダウンの並び替え用配列作成
  var aaa1 = [...aaa].sort((a, b) => a.unitsort - b.unitsort);//●ユニット昇順
  var aaa2 = [...aaa].sort((a, b) => a.officeid - b.officeid);//●拠点昇順
  var aaa3 = [...aaa].sort((a, b) => a.teamsort - b.teamsort);//●チーム昇順
  var aaa4 = [...aaa].sort((a, b) => b.gradeid - a.gradeid);//●グレード降順
  var aaa5 = [...aaa].sort((a, b) => b.rolesort - a.rolesort);//●役割降順
  //console.log(aaa4);


///データベースに抜けがなければこっち///////////////
/// エリアのプルダウンを生成
/*  if (Array.isArray(areaPull)) {
    areaPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        
        
        return;
      }
      area1.appendChild(option);
    });
  } else {
    console.error("areaPull is not an array");
  }
*/////////////////////////////////////////////////

  //■エリアのプルダウンを生成
  /*if (Array.isArray(areaPull)) {
    let otherAreaAdded = false; //●"その他カテゴリー"が選択されているかどうかのフラグ
    areaPull.forEach(row => {
      //●"その他カテゴリー"が選択されているかどうかで本社オフィスに対する絞り込みを変える
      if (row.trim() === "") {
        if (!otherAreaAdded) {
          const otherOption = document.createElement('option');
          otherOption.textContent = "その他カテゴリー";
          area1.appendChild(otherOption);
          otherAreaAdded = true;
        }
      } else {
        const option = document.createElement('option');
        option.textContent = row;
        area1.appendChild(option);
      }
    });
  
    if (!otherAreaAdded) {
      const otherOption = document.createElement('option');
      otherOption.textContent = "その他カテゴリー";
      area1.appendChild(otherOption);
    }
  } else {
    console.error("areaPull is not an array");
  }
 */
  if (Array.isArray(departmentPull)) {
    console.log(departmentPull)
    departmentPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      departmentname1.appendChild(option);
    });
  } else {
    console.error("departmentPull is not an array");
  }
  




  //■拠点のプルダウンを生成
  if (Array.isArray(officePull)) {
    officePull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      officename1.appendChild(option);
    });
  } else {
    console.error("officePull is not an array");
  }

  //■ユニットのプルダウンを生成
  if (Array.isArray(unitPull)) {
    unitPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      unitname1.appendChild(option);
    });
  } else {
    console.error("unitPull is not an array");
  }

  //■チームのプルダウンを生成
  if (Array.isArray(teamPull)) {
    teamPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      teamname1.appendChild(option);
    });
  } else {
    console.error("teamPull is not an array");
  }

  //■氏名のプルダウンを生成
  if (Array.isArray(fullnamePull)) {
    fullnamePull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      MEFULLNAME1.appendChild(option);
    });
  } else {
    console.error("fullnamePull is not an array");
  }

  //■役職のプルダウンを生成
  if (Array.isArray(positionPull)) {
    positionPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      position1.appendChild(option);
    });
  } else {
    console.error("positionPull is not an array");
  }

  //■役割のプルダウンを生成
  if (Array.isArray(rolePull)) {
    rolePull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      role1.appendChild(option);
    });
  } else {
    console.error("rolePull is not an array");
  }



//■エリアが選択されたら拠点のプルダウンを生成
$('#departmentname').on('change', function() {
  //●拠点のプルダウンを「""」のみにする
  optionClear('#officename > option');
  officename1.appendChild(firstOption());

  //●ユニットのプルダウンを「""」のみにする
  optionClear('#unitname > option');
  unitname1.appendChild(firstOption());
  //unitname1.disabled = true;

  //●チームのプルダウンを「""」のみにする
  optionClear('#teamname > option');
  teamname1.appendChild(firstOption());

  //●氏名のプルダウンを「""」のみにする
  optionClear('#MEFULLNAME > option');
  MEFULLNAME1.appendChild(firstOption());

  //●役職のプルダウンを「""」のみにする
  optionClear('#position > option');
  position1.appendChild(firstOption());

  //●役職のプルダウンを「""」のみにする
  optionClear('#role > option');
  role1.appendChild(firstOption());



  //●エリアで選択されたカテゴリーを含むもののみをプルダウンの選択肢に設定する
  pullFilter1(departmentname1, 'departmentname');
  pullFilter2(departmentname1, 'departmentname');
  pullFilter3(departmentname1, 'departmentname');
  pullFilter4(departmentname1, 'departmentname');
  pullFilter5(departmentname1, 'departmentname');
  pullFilter6(departmentname1, 'departmentname');

  //■選択されていない（「""」になっている）とき、選択肢をリセット
  if (departmentname1.value == '') {
    reset2();
    reset3();
    reset4();
    reset5();
    reset6();
    reset7();
    return;
  }
    //console.log(area1.value);
});

//■拠点が選択されたらユニットのプルダウンを生成
$('#officename').on('change', function() {
  //●プルダウンを「""」のみにする
  optionClear('#unitname > option');
  unitname1.appendChild(firstOption());
  optionClear('#teamname > option');
  teamname1.appendChild(firstOption());
  optionClear('#MEFULLNAME > option');
  MEFULLNAME1.appendChild(firstOption());
  optionClear('#position > option');
  position1.appendChild(firstOption());
  optionClear('#role > option');
  role1.appendChild(firstOption());


 //●拠点で選択されたカテゴリーを含むもののみをプルダウンの選択肢に設定する
  pullFilter12(officename1,'officename');
  pullFilter13(officename1,'officename');
  pullFilter14(officename1,'officename');
  pullFilter15(officename1,'officename');
  pullFilter16(officename1,'officename');

  //●選択されていない（「""」になっている）とき、選択肢をリセット
  if (officename1.value == '') {  
      if(departmentname1.value != ''){
        //●エリアで選択されたカテゴリーを含むもののみをプルダウンの選択肢に設定する
        pullFilter1(departmentname1,'departmentname');
        pullFilter2(departmentname1,'departmentname');
        pullFilter3(departmentname1,'departmentname');
        pullFilter4(departmentname1,'departmentname');
        pullFilter5(departmentname1,'departmentname');
        pullFilter6(departmentname1,'departmentname');
          
        return;
      }

      reset3();
      reset4();
      reset5();
      reset6();
      reset7();
      return;
    }

});

//■ユニットが選択されたらチームのプルダウンを生成
$('#unitname').on('change', function() {
  //●プルダウンを「""」のみにする
  optionClear('#teamname > option');
  teamname1.appendChild(firstOption());
  optionClear('#MEFULLNAME > option');
  MEFULLNAME1.appendChild(firstOption());
  optionClear('#position > option');
  position1.appendChild(firstOption());
  optionClear('#role > option');
  role1.appendChild(firstOption());


  //●拠点で選択されたカテゴリーを含むもののみをプルダウンの選択肢に設定する
  pullFilter13(unitname1,'unitname');

  //氏名の選択肢
  pullFilter14(unitname1,'unitname');

  //役職の選択肢
  pullFilter15(unitname1,'unitname');

  //役割の選択肢
  pullFilter16(unitname1,'unitname');


    // 選択されていない（「""」になっている）とき、選択肢をリセット
    if (unitname1.value == '') {

      if(officename1.value != ''){
        //ユニットの選択肢
        pullFilter12(officename1,'officename');

        //チームの選択肢
        pullFilter13(officename1,'officename');

        //氏名の選択肢
        pullFilter14(officename1,'officename');

        //役職の選択肢
        pullFilter15(officename1,'officename');

        //役割の選択肢
        pullFilter16(officename1,'officename');
          
        return;

      }else{
        if(departmentname1.value != ''){
          //オフィスの選択肢
          pullFilter1(departmentname1,'departmentname');

          //ユニットの選択肢
          pullFilter2(departmentname1,'departmentname');
  
          //チームの選択肢
          pullFilter3(departmentname1,'departmentname');
  
          //氏名の選択肢
          pullFilter4(departmentname1,'departmentname');

          //役職の選択肢
          pullFilter5(departmentname1,'departmentname');

          //役割の選択肢
          pullFilter6(departmentname1,'departmentname');
            
          return;

        }
      }
      reset4();
      reset5();
      reset6();
      reset7();
      return;
    }
});



//////////////////////////////////////////
// チームが選択されたら氏名のプルダウンを生成
//////////////////////////////////////////
$('#teamname').on('change', function() {
  // 氏名のプルダウンを「""」のみにする
  optionClear('#MEFULLNAME > option');
  MEFULLNAME1.appendChild(firstOption());

  // 役職のプルダウンを「""」のみにする
  optionClear('#position > option');
  position1.appendChild(firstOption());

  // 役割のプルダウンを「""」のみにする
  optionClear('#role > option');
  role1.appendChild(firstOption());
  
  


  // チームで選択されたカテゴリーと同じ氏名のみを、プルダウンの選択肢に設定する
  pullFilter4(teamname1,'teamname');

  pullFilter5(teamname1,'teamname');

  pullFilter6(teamname1,'teamname');


      // 選択されていない（「""」になっている）とき、選択肢をリセット
    if (teamname1.value == '') {
      if(unitname1.value != ''){
        //チームの選択肢
        pullFilter13(unitname1,'unitname');

        //氏名の選択肢
        pullFilter14(unitname1,'unitname');

        //役職の選択肢
        pullFilter15(unitname1,'unitname');

        //役割の選択肢
        pullFilter16(unitname1,'unitname');

        return;

      }else{
        if(officename1.value != ''){
          //ユニットの選択肢
          pullFilter12(officename1,'officename');

          //チームの選択肢
          pullFilter13(officename1,'officename');

          //氏名の選択肢
          pullFilter14(officename1,'officename');

          //役職の選択肢
          pullFilter15(officename1,'officename');

          //役割の選択肢
          pullFilter16(officename1,'officename');

          return;

        }else{
          if(departmentname1.value != ''){
            //オフィスの選択肢
            pullFilter1(departmentname1,'departmentname');
  
            //ユニットの選択肢
            pullFilter2(departmentname1,'departmentname');
    
            //チームの選択肢
            pullFilter3(departmentname1,'departmentname');
    
            //氏名の選択肢
            pullFilter4(departmentname1,'departmentname');
              
            //役職の選択肢
            pullFilter5(departmentname1,'departmentname');

            //役割の選択肢
            pullFilter6(departmentname1,'departmentnamea');

            return;

          }
        }

      }
      reset5();
      reset6();
      reset7();
      return;
    }
});

//////////////////////////////////////////////
// 氏名が選択されたら役職・役割のプルダウンを生成
//////////////////////////////////////////////
$('#MEFULLNAME').on('change', function() {

  // 氏名のプルダウンを「""」のみにする
  optionClear('#position > option');
  position1.appendChild(firstOption());

  // 役職のプルダウンを「""」のみにする
  optionClear('#role > option');
  role1.appendChild(firstOption());


  // チームで選択されたカテゴリーと同じ氏名のみを、プルダウンの選択肢に設定する
  
  pullFilter5(MEFULLNAME1,'MEFULLNAME');

  pullFilter6(MEFULLNAME1,'MEFULLNAME');


      // 選択されていない（「""」になっている）とき、選択肢をリセット
    if (MEFULLNAME1.value == '') {
      if(teamname1.value != ''){
        //氏名の選択肢
        pullFilter14(teamname1,'teamname');

        //役職の選択肢
        pullFilter15(teamname1,'teamname');

        //役割の選択肢
        pullFilter16(teamname1,'teamname');

        return;

      }else{
        if(unitname1.value != ''){
          //チームの選択肢
          pullFilter13(unitname1,'unitname');

          //氏名の選択肢
          pullFilter14(unitname1,'unitname');

          //役職の選択肢
          pullFilter15(unitname1,'unitname');
          
          //役割の選択肢
          pullFilter16(unitname1,'unitname');

          return;

        }else{
          if(officename1.value != ''){
            
  
            //ユニットの選択肢
            pullFilter12(officename1,'officename');
    
            //チームの選択肢
            pullFilter13(officename1,'officename');
    
            //氏名の選択肢
            pullFilter14(officename1,'officename');
              
            //役職の選択肢
            pullFilter15(officename1,'officename');

            //役割の選択肢
            pullFilter16(officename1,'officename');

            return;
          }else{
            if(departmentname1.value != ''){
              //オフィスの選択肢
              pullFilter1(departmentname,'departmentname');
    
              //ユニットの選択肢
              pullFilter2(departmentname1,'departmentname');
      
              //チームの選択肢
              pullFilter3(departmentname1,'departmentname');
      
              //氏名の選択肢
              pullFilter4(departmentname1,'departmentname');
                
              //役職の選択肢
              pullFilter5(departmentname1,'departmentname');

              //役割の選択肢
              pullFilter6(departmentname1,'departmentname');
  
              return;
        }
      }
    }

      }
    
      
      reset6();
      reset7();
      return;
    }
});








function reset1(){
    // エリアのプルダウンを「""」のみにする
    optionClear('#departmentname > option');
    departmentname1.appendChild(firstOption());

///////////////////////////
//データベース空欄なしver
    // エリアのプルダウンを生成
    /*
    if (Array.isArray(areaPull)) {
      areaPull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
        area1.appendChild(option);
      });
    } else {
      console.error("areaPull is not an array");
    }

*//////////////////////
/*
    if (Array.isArray(departmentPull)) {
      
      let otherAreaAdded = false; // 他のエリアのオプションが追加されているかチェック用のフラグ
      areaPull.forEach(row => {
        if (row.trim() === "") {
          // もし行（row）が空であれば、「その他のエリア」のオプションを追加する
          if (!otherAreaAdded) {
            const otherOption = document.createElement('option');
            otherOption.textContent = "その他カテゴリー";
            area1.appendChild(otherOption);
            otherAreaAdded = true;
          }
        } else {
          // 通常のエリアオプションを追加する
          const option = document.createElement('option');
          option.textContent = row;
          area1.appendChild(option);
        }
      });
    
      // 「その他カテゴリー」のオプションがまだ追加されていない場合、すべての他のオプションの後にそれを追加する
      if (!otherAreaAdded) {
        const otherOption = document.createElement('option');
        otherOption.textContent = "その他カテゴリー";
        area1.appendChild(otherOption);
      }
    } else {
      console.error("areaPull is not an array");
    }
      */
    // 部のプルダウンを生成
    if (Array.isArray(departmentPull)) {
      departmentPull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
        departmentname1.appendChild(option);
      });
    } else {
      console.error("departmentnamePull is not an array");
    }
}   

function reset2(){  
    // 拠点のプルダウンを「""」のみにする
    optionClear('#officename > option');
    officename1.appendChild(firstOption());
    // 拠点のプルダウンを生成
    if (Array.isArray(officePull)) {
      officePull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
        officename1.appendChild(option);
      });
    } else {
      console.error("officenamePull is not an array");
    }
  }

function reset3(){
      // ユニットのプルダウンを「""」のみにする
      optionClear('#unitname > option');
      unitname1.appendChild(firstOption());
      // ユニットのプルダウンを生成
      if (Array.isArray(unitPull)) {
        unitPull.forEach(row => {
          const option = document.createElement('option');
          option.textContent = row;
          if (option.textContent === "") {
            return;
          }
          unitname1.appendChild(option);
        });
      } else {
        console.error("unitnamePull is not an array");
      }
  }

function reset4(){
    // チームのプルダウンを「""」のみにする
    optionClear('#teamname > option');
    teamname1.appendChild(firstOption());
    // チームのプルダウンを生成
    if (Array.isArray(teamPull)) {
      teamPull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
        teamname1.appendChild(option);
      });
    } else {
      console.error("teamnamePull is not an array");
    }
  }

function reset5(){
    // 氏名のプルダウンを「""」のみにする
    optionClear('#MEFULLNAME > option');
    MEFULLNAME1.appendChild(firstOption());
    // 氏名のプルダウンを生成
    if (Array.isArray(fullnamePull)) {
      fullnamePull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
          MEFULLNAME1.appendChild(option);
      });
    } else {
      console.error("MEFULLNAMEPull is not an array");
    }
}

function reset6(){
    // 役職のプルダウンを「""」のみにする
    optionClear('#position > option');
    position1.appendChild(firstOption());
    // 役職のプルダウンを生成
    if (Array.isArray(positionPull)) {
      positionPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      position1.appendChild(option);
    });
    } else {
    console.error("positionPull is not an array");
    }
}

function reset7(){
    // 役割のプルダウンを「""」のみにする
    optionClear('#role > option');
    role1.appendChild(firstOption());
    // 役割のプルダウンを生成
    if (Array.isArray(positionPull)) {
      rolePull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
        role1.appendChild(option);
      });
    } else {
    console.error("rolePull is not an array");
    }
}

///////////////////////////////////////////////
///////////////////////////////////////////////
//エリアプルダウンに則する場合
//拠点絞り込み用
function pullFilter1(idstr, col){
    // 拠点のプルダウンを「""」のみにする
    optionClear('#officename > option');
    officename1.appendChild(firstOption());
    // 選択された値を取得する
    var selectedValues = [];
    for (var i = 0; i < idstr.options.length; i++) {
      if (idstr.options[i].selected) {
        selectedValues.push(idstr.options[i].value);
      }
    }
    // console.log(selectedValues);
    // エリアで選択されたカテゴリーと同じ拠点のみを、プルダウンの選択肢に設定する
    const processedValues1 = []; // 重複をチェックするための配列
    
    selectedValues.forEach(row2 => {
      aaa2.forEach(row => {
        if (row2 == row[col] && !processedValues1.includes(row.officename)) {
          const option = document.createElement('option');
          option.textContent = row.officename;
          officename1.appendChild(option);
          processedValues1.push(row.officename); // 処理済みの値を追加
        }
      });
    });
}

//ユニット絞り込み用
function pullFilter2(idstr, col){
    // ユニットのプルダウンを「""」のみにする
    optionClear('#unitname > option');
    unitname1.appendChild(firstOption());
    // 選択された値を取得する
    var selectedValues = [];
    for (var i = 0; i < idstr.options.length; i++) {
      if (idstr.options[i].selected) {
        selectedValues.push(idstr.options[i].value);
      }
    }
    const processedValues2 = []; 
    selectedValues.forEach(row2 => {
      //ユニットの選択肢
      aaa1.forEach(row => {
        if (row2 == row[col] && !processedValues2.includes(row.unitname)) {
          const option = document.createElement('option');
          option.textContent = row.unitname;
          unitname1.appendChild(option);
          processedValues2.push(row.unitname); // 処理済みの値を追加
        }
      });
    });
}

//チーム絞り込み用
function pullFilter3(idstr,col){
    // チームのプルダウンを「""」のみにする
    optionClear('#teamname > option');
    teamname1.appendChild(firstOption());
    // 選択された値を取得する
    var selectedValues = [];
    for (var i = 0; i < idstr.options.length; i++) {
      if (idstr.options[i].selected) {
        selectedValues.push(idstr.options[i].value);
      }
    }
    const processedValues3 = []; 
    selectedValues.forEach(row2 => {
      //チームの選択肢
      aaa3.forEach(row => {
        if (row2 == row[col] && !processedValues3.includes(row.teamname)) {
          const option = document.createElement('option');
          option.textContent = row.teamname;
          teamname1.appendChild(option);
          processedValues3.push(row.teamname); // 処理済みの値を追加
        }
      });
    });
}

//氏名絞り込み用
function pullFilter4(idstr,col){
    // 氏名のプルダウンを「""」のみにする
    optionClear('#MEFULLNAME > option');
    MEFULLNAME1.appendChild(firstOption());
    var selectedValues = [];
    for (var i = 0; i < idstr.options.length; i++) {
      if (idstr.options[i].selected) {
        selectedValues.push(idstr.options[i].value);
      }
    }
    const processedValues4 = []; 
    selectedValues.forEach(row2 => {
      //氏名の選択肢
      aaa.forEach(row => {
        if (row2 == row[col] && !processedValues4.includes(row.MEFULLNAME)) {
          const option = document.createElement('option');
          option.textContent = row.MEFULLNAME;
          MEFULLNAME1.appendChild(option);
          processedValues4.push(row.MEFULLNAME); // 処理済みの値を追加
        }
      });
    });
}

//役職絞り込み用
function pullFilter5(idstr,col){
    // 役職のプルダウンを「""」のみにする
    optionClear('#position > option');
    position1.appendChild(firstOption());
    var selectedValues = [];
    for (var i = 0; i < idstr.options.length; i++) {
      if (idstr.options[i].selected) {
        selectedValues.push(idstr.options[i].value);
      }
    }
    const processedValues5 = []; 
    selectedValues.forEach(row2 => {
      //役職の選択肢
      aaa4.forEach(row => {
        if (row2 == row[col] && !processedValues5.includes(row.name_g)) {
          const option = document.createElement('option');
          option.textContent = row.name_g;
          position1.appendChild(option);
          processedValues5.push(row.name_g); // 処理済みの値を追加
        }
      });
    });
}


//役割絞り込み用
function pullFilter6(idstr,col){
    // 役割のプルダウンを「""」のみにする
    optionClear('#role > option');
    role1.appendChild(firstOption());
    var selectedValues = [];
    for (var i = 0; i < idstr.options.length; i++) {
      if (idstr.options[i].selected) {
        selectedValues.push(idstr.options[i].value);
      }
    }
    const processedValues5 = []; 
    selectedValues.forEach(row2 => {
      //役職の選択肢
      aaa5.forEach(row => {
        if (row2 == row[col] && !processedValues5.includes(row.rolename)) {
          const option = document.createElement('option');
          option.textContent = row.rolename;
          role1.appendChild(option);
          processedValues5.push(row.rolename); // 処理済みの値を追加
        }
      });
    });
}



///////////////////////////////////////
//通常の場合
//ユニット
function pullFilter12(idstr, col) {
  // ユニットのプルダウンを「""」のみにする
  optionClear('#unitname > option');
  unitname1.appendChild(firstOption());
  //エリアからの絞り込みは動作が異なるので別枠
  if(departmentname1.value == ""){
    pullFilter2(idstr, col);
    return;
  }
  // 選択されたエリアとオフィスの値を取得する
  var selectedValuesDepartment = [];
  for (var i = 0; i < departmentname1.options.length; i++) {
    if (departmentname1.options[i].selected) {
      selectedValuesDepartment.push(departmentname1.options[i].value);
    }
  }
  var selectedValues = [];
  for (var i = 0; i < idstr.options.length; i++) {
    if (idstr.options[i].selected) {
      selectedValues.push(idstr.options[i].value);
    }
  }
  // ユニット名の選択肢を絞り込む
  const processedValues = [];
  aaa1.forEach(row => {
    if (
      selectedValues.includes(row[col]) &&
      selectedValuesDepartment.includes(row["departmentname"]) &&
      !processedValues.includes(row.unitname)
    ) {
      const option = document.createElement('option');
      option.textContent = row.unitname;
      unitname1.appendChild(option);
      processedValues.push(row.unitname); // 処理済みの値を追加
    }
  });
}

//チーム
function pullFilter13(idstr, col) {
  // チームのプルダウンを「""」のみにする
  optionClear('#teamname > option');
  teamname1.appendChild(firstOption());
  if(departmentname1.value == ""){
    pullFilter3(idstr, col);
    return;
  }
  // 選択されたエリアとオフィスの値を取得する
  var selectedValuesDepartment = [];
  for (var i = 0; i < departmentname1.options.length; i++) {
    if (departmentname1.options[i].selected) {
      selectedValuesDepartment.push(departmentname1.options[i].value);
    }
  }
  var selectedValues = [];
  for (var i = 0; i < idstr.options.length; i++) {
    if (idstr.options[i].selected) {
      selectedValues.push(idstr.options[i].value);
    }
  }
  // ユニット名の選択肢を絞り込む
  const processedValues = [];
  aaa3.forEach(row => {
    if (
      selectedValues.includes(row[col]) &&
      selectedValuesDepartment.includes(row["departmentname"]) &&
      !processedValues.includes(row.teamname)
    ) {
      const option = document.createElement('option');
      option.textContent = row.teamname;
      teamname1.appendChild(option);
      processedValues.push(row.teamname); // 処理済みの値を追加
    }
  });
}

//氏名
function pullFilter14(idstr, col) {
  // 氏名のプルダウンを「""」のみにする
  optionClear('#MEFULLNAME > option');
  MEFULLNAME1.appendChild(firstOption());
  if(departmentname1.value == ""){
    pullFilter4(idstr, col);
    return;
  }
  // 選択されたエリアとオフィスの値を取得する
  var selectedValuesDepartment = [];
  for (var i = 0; i < departmentname1.options.length; i++) {
    if (departmentname1.options[i].selected) {
      selectedValuesDepartment.push(departmentname1.options[i].value);
    }
  }
  var selectedValues = [];
  for (var i = 0; i < idstr.options.length; i++) {
    if (idstr.options[i].selected) {
      selectedValues.push(idstr.options[i].value);
    }
  }
  // 氏名の選択肢を絞り込む
  const processedValues = [];
  aaa.forEach(row => {
    if (
      selectedValues.includes(row[col]) &&
      selectedValuesDepartment.includes(row["departmentname"]) &&
      !processedValues.includes(row.MEFULLNAME)
    ) {
      const option = document.createElement('option');
      option.textContent = row.MEFULLNAME;
      MEFULLNAME1.appendChild(option);
      processedValues.push(row.MEFULLNAME); // 処理済みの値を追加
    }
  });
}

//役職
function pullFilter15(idstr, col) {
  // 役職のプルダウンを「""」のみにする
  optionClear('#position > option');
  position1.appendChild(firstOption());
  if(departmentname1.value == ""){
    pullFilter5(idstr, col);
    return;
  }
  // 選択されたエリアとオフィスの値を取得する
  var selectedValuesDepartment = [];
  for (var i = 0; i < departmentname1.options.length; i++) {
    if (departmentname1.options[i].selected) {
      selectedValuesDepartment.push(departmentname1.options[i].value);
    }
  }
  var selectedValues = [];
  for (var i = 0; i < idstr.options.length; i++) {
    if (idstr.options[i].selected) {
      selectedValues.push(idstr.options[i].value);
    }
  }
  // 役職の選択肢を絞り込む
  const processedValues = [];
  aaa4.forEach(row => {
    if (
      selectedValues.includes(row[col]) &&
      selectedValuesDepartment.includes(row["departmentname"]) &&
      !processedValues.includes(row.name_g)
    ) {
      const option = document.createElement('option');
      option.textContent = row.name_g;
      position1.appendChild(option);
      processedValues.push(row.name_g); // 処理済みの値を追加
    }
  });
}

//役割
function pullFilter16(idstr, col) {
  // ユニットのプルダウンを「---」のみにする
  optionClear('#role > option');
  role1.appendChild(firstOption());

  if(departmentname1.value == ""){
    pullFilter6(idstr, col);
    return;
  }

  // 選択されたエリアとオフィスの値を取得する
  var selectedValuesDepartment = [];
  for (var i = 0; i < departmentname1.options.length; i++) {
    if (departmentname1.options[i].selected) {
      selectedValuesDepartment.push(departmentname1.options[i].value);
    }
  }

  var selectedValues = [];
  for (var i = 0; i < idstr.options.length; i++) {
    if (idstr.options[i].selected) {
      selectedValues.push(idstr.options[i].value);
    }
  }
  // 役割の選択肢を絞り込む
  const processedValues = [];
  aaa5.forEach(row => {
    if (
      selectedValues.includes(row[col]) &&
      selectedValuesDepartment.includes(row["departmentname"]) &&
      !processedValues.includes(row.rolename)
    ) {
      const option = document.createElement('option');
      option.textContent = row.rolename;
      role1.appendChild(option);
      processedValues.push(row.rolename); // 処理済みの値を追加
    }
  });
}





function clearPullGenerate(){
  /*///////////////////
  //エリアに空欄がない場合はこっち
    // エリアのプルダウンを生成
    if (Array.isArray(areaPull)) {
      area1.innerHTML = ''; // クリア
      const defaultOption = document.createElement('option');
      defaultOption.textContent = '';
      area1.appendChild(defaultOption);

      areaPull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
        area1.appendChild(option);
      });
    } else {
      console.error("areaPull is not an array");
    }
  */////////////////////////////

/////以下初期プルダウン生成とほぼ同じ（HTMLのクリアを先にする）
  /*if (Array.isArray(areaPull)) {
    area1.innerHTML = ''; // クリア
    let otherAreaAdded = false; 
    areaPull.forEach(row => {
      if (row.trim() === "") {
        if (!otherAreaAdded) {
          const otherOption = document.createElement('option');
          otherOption.textContent = "その他カテゴリー";
          area1.appendChild(otherOption);
          otherAreaAdded = true;
        }
      } else {
        const option = document.createElement('option');
        option.textContent = row;
        area1.appendChild(option);
      }
    });
    if (!otherAreaAdded) {
      const otherOption = document.createElement('option');
      otherOption.textContent = "その他カテゴリー";
      area1.appendChild(otherOption);
    }
  } else {
    console.error("areaPull is not an array");
  }*/
    if (Array.isArray(departmentPull)) {
      departmentname1.innerHTML = ''; // クリア
      const defaultOption = document.createElement('option');
      defaultOption.textContent = '';
      departmentname1.appendChild(defaultOption);
      departmentPull.forEach(row => {
        const option = document.createElement('option');
        option.textContent = row;
        if (option.textContent === "") {
          return;
        }
        departmentname1.appendChild(option);
      });
    } else {
      console.error("departmentPull is not an array");
    }

  // 拠点のプルダウンを生成
  if (Array.isArray(officePull)) {
    officename1.innerHTML = ''; // クリア
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '';
    officename1.appendChild(defaultOption);
    officePull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      officename1.appendChild(option);
    });
  } else {
    console.error("areaPull is not an array");
  }

  // ユニットのプルダウンを生成
  if (Array.isArray(unitPull)) {
    unitname1.innerHTML = ''; // クリア
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '';
    unitname1.appendChild(defaultOption);
    unitPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      unitname1.appendChild(option);
    });
  } else {
    console.error("areaPull is not an array");
  }

  // チームのプルダウンを生成
  if (Array.isArray(teamPull)) {
    teamname1.innerHTML = ''; // クリア
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '';
    teamname1.appendChild(defaultOption);
    teamPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      teamname1.appendChild(option);
    });
  } else {
    console.error("areaPull is not an array");
  }

  // 氏名のプルダウンを生成
  if (Array.isArray(fullnamePull)) {
    MEFULLNAME1.innerHTML = ''; // クリア
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '';
    MEFULLNAME1.appendChild(defaultOption);  
    fullnamePull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      MEFULLNAME1.appendChild(option);
    });
  } else {
    console.error("areaPull is not an array");
  }

  // 役職のプルダウンを生成
  if (Array.isArray(positionPull)) {
    position1.innerHTML = ''; // クリア
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '';
    position1.appendChild(defaultOption);
    positionPull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      position1.appendChild(option);
    });
  } else {
    console.error("positionPull is not an array");
  }

  // 役割のプルダウンを生成
  if (Array.isArray(rolePull)) {
    role1.innerHTML = ''; // クリア
    const defaultOption = document.createElement('option');
    defaultOption.textContent = '';
    role1.appendChild(defaultOption);
    rolePull.forEach(row => {
      const option = document.createElement('option');
      option.textContent = row;
      if (option.textContent === "") {
        return;
      }
      role1.appendChild(option);
    });
  } else {
    console.error("rolePull is not an array");
  }
  
}