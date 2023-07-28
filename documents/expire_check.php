<?php $today = date("Y-m-d"); ?>
<?php if ($today > $_GET['to']) : ?>
    <span class="label gradient-2 btn-rounded">Expired</span>
<?php else : ?>
    <span class="label gradient-1 btn-rounded">Activate</span>
<?php endif; ?>