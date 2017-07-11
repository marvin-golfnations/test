<?php
ob_start();
?>

<div class="row">
	<div class="col-lg-12">
		<p>Reorder providers in a list using the mouse.</p>
		<ul class="list-group sortable">
		<?php foreach ($contacts as $contact) : ?>
		<li class="list-group-item"><span class="fa fa-sort"></span> <?php echo form_hidden('order[]', $contact['contact_id']); ?><?php echo $contact['first_name'] . ' ' . $contact['last_name']; ?></li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
	'action' => 'backend/providers/update',
	'hidden_fields' => array(),
	'title' => 'Manage Provider Display Orders',
	'contents' => $contents
));
?>