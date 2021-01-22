/**
 * 追加料金入力チェック
 */
function check(){
    let message = "";
    let send = true;

    //場所のチェック
    let place = document.getElementById("place");
    if(place.value == ""){
        message += "・場所が未入力です\n";
        send = false;
    }

    //追加料金
    let fee = document.getElementById("fee");
    if(place.value == ""){
        message += "・追加料金が未入力です\n";
        send = false;
    }

    //内容
    let content = document.getElementById("content");
    if(content.value == ""){
        message += "・内容が未入力です\n";
        send = false;
    }


    if(send){
        //備考
        let remark = document.getElementById("remark");
        if(remark.value == ""){
            document.getElementById("remark").value ="なし";
        }
        return send;
    }else{
        alert(message);
        return send;
    }
}