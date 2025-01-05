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