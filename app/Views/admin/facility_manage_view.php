<h1>시설관리</h1>
<p>시설 등록 / 수정 / 삭제 </p>

<!-- 등록 폼 -->
<div>
    <h3>시설 등록</h3>
    <form id="createForm">
        <label>시설명:
            <input type="text" name="facility_name" required>
        </label><br>
        <label>설명:
            <textarea name="description"></textarea>
        </label><br>
        <label>최대수용인원:
            <input type="number" name="max_capacity" min="0" value="0">
        </label><br>
        <button type="submit">등록</button>
    </form>
</div>

<hr>

<!-- 목록 -->
<div>
    <h3>시설 목록</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>시설명</th>
            <th>설명</th>
            <th>최대수용인원</th>
            <th>수정/삭제</th>
        </tr>
        </thead>
        <tbody id="facilityTable">
        <?php foreach($facilities as $f): ?>
            <tr data-id="<?= $f['facility_id'] ?>">
                <td><?= $f['facility_id'] ?></td>
                <td class="name"><?= htmlspecialchars($f['facility_name']) ?></td>
                <td class="desc"><?= htmlspecialchars($f['description']) ?></td>
                <td class="capacity"><?= (int)$f['max_capacity'] ?></td>
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
    <h3>시설 수정</h3>
    <form id="editForm">
        <input type="hidden" name="facility_id" id="edit_id">
        <label>시설명:
            <input type="text" name="facility_name" id="edit_name" required>
        </label><br>
        <label>설명:
            <textarea name="description" id="edit_desc"></textarea>
        </label><br>
        <label>최대수용인원:
            <input type="number" name="max_capacity" id="edit_capacity" min="0">
        </label><br>
        <button type="submit">수정하기</button>
    </form>
</div>

<script>
    $(function(){
        // [등록]
        $('#createForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: '/facilities/list.php',
                method: 'POST',
                data: {
                    action: 'create',
                    facility_name: $(this).find('[name="facility_name"]').val(),
                    description:   $(this).find('[name="description"]').val(),
                    max_capacity:  $(this).find('[name="max_capacity"]').val()
                },
                dataType: 'json',
                success: function(res){
                    if (res.status==='success'){
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
            let id       = tr.data('id');
            let name     = tr.find('.name').text();
            let desc     = tr.find('.desc').text();
            let capacity = tr.find('.capacity').text();

            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_desc').val(desc);
            $('#edit_capacity').val(capacity);

            $('#editModal').show();
        });

        // [수정 폼 전송]
        $('#editForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: '/facilities/list.php',
                method: 'POST',
                data: {
                    action: 'update',
                    facility_id:    $('#edit_id').val(),
                    facility_name:  $('#edit_name').val(),
                    description:    $('#edit_desc').val(),
                    max_capacity:   $('#edit_capacity').val()
                },
                dataType: 'json',
                success: function(res){
                    if (res.status==='success'){
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
            if(!confirm("정말 삭제하시겠습니까?")) {
                return;
            }
            let tr = $(this).closest('tr');
            let id = tr.data('id');

            $.ajax({
                url: '/facilities/list.php',
                method: 'POST',
                data: {
                    action: 'delete',
                    facility_id: id
                },
                dataType: 'json',
                success: function(res){
                    if (res.status==='success'){
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
