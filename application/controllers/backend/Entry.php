<?php

/**
 * Created by IntelliJ IDEA.
 * User: marvin
 * Date: 27/05/2016
 * Time: 5:10 AM
 */
class Entry extends TF_Controller
{
    function index() {

        $this->load->dbforge();

        $booking_id = (int)$_REQUEST['booking_id'];
        $form_id = (int)$_REQUEST['form_id'];
        $entry_id = isset($_REQUEST['entry_id']) ? $_REQUEST['entry_id'] : 0;
        $complete = isset($_REQUEST['complete']) ? $_REQUEST['complete'] : false;
        $return = $this->input->get_post('return');

        $data = array(
            'entry_date' => now(),
            'booking_id' => $booking_id,
            'author_id' => get_current_user_id(),
        );

        $table_name = 'form_entries_' . $form_id;

        foreach ($_REQUEST as $field => $value) {
            if (strpos($field, 'field_id_') === 0) {
                if (!$this->db->field_exists($field, $table_name)) {
                    $this->dbforge->add_column($table_name, array(
                        $field => array('type' => 'text')
                    ), 'booking_id');
                }
                
                if (is_array($value) && $this->isAssoc($value))
				{
					$data[$field] = json_encode($value);
				}
				else {
                	$data[$field] = is_array($value) ? implode('|', $value) : $value;
                }
            }
        }

        if ($entry_id) {


            $this->db->update('booking_forms',
                array(
                    'submitted' => 'y',
                    'submitted_date' => now(),
                    'completed_by' => $complete ? $this->session->userdata('user_id') : 0,
                    'completed_date' => $complete ? now() : 0,
                ),
                sprintf('booking_id=%d AND form_id=%d', $booking_id, $form_id));

            $this->db->update($table_name, $data, array('entry_id' => $entry_id));


        }
        else {

            $this->db->update('booking_forms',
                array(
                    'submitted' => 'y',
                    'submitted_date' => now(),
                    'completed_by' => $complete ? $this->session->userdata('user_id') : 0,
                    'completed_date' => $complete ? now() : 0,
                ),
                sprintf('booking_id=%d AND form_id=%d', $booking_id, $form_id));
            
            $this->db->insert($table_name, $data);
        }

        $this->db->select('notify_user_on_submit');
        $query = $this->db->get_where('booking_forms', sprintf('booking_id=%d AND form_id=%d', $booking_id, $form_id));
        $result = $query->row_array();
        if ($result['notify_user_on_submit']) {
            $notify_users = unserialize($result['notify_user_on_submit']);

            if ($notify_users) {
                if (!is_array($notify_users)) $notify_users = array($notify_users);

                $notify_users = get_users($notify_users);

                $to = array();
                $subject = 'Form Submitted';
                $message = 'Form Submitted';
                if ($notify_users) {
                    foreach ($notify_users as $user) {

                        if ($user['email']) $to[] = $user['email'];

                        $this->db->insert('messages', array(
                            'message' => $subject,
                            'receiver' => $user['contact_id'],
                            'date_sent' => date('c', now()),
                            'sender' => get_current_user_id(),
                        ));

                    }


                    $this->load->library('email');
                    $this->email->from($this->session->userdata('email'), $this->session->userdata('screen_name'));
                    $this->email->to($to);
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->email->send();
                }
            }
        }
        
        if ($this->input->is_ajax_request()) {
			$this->output->set_content_type('application/json');
            echo json_encode(array('message' => 'Saved.'));
            die();
        }
        
		$this->session->set_flashdata('message', 'Thank you for filling out your information!');
        
        redirect($return);
    }
    
    function isAssoc(array $arr)
	{
	    if (array() === $arr) return false;
	    return array_keys($arr) !== range(0, count($arr) - 1);
	}

    function complete() {
        var_dump($complete);
    }
}