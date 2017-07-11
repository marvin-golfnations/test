<?php
$return = urlencode($_SERVER["REQUEST_URI"]);
$qstr = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
$qstr = $qstr ? $qstr.'&return='.$return : '?return=' . $return;
?>
							<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <?php $this->load->view('admin/_common/head', array('title' => 'Contacts')); ?>
</head>
<body class="" >
<section class="vbox">
    <?php $this->load->view('admin/_common/header'); ?>
    <section>
        <section class="hbox stretch">
            <section id="content">
                <section class="vbox">
                    <section class="scrollable bg-white">
                        <div class="content">
	                        
	                        <?php $this->load->view('admin/_common/search_bar', array('title' => ucfirst($view), 'qstr' => $qstr)); ?>
    
                            <div class="container-fluid ">
                            <div id="main">
                                <?php if ($pagination_links) : ?>
                                    <div class="text-center">
                                    <?php echo $pagination_links;?>
                                    </div>
                                <?php endif; ?>
                                        
                                <div class="table-responsive"> 
                                    
                                    <table class="table">
                                        <thead>
                                        <tr class="text-uppercase">
                                            <th class="text-center">Date Joined</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Group</th>
                                            <?php if ($view === 'Guest') : ?>
                                            <th class="text-center">Booking</th>
                                            <?php endif; ?>
                                            <th class="text-center">Verified?</th>
                                            <th class="text-center">Active?</th>
                                            <th class="text-center">Approved?</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($contacts as $row) : ?>
                                            <tr class="contacts" id="contact-<?php echo $row['contact_id'];?>">
                                                <td class="text-muted text-uppercase text-center">
                                                    <?php if ($row['date_joined'] !== '0000-00-00'): ?>
                                                    <?php echo date('m/d/Y', strtotime($row['date_joined'])) ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo anchor('backend/account/edit/' . $row['contact_id'].$qstr, $row['first_name'] . ' ' . $row['last_name'], 'class="text-regular"'); ?>
                                                   </td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['group_name']; ?></td>
                                                <?php if ($view === 'Guest') : ?>
                                                <td class="text-center">
                                                    <?php if (isset($row['recent_booking']) && $row['recent_booking']) : ?>
                                                        <a href="<?php echo site_url('backend/account/edit/'.$row['contact_id'].'/'.$row['recent_booking']).$qstr;?>" class="btn btn-xs"><i class="md md-schedule"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
                                                
                                                
                                                <td class="text-center">
	                                                <?php form_toggle_button('btn-verify', $row['contact_id'], array('Yes', 'No'), $row['verified']);?>
                                                </td>
                                                
                                                <td class="text-center">
	                                                <?php form_toggle_button('btn-active', $row['contact_id'], array('Yes', 'No'), $row['active']);?>
                                                </td>
                                                
                                                <td class="text-center">
	                                                <?php form_toggle_button('btn-approve', $row['contact_id'], array('Yes', 'No'), $row['approved']);?>
                                                </td>
                                                
                                                <td class="text-right">
                                                    
                                                    <a href="<?php echo site_url('backend/account/edit/' . $row['contact_id']).$qstr; ?>"
                                                       class="btn btn-xs btn-icon btn-primary"><i class="fa fa-pencil"></i></a>
                        
                                                    <a href="<?php echo site_url('backend/account/delete/' . $row['contact_id']); ?>" class="btn btn-xs btn-icon btn-default btn-confirm" title="Are you sure you want to delete <b><?php echo $row['first_name'] . ' ' . $row['last_name'];?></b>?"><i class="fa fa-trash-o"></i></a>
                                                    
                                                    
                                                    
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
    
                                <?php if ($pagination_links) : ?>
                                    <div class="text-center">
                                        <?php echo $pagination_links;?>
                                    </div>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>

<?php $this->view('admin/_common/footer_js'); ?>


</body>
</html>