//HTMLからの呼び出し
function date(){
    document.getElementById("view_date").innerHTML = getDate();
}
//日付の表示
function getDate(){
    var now = new Date();
    var year = now.getFullYear();
    var mon = now.getMonth() + 1;
    var day = now.getDate();
    //var hour = now.getHours();
    //var min = now.getMinutes();
    //var sec = now.getSeconds();

    var s = year + "/" + mon + "/" + day;
    return s; 
}