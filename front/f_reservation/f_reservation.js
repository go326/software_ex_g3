/** 
 * ドロップダウンリスト
 * 「年」は現在の年から10年間用意
*/
function getYear() {
    var dt = new Date();
    var year = dt.getFullYear();
    return year;
}
function getYear1() {
    let year = document.getElementById("year1");
    document.createElement("option")
    for (let i = getYear(); i < getYear() + 10; i++) {
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        year.appendChild(option);
    }
}
function getMonth1() {
    let month = document.getElementById("month1");
    document.createElement("option")
    for (let i = 1; i <= 12; i++) {
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        month.appendChild(option);
    }
}
function getDay1() {
    let day = document.getElementById("day1");
    document.createElement("option")
    for (let i = 1; i <= 31; i++) {
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        day.appendChild(option);
    }
}
/**
 *  あらかじめ選択
 *  日付に合わせてるので人数はプラス1したもの
 * */ 
function LoadData(ID,num){
    num -= 1;
    let objSelect = document.getElementById(ID);
    objSelect.options[num].selected = true;
}

function LoadNumber(ID, num){
    let objSelect = document.getElementById(ID);
    objSelect.options[num].selected = true;
}

/**
 * 大人の人数のドロップダウンリスト
 */
const NUMBER = 10;
function getAdult() {
    let adult = document.getElementById("adult");
    document.createElement("option")
    for (let i = 0; i <= NUMBER; i++) {
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        //option.innerHTML = i;
        adult.appendChild(option);
    }
}
/**
 * 子供の人数のドロップダウンリスト
 */
function getChild() {
    let child = document.getElementById("child");
    document.createElement("option")
    for (let i = 0; i <= NUMBER; i++) {
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        child.appendChild(option);
    }
}

/**
 * 泊数のドロップダウンリスト
 */
function getStayCount() {
    let count = document.getElementById("stay_count");
    document.createElement("option")
    for (let i = 1; i <= NUMBER; i++) {
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        count.appendChild(option);
    }
}
/**
 * 入力チェック
 * メニューについては実装していない
 */
function check(){
    let message = "";//警告で表示するメッセージ
    let send = true;//確認画面へ入力を送るか(false->送信しない、true->送信する)

    //氏名の入力チェック
    let name = document.getElementById("name");
    if(name.value == ""){
        message += "・氏名が未入力です\n";
        send = false;
    }

    //住所の入力チェック
    let address1 = document.getElementById("address1");
    if(address1.value == ""){
        message += "・住所が未入力です\n";
        send = false;
    }

    //電話番号の入力チェック
    let tel = document.getElementById("tel");
    if(tel.value == ""){
        message += "・電話番号が未入力です\n";
        send = false;
    }else{
        let checkTel = document.getElementById('tel').value.replace(/[━.*‐.*―.*－.*\-.*ー.*\-]/gi,'');
        if(!checkTel.match(/^([0-9]{10}|[0-9]{11})$/)){//{ここの数字は}入力の数
            message += "・電話番号を正しく入力してください\n";
            send = false;
        }
    }

    //大人、子供の人数が共に0の場合に、警告をだす
    let child = document.getElementById("child");
    let adult = document.getElementById("adult");
    if(adult.value == "0"){
        if(child.value == "0"){
            message += "・人数が0です\n";
            send = false;
        }
    }

    //プランの入力チェック
    let plan = document.getElementById("plan");
    if(plan.value == ""){
        message += "・プランが未入力です\n";
        send = false;
    }

    //夕食が「有」の時にメニューが未入力の時に警告
    let is_dinner = document.getElementsByName("is_dinner");
    for(i = is_dinner.length; i--;){
        if(is_dinner[i].checked){
            if(is_dinner[i].value == "有"){
                let dinner = document.getElementById("dinner_menu");
                if(dinner.value == ""){
                    message += "・夕食のメニューが未入力です\n";
                    send = false;
                }
            }
        }
    }

    //朝食が「有」の時にメニューが未入力の時に警告
    let is_breakfast = document.getElementsByName("is_breakfast");
    for(i = is_breakfast.length; i--;){
        if(is_breakfast[i].checked){
            if(is_breakfast[i].value == "有"){
                let breakfast = document.getElementById("breakfast_menu");
                if(breakfast.value == ""){
                    message += "・朝食のメニューが未入力です\n";
                    send = false;
                }
            }
        }
    }

    //部屋番号の入力チェック
    let room1 = document.getElementById("room-number1");
    let room2 = document.getElementById("room-number2");
    let room3 = document.getElementById("room-number3");
    if(room1.value == ""){
        if(room2.value == ""){
            if(room3.value == ""){
                message += "・部屋番号が未入力です\n"
                send = false;
            }
        }
    }

    //htmlに戻る
    if(send){
        //電話番号のハイフンを外す
        let checkTel2 = document.getElementById('tel').value.replace(/[━.*‐.*―.*－.*\-.*ー.*\-]/gi,'');
        document.getElementById('tel').value = checkTel2;

        return send;
    }else{
        alert(message);
        return send;
    }
}