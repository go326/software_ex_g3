/*getElementById(id名)では、html内の上から順番に探し、
*最初のモノだけに適用
*getElementsByName();なぜか上手くいかない
*
*現在の実装方法として冗長な書き方になってしまうが、
*ドロップダウンリストの年月日の箇所文メソッドが増えてしまう
*
*可能であれば、class,nameで取得できれば、一つのメソッドで実装が可能
*/
function getYear1(){
    let year = document.getElementById("year1");
    document.createElement("option")
    for (let i = 2020; i < 2100; i++){
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        year.appendChild(option);
    }
}
function getMonth1(){
    let month = document.getElementById("month1");
    //let month = document.getElementsByName("month");

    document.createElement("option")
    for(let i = 1; i <= 12; i++){
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        month.appendChild(option);
    }
}
function getDay1(){
    let day = document.getElementById("day1");
    //let day = document.getElementsByName("day");

    document.createElement("option")
    for(let i = 1; i <= 31; i++){
        let option = document.createElement("option");
        option.innerHTML = i;
        day.appendChild(option);
    }
}
/*二つ目*/
function getYear2(){
    let year = document.getElementById("year2");
    document.createElement("option")
    for (let i = 2020; i < 2100; i++){
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        year.appendChild(option);
    }
}
function getMonth2(){
    let month = document.getElementById("month2");
    //let month = document.getElementsByName("month");

    document.createElement("option")
    for(let i = 1; i <= 12; i++){
        let option = document.createElement("option");
        option.setAttribute("value", i);
        option.innerHTML = i;
        month.appendChild(option);
    }
}
function getDay2(){
    let day = document.getElementById("day2");
    //let day = document.getElementsByName("day");

    document.createElement("option")
    for(let i = 1; i <= 31; i++){
        let option = document.createElement("option");
        option.innerHTML = i;
        day.appendChild(option);
    }
}