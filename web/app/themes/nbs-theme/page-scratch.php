<?php
use Testeleven\Schedule\Registry;
$scheduled_classes = Registry\Scheduled_Class_Registry::get_instance();
?>
<h1>This is the scratch page</h1>

<?php echo $scheduled_classes->schedule->draw();  ?>


