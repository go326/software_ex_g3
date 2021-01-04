/** 
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
        option.innerHTML = i;
        day.appendChild(option);
    }
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
        option.innerHTML = i;
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
        option.innerHTML = i;
        count.appendChild(option);
    }
}