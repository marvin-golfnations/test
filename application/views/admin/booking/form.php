<?php
ob_start ();

$can_edit = $this->session->userdata('can_edit_completed_forms');

if ($completed_by > 0 && $can_edit === 'n' && get_current_user_id() !== $completed_by) :
    ?>
    You are not allowed to edit forms completed by others.
    <?php
else :
    $value = booking_form_entries($booking_id, $form_id);

    if ($value) {
        echo form_hidden('entry_id', $value['entry_id']);
    }
    echo '<div class="form-group">';
    $this->formbuilder->build($field_ids, $value);
    echo '</div>';
endif;

$contents = ob_get_clean ();

$this->view ( 'partials/modal', array (
    'action' => 'backend/entry',
    'title' => $title,
    'form_classes' => array (),
    'hidden_fields' => array (
        'booking_id' => $booking_id,
        'form_id' => $form_id,
        'complete' => 'y'
    ),
    'contents' => $contents
) );
