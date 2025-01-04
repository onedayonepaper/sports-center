<h1>특수 관리자 계정 생성</h1>
<p>이 페이지는 노출되지 않는 URL로 접근한다고 가정합니다.<br>
(프로젝트 초기에만 사용하고, 이후 삭제/차단 권장)</p>

<div id="err" style="color:red;"></div>
<div id="msg" style="color:blue;"></div>

<form id="adminForm">
  <label>아이디(ADMIN): <input type="text" name="username" required></label><br>
  <label>비밀번호: <input type="password" name="password" required></label><br>
  <button type="submit">관리자 계정 생성</button>
</form>

<script>
$(function(){
  $('#adminForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
      url: '/users/special_admin.php', // 실제 경로
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res){
        if (res.status === 'success') {
          $('#msg').text(res.message);
          $('#err').text('');
          $('#adminForm')[0].reset();
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
