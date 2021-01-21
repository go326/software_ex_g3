function error() {
  //window.sessionStorage.setItem(['login_error'],['ユーザが見つかりません']);
  // window.sessionStorage.setItem(['login_error'],['ログイン認証に失敗']);
  var error = window.sessionStorage.getItem(['login_error']);
  alert(error);
  // 全てのセッションの削除
  // window.sessionStorage.clear();
}

function maxLengthCheck(object) {
  if (object.value.length > object.maxLength)
    object.value = object.value.slice(0, object.maxLength)
}