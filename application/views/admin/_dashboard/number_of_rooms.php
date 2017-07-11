<?php
$params = array(
    'categories' => array(8),
    'start' => date('Y-m-d 00:00:00'),
    'end' => date('Y-m-d 23:59:59')
);
$this->load->library('Eventsbuilder');
$total = $this->eventsbuilder->get_count($params);
?>
<div class="col-lg-3 col-md-3 col-sm-3 tile_stats_count text-center">
    <div class="value">
        <?php echo (int)$total; ?>
    </div>
    <div class="tile_count_label text-muted">
        # of Rooms
    </div>
</div>
