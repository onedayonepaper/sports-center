<h1>로그인</h1>
<div id="err" style="color:red;"></div>
<div id="msg" style="color:blue;"></div>

<form id="loginForm">
  <label>아이디: <input type="text" name="username" required></label><br>
  <label>비밀번호: <input type="password" name="password" required></label><br>
  <button type="submit">로그인</button>
</form>

<script>
$(function(){
  $('#loginForm').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '/users/login.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res){
        if(res.status === 'success'){
          $('#msg').text(res.message);
          $('#err').text('');
          window.location.href = '/index.php';
        } else {
          $('#err').text(res.message);
          $('#msg').text('');
        }
      },
      error: function(){
        $('#err').text("통신 오류");
      }
    });
  });
});
</script>
