//入力チェックとハイフンの除去
function searchCheck(){
    let name = document.getElementById('name');
    let tel = document.getElementById('tel');
    if(name.value == "" && tel.value == ""){
        alert("未入力です")
        return false;
    }    
    let checkTel = document.getElementById('tel').value.replace(/[━.*‐.*―.*－.*\-.*ー.*\-]/gi,'');
    document.getElementById('tel').value = checkTel;
    return true;
}
