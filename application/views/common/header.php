<!-- Header
        ============================================= -->
        <header id="header" class="transparent-header2">
<?php
$return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
?>
            <div id="header-wrap">

                <div class="container clearfix">

                    <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                    <!-- Logo
                    ============================================= -->
                    <div id="logo" class="nobottomborder"><a href="default.aspx"><img src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/images/logov2.png" alt="The Farm Logo"></a></div>

                    <!-- Primary Navigation
                    ============================================= -->
                    <nav id="primary-menu" class="serif normal">
                        <ul>
                            <li <?php if ($this->uri->segment(1) === ''):;?>class="current"<?php endif;?>><a href="/"><div>Home</div></a></li>
                            
                            <?php if ($this->session->userdata('group_id') === 5) : ?>
                            <li <?php if ($this->uri->segment(1) === 'calendar'):;?>class="current"<?php endif;?>><a href="/calendar"><div>Schedule</div></a></li>
                            <li <?php if ($this->uri->segment(1) === 'medical'):;?>class="current"<?php endif;?>><a href="<?php echo site_url('medical');?>"><div>Holistic Sanctuary</div></a></li>
                            <li <?php if ($this->uri->segment(1) === 'spa'):;?>class="current"<?php endif;?>><a href="<?php echo site_url('spa');?>"><div>Aqua Sanctuary</div></a></li>
							<?php endif; ?>
                        </ul>
                    </nav><!-- #primary-menu end -->
                </div>

       	  </div>

        </header>