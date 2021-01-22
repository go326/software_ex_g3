//入力チェックとハイフンの除去
function searchCheck(){
    let message = "";
    let send = true;

    let name = document.getElementById('name');
    let tel = document.getElementById('tel');
    if(name.value == "" && tel.value == ""){
        message += "・未入力です\n"
        send = false;
    }else if(name.value == ""){//名前が未入力の時電話の桁数のチェック
        let checkTel = document.getElementById('tel').value.replace(/[━.*‐.*―.*－.*\-.*ー.*\-]/gi,'');
        document.getElementById('tel').value = checkTel;
        if(!checkTel.match(/^([0-9]{10}|[0-9]{11})$/)){//{ここの数字は}入力の数
                message += "・電話番号を正しく入力してください\n";
                send = false;
        }
    }
    
    if(send){
        return true;
    }else{
        alert(message);
        return false;
    }
}
