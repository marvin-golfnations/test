<?php

class FormBuilder
{
    var $TF;

    public function __construct(){
        $this->TF =& get_instance();
    }

    public function build($fields, $values) {
        if ($fields === '') {
            //nothing to build.
            return;
        }

        $fields = explode('|', $fields);

        $this->TF->db->select('fields.*');
        $this->TF->db->join('form_fields', 'form_fields.field_id=fields.field_id');
        $this->TF->db->where_in('fields.field_id', $fields);
        if ($this->TF->session->userdata('group_id') === 5) {
            $this->TF->db->where('guest_only', 'y');
        }
        $this->TF->db->order_by('FIELD (tf_fields.field_id, '.implode(', ', $fields).')');
        $query = $this->TF->db->get('fields');

        foreach ($query->result_array() as $row) {
            $func = '_build_'.$row['field_type'];
            $settings = unserialize($row['settings']);

            $value = isset($values['field_id_'.$row['field_id']]) ? $values['field_id_'.$row['field_id']] : '';

            if ($row['field_type'] === 'checkboxes') {
                $value = explode('|', $value);
            }
            
            
            
            echo '<div class="form-group clearfix">';

            $this->_build_title($row['field_label']);
            
            echo '<div class="col-lg-6 col-sm-5">';
            $this->$func($row['field_id'], $settings[$row['field_type']], $value, $row['required']);
            echo '</div>';

            echo '</div>';
//            echo '<div class="line line-dashed b-b line-lg pull-in"></div>';
        }
    }
    
    private function _build_datatable($field_id, $options, $selected, $required) {
		$options = explode("\n", $options);
		
		$selected = json_decode($selected, true);
		
		$new_td = '';
		$td = '';
		$field_id = 'field_id_'.$field_id;
		echo '<table class="table table-bordered table-hover" id="'.$field_id.'">';
		echo '<thead>';
		echo '<tr>';
		foreach ($options as $option) {
			echo '<th>'.$option.'</th>';	
			
			$url_title = strtolower(url_title($option));
		}
		
		if ($selected) {		
			$header = array_keys($selected);
			$values = array_values($selected);
			
			$item_count = count($values[0]);
			
			for($i=0; $i<$item_count; $i++) {
				$td .= '<tr>';
				for ($y=0; $y<count($header); $y++) {
					$val = $selected[$header[$y]][$i];
					$td .= '<td><input value="'.$val.'" name="'.$field_id.'['.$header[$y].'][]" type="text" class="form-control input-md"></td></td>';
				}
				$td .= '<td><a href="#" class="'.$field_id.'-delete_row">Delete</a></td>';
				$td .= '</tr>';
			}
		}
		
		echo '<th>&nbsp;</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		echo $td;
		echo '</tbody>';
		echo '</table>';
		echo '<a id="'.$field_id.'-add_row" class="pull-left">Add Row</a>';
		?>
		<script>
			$(document).ready(function(){
			    var i=1;
			    var table = $('#<?php echo $field_id?>');
			    
			    $("#<?php echo $field_id;?>-add_row").click(function(){
				    table.find('tbody').append('<?php echo stripslashes($new_td);?>');
				    table.find('tbody').find('a.<?php echo $field_id?>-delete_row').on('click', function(){
					    $(this).parents('tr').remove();
				    });
			      i++; 
				});
				
				table.find('tbody').append('<?php echo stripslashes($new_td);?>');
				table.find('tbody').find('a.<?php echo $field_id?>-delete_row').on('click', function(){
				    $(this).parents('tr').remove();
			    });
			});
		</script>
		<?php
    }

    private function _build_checkboxes($field_id, $options, $selected, $required) {

        $options = explode("\n", $options);
        $class = '';
        if ($required) {
            $class = 'field_id_'.$field_id.'-group';
        }

?>
        <?php foreach ($options as $i => $option) : ?>
        <div class="checkbox">
			<label for="field_id_<?php echo $field_id.'_'.$i;?>">
				<?php echo form_checkbox('field_id_'.$field_id.'[]', trim($option), in_array(trim($option), $selected), array('id' => 'field_id_'.$field_id.'_'.$i, 'class' => $class)); ?>
				<?php echo trim($option);?>
			</label>
        </div>
        <?php endforeach ;?>
<?php
    }

	private function _build_radiobuttons($field_id, $options, $selected, $required) {

		$options = explode("\n", $options);
		$class = '';
		if ($required) {
			$class = 'field_id_'.$field_id.'-group';
		}
		?>
		<?php foreach ($options as $i => $option) : ?>
			<div class="radio">
				<label for="field_id_<?php echo $field_id.'_'.$i;?>">
				<?php echo form_radio('field_id_'.$field_id.'[]', $i, $i === (int)$selected, array('id' => 'field_id_'.$field_id.'_'.$i, 'class' => $class)); ?>
				<?php echo trim($option);?>
				</label>
			</div>
		<?php endforeach ;?>
		<?php
	}

    private function _build_text($field_id, $options, $value, $required) {
        echo form_input('field_id_'.$field_id, $value, array('class' => 'form-control' . ($required === 'y' ? ' required' : '')));
    }

    private function _build_dropdown($field_id, $options, $selected, $required) {
	    $options = explode("\n", $options);
	    echo form_dropdown($field_id, $options, $selected, array('class' => 'form-control' . ($required === 'y' ? ' required' : '')));
    }

    private function _build_title($title) {
        if ($title):
        echo '<label class="col-lg-6 col-sm-7 control-label"><b>'.$title.'</b></label>';
        endif;
    }
}