<?php
$params =array(
    'locations' => $this->session->userdata('location_id'),
    'categories' => array(1, 2),
    'start' => date('Y-m-d 00:00:00'),
    'end' => date('Y-m-d 23:59:59'),
    'report_group_by' => '',
    'group_by' => '',
);
$this->load->library('Eventsbuilder');
$total = $this->eventsbuilder->get_count($params);
?>
<div class="col-lg-3 col-md-3 col-sm-3 tile_stats_count text-center">
    <div class="value">
        <?php echo (int)$total;?>
    </div>
    <div class="tile_count_label text-muted">
        # of Treatments
    </div>
</div>
