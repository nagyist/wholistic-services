<?php
use Testeleven\Schedule\Registry;
$scheduled_classes = Registry\Scheduled_Class_Registry::get_instance();
?>

<?php echo $scheduled_classes->schedule->draw();  ?>