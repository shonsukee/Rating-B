<?php
$message = get_message();
if ($message !== false) {
?>
    <div class="alert alert-info" role="alert">
        <?= h($message); ?>
    </div>
<?php } ?>