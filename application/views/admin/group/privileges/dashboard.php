<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#dashbaord" aria-expanded="false" aria-controls="collapseTwo">
                Dashboard
            </a>
        </h4>
    </div>
    <div id="dashbaord" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <table width="100%" cellpadding="5">
                <tr>
                    <td width="50%">Top Section</td>
                    <td width="50%">
                        <?php echo form_multiselect('dashboard_top[]', $widgets, $group['dashboard_top'],'class="form-control multiselect"');?>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Middle Section</td>
                    <td width="50%">
                        <?php echo form_multiselect('dashboard_middle[]', $widgets, $group['dashboard_middle'],'class="form-control multiselect"');?>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Bottom Section</td>
                    <td width="50%">
                        <?php echo form_multiselect('dashboard_bottom[]', $widgets, $group['dashboard_bottom'],'class="form-control multiselect"');?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>