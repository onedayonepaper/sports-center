<h1>예약 목록</h1>
<p>시설 예약을 등록/수정/삭제하는 예시</p>

<!-- 예약 등록 폼 -->
<div>
  <h3>예약 생성</h3>
  <form id="createForm">
    <!-- 참고: 실제로는 facility_id/user_id 를 SELECT 박스에서 고르도록 할 수도 있음 -->
    <label>Facility ID: <input type="number" name="facility_id" required></label><br>
    <label>User ID: <input type="number" name="user_id" required></label><br>
    <label>시작시간: <input type="datetime-local" name="start_time" required></label><br>
    <label>종료시간: <input type="datetime-local" name="end_time" required></label><br>
    <label>메모: <input type="text" name="note"></label><br>
    <button type="submit">예약 생성</button>
  </form>
</div>

<hr>

<!-- 예약 목록 -->
<div>
  <h3>예약 목록</h3>
  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>ID</th>
        <th>시설ID / 이름</th>
        <th>유저ID / 이름</th>
        <th>시작</th>
        <th>종료</th>
        <th>메모</th>
        <th>수정/삭제</th>
      </tr>
    </thead>
    <tbody id="resTable">
    <?php foreach($reservations as $r): ?>
      <tr data-id="<?= $r['reservation_id'] ?>">
        <td><?= $r['reservation_id'] ?></td>
        <td class="facility">
          <?= (int)$r['facility_id'] ?> 
          (<?= htmlspecialchars($r['facility_name'] ?? '') ?>)
        </td>
        <td class="user">
          <?= (int)$r['user_id'] ?> 
          (<?= htmlspecialchars($r['username'] ?? '') ?>)
        </td>
        <td class="start"><?= htmlspecialchars($r['start_time']) ?></td>
        <td class="end"><?= htmlspecialchars($r['end_time']) ?></td>
        <td class="note"><?= htmlspecialchars($r['note']) ?></td>
        <td>
          <button class="editBtn">수정</button>
          <button class="deleteBtn">삭제</button>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- 수정 폼 (간단 모달) -->
<div id="editModal" style="display:none; border:1px solid #ccc; padding:10px; margin-top:20px;">
  <h3>예약 수정</h3>
  <form id="editForm">
    <input type="hidden" name="reservation_id" id="edit_id">
    <label>Facility ID: <input type="number" name="facility_id" id="edit_facility" required></label><br>
    <label>User ID: <input type="number" name="user_id" id="edit_user" required></label><br>
    <label>시작시간: <input type="datetime-local" name="start_time" id="edit_start" required></label><br>
    <label>종료시간: <input type="datetime-local" name="end_time" id="edit_end" required></label><br>
    <label>메모: <input type="text" name="note" id="edit_note"></label><br>
    <button type="submit">수정하기</button>
  </form>
</div>

<script>
$(function(){
  // [예약 생성]
  $('#createForm').on('submit', function(e){
    e.preventDefault();
    let data = $(this).serializeArray();
    data.push({name:'action', value:'create'});

    $.ajax({
      url: '/reservations/list.php',
      method: 'POST',
      data: $.param(data),
      dataType: 'json',
      success: function(res){
        if (res.status==='success') {
          alert(res.message);
          location.reload();
        } else {
          alert('오류: ' + res.message);
        }
      },
      error: function(){
        alert("통신 오류");
      }
    });
  });

  // [수정 버튼]
  $('.editBtn').on('click', function(){
    let tr = $(this).closest('tr');
    let rid = tr.data('id');

    let facilityTxt = tr.find('.facility').text().split('('); // "12 (테니스장)" → ["12 ", "테니스장)"]
    let userTxt     = tr.find('.user').text().split('(');

    let facilityId  = parseInt(facilityTxt[0]) || 0;
    let userId      = parseInt(userTxt[0])     || 0;
    let start       = tr.find('.start').text();
    let end         = tr.find('.end').text();
    let note        = tr.find('.note').text();

    // 편의상 datetime-local에 맞게 포맷 변환이 필요할 수도 있음 (YYYY-MM-DDTHH:MM)
    // 여기서는 간단히 문자열 그대로 넣지만, 실제론 변환 로직을 추가해야 함.
    $('#edit_id').val(rid);
    $('#edit_facility').val(facilityId);
    $('#edit_user').val(userId);
    $('#edit_start').val(start.replace(' ', 'T'));
    $('#edit_end').val(end.replace(' ', 'T'));
    $('#edit_note').val(note);

    $('#editModal').show();
  });

  // [수정 폼 전송]
  $('#editForm').on('submit', function(e){
    e.preventDefault();
    let data = $(this).serializeArray();
    data.push({name:'action', value:'update'});

    $.ajax({
      url: '/reservations/list.php',
      method: 'POST',
      data: $.param(data),
      dataType: 'json',
      success: function(res){
        if (res.status==='success') {
          alert(res.message);
          location.reload();
        } else {
          alert('오류: ' + res.message);
        }
      },
      error: function(){
        alert("통신 오류");
      }
    });
  });

  // [삭제 버튼]
  $('.deleteBtn').on('click', function(){
    if (!confirm("정말 삭제하시겠습니까?")) return;

    let rid = $(this).closest('tr').data('id');
    $.ajax({
      url: '/reservations/list.php',
      method: 'POST',
      data: {
        action: 'delete',
        reservation_id: rid
      },
      dataType: 'json',
      success: function(res){
        if (res.status==='success') {
          alert(res.message);
          location.reload();
        } else {
          alert('오류: ' + res.message);
        }
      },
      error: function(){
        alert("통신 오류");
      }
    });
  });

});
</script>
