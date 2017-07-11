<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#service-privileges" aria-expanded="false" aria-controls="service-privileges">
                Services/Treatment Privileges
            </a>
        </h4>
    </div>
    <div id="service-privileges" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <table width="100%">
                <tr>
                    <td width="50%">Can delete services/treatments?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_delete_services', 'y', $group['can_delete_services'] == 'y', 'id="can_delete_services_y"'); ?>
                            <label for="can_delete_services_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_delete_services', 'n', $group['can_delete_services'] == 'n', 'id="can_delete_services_n"'); ?>
                            <label for="can_delete_services_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can edit services/treatments?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_edit_services', 'y', $group['can_edit_services'] == 'y', 'id="can_edit_services_y"'); ?>
                            <label for="can_edit_services_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_edit_services', 'n', $group['can_edit_services'] == 'n', 'id="can_edit_services_n"'); ?>
                            <label for="can_edit_services_n"> No </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>