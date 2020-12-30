/**
 * tableの生成関数
 */
//変数、定数の宣言
const NUM_OF_ROOMS = 28;//1フロアの部屋数
const NUM_OF_FLOOR = 3; //部屋があるフロア数
const LINE_BREAK = 8;//8個の要素tdで改行
const ID_NAME = "maintable";//取得するID
const LINK_HTML = "s_clean_edit.php";

/**Tableの生成関数 */
function makeTable(tabledata){
  //table要素の生成
  var table = document.createElement('table');
  var count = 0;
  for(var i = 0; i < 4; i++){
    //tr要素の生成
    var tr = document.createElement('tr');
    //LINE_BREAK分のdd(部屋)を並べると改行
    for(var j = 0; j < LINE_BREAK; j++){
      //1フロアの部屋数分を作成するとbreak
      if(count === NUM_OF_ROOMS){
        break;
      }
      //tdの生成
      var td = document.createElement('td');
      //spanの生成
      var span = document.createElement('span');
      documents.getElementById(ID_NAME).classList.add("span1");
      //span.setAttribute("class", span1);
      //<a>の追加
      var a = document.createElement('a');
      //href属性追加～tdへaタグを追加(?以降がパラメータ)
      //phpから配列を受け取るように書き換える
      a.setAttribute("href", LINK_HTML+"?room_number="+tabledata[count]);
      a.textContent = tabledata[count];
      td.appendChild(a);
      //trへtdを追加
      tr.appendChild(td);
      count++;
    }
    //tableへtr追加
    table.appendChild(tr);
  }
  document.getElementById(ID_NAME).appendChild(table);
}
//HTMLからの呼び出し
function call_makeTable(){
  makeTable(data201_235);
  makeTable(data301_335);
  makeTable(data401_435);
}


//部屋番号の配列
var data201_235 = [201, 202, 203, 205, 206, 207, 208, 210,
                   211, 212, 213, 215, 216, 217, 218, 220,
                   221, 222, 223, 225, 226, 227, 228, 230,
                   231, 232, 233, 235];
var data301_335 = [301, 302, 303, 305, 306, 307, 308, 310,
                   311, 312, 313, 315, 316, 317, 318, 320,
                   321, 322, 323, 325, 326, 327, 328, 330,
                   331, 332, 333, 335];
var data401_435 = [401, 402, 403, 405, 406, 407, 408, 410,
                   411, 412, 413, 415, 416, 417, 418, 420,
                   421, 422, 423, 425, 426, 427, 428, 430,
                   431, 432, 433, 435];

//tableの値の取得
function getTable(){
  alert("in");
  var tableData = document.getElementById(ID_NAME);
  var rowlen = tableData.rows.length; 
  for (var i = 0; i < rowlen; i++){
    for(var j = 0; j < tableData.rows[i].cells.length; j++){
      var txtTabledata = tableData.rows[i].cells[j].appendChild[0].value;
    }
  }
}