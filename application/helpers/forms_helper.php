<?php

function forms_entries($form_id) {
    $TF = get_instance();
    return $TF->db->count_all('form_entries_'.$form_id);
}