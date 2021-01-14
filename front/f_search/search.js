//ハイフンを外す関数
function removeHyphen(){
    alert("check")
    let checkTel = document.getElementById('tel').value.replace(/[━.*‐.*―.*－.*\-.*ー.*\-]/gi,'');
    document.getElementById('tel').value = checkTel;
}