<h1>회원가입</h1>
<div id="err" style="color:red;"></div>
<div id="msg" style="color:blue;"></div>

<form id="regForm">
  <label>아이디: <input type="text" name="username" required></label><br>
  <label>비밀번호: <input type="password" name="password" required></label><br>
  <button type="submit">가입하기</button>
</form>

<script>
$(function(){
  $('#regForm').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '/users/register.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res){
        if(res.status === 'success'){
          $('#msg').text(res.message);
          $('#err').text('');
          $('#regForm')[0].reset();
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
