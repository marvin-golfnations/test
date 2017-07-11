<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#form-access" aria-expanded="false" aria-controls="form-access">
                Form Access
            </a>
        </h4>
    </div>
    <div id="form-access" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <table width="100%">
                
                <?php foreach ($all_forms as $form) :?>
                <tr>
                    <td width="50%">Can access <?php echo strtoupper($form['form_name']);?>?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('forms['.$form['form_id'].']', 'y', in_array($form['form_id'], $group['forms']), 'id="form_y_'.$form['form_id'].'"'); ?>
                            <label for="form_y_<?php echo $form['form_id'];?>"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('forms['.$form['form_id'].']', 'n', !in_array($form['form_id'], $group['forms']), 'id="form_n_'.$form['form_id'].'"'); ?>
                            <label for="form_n_<?php echo $form['form_id'];?>"> No </label>
                        </div>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>