<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <?php $this->load->view('admin/_common/head', array('title' => 'Users')); ?>
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
	                        <nav class="navbar navbar-default">
		                        <div class="container-fluid">
			                        
			                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				                        
				                        <ul class="nav navbar-nav">
									        <li class="dropdown">
									          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										          
										          <?php echo $group_name?> <span class="caret"></span></a>
									          <ul class="dropdown-menu">
									            <li><a href="<?php echo site_url('backend/account/edit/'); ?>"><i class="fa fa-plus"></i> Add</a></li>
									          </ul>
									        </li>
									      </ul>
									      
			                        </div>
		                        </div>
		                        
	                        </nav>

<div class="container-fluid ">

    <div id="main">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr class="text-uppercase">
                    <th class="text-center">Date Joined</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Services</th>
                    <th class="text-center">Action</th>
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
                            <?php echo anchor('backend/account/edit/' . $row['contact_id'], $row['first_name'] . ' ' . $row['last_name'], 'class="text-regular"'); ?>
                           </td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td>
                            <?php if (isset($row['services'])) : ?>
                                <?php foreach ($row['services'] as $service_id => $service) : ?>
                                    <div class="container-fluid"><span class="label label-primary"><?php echo $service;?> <a data-toggle="modal" data-target="#modal-popup" style="color:#fff;" href="<?php echo site_url('backend/service/delete_user/'.$row['contact_id'].'/'.$service_id);?>"><i class="fa fa-close"></i></a> </span></div>
                                <?php endforeach ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo site_url('backend/account/edit/' . $row['contact_id']); ?>"
                               class="btn btn-xs btn-icon btn-primary"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo site_url('backend/account/delete/' . $row['contact_id']); ?>" class="btn btn-xs btn-icon btn-default btn-confirm" title="Are you sure you want to delete this person?"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach ?>
                </tbody>
            </table>
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