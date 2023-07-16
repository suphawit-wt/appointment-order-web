<?php $today = date("Y-m-d"); ?>
<?php if ($today > $_GET['to']) : ?>
    <span class="label gradient-2 btn-rounded">หมดอายุแล้ว</span>
<?php else : ?>
    <span class="label gradient-1 btn-rounded">ยังไม่หมดอายุ</span>
<?php endif; ?>