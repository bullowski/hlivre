<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>HyperLivre<?php echo isset($title) ? ' - ' . $title : null; ?></title>
        <?php echo Asset::css(array('screen.css')); ?>
    </head>
    <body <?php echo isset($page_id) ? 'id="' . $page_id . '"' : ''; ?>>
        <div class="header">
            <!-- Menu -->
            <ul class="menu">
                <?php if (Auth::check()): ?>
                    <li><?php echo Html::anchor('notes', 'My Notes'); ?></li>
                    <li><?php echo Html::anchor('concepts', 'My Concepts'); ?></li>
                    <li><?php echo Html::anchor('home/logout', 'Logout'); ?></li>
                <?php else: ?>
                    <li><div class="wrap"><?php echo Html::anchor('home/login', 'Login'); ?></div></li>
                    <li><div class="wrap"><?php echo Html::anchor('home/signup', 'Sign Up'); ?></div></li>
                <?php endif; ?>
            </ul>
            
            <div class="logo">
                <?php echo Asset::img(array('logo.gif')); ?>
            </div>
        </div>

        <div class="content">
            
            <div id="main">
                <!-- Messages -->
                <?php if (Session::get_flash('success') or Session::get_flash('notice') or Session::get_flash('error')): ?>
                    <div class="messages">
                        <?php if (Session::get_flash('success')): ?>
                            <div class="message success"><?php echo Session::get_flash('success'); ?></div>
                        <?php elseif (Session::get_flash('notice')): ?>
                            <div class="message notice"><?php echo Session::get_flash('notice'); ?></div>
                        <?php elseif (Session::get_flash('warning')): ?>
                            <div class="message warning"><?php echo Session::get_flash('warning'); ?></div>
                        <?php elseif (Session::get_flash('error')): ?>
                            <div class="message error"><?php echo Session::get_flash('error'); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Test acl message -->
                <?php
                   /* 
                    $user_groups = Auth::get_groups();
                    if ($user_groups && Auth::acl()->has_access(array('comments', array('read')), $user_groups[0])) {
                        echo '<div class="message success">Successfully authenticated as an user.</div>';
                    } else {
                        echo '<div class="message notice">Please log-in.</div>';
                    }
                    
                    */
                ?>
                
                
                    
                <!-- Main content -->
                <?php echo $content; ?>
            </div>

            <!-- Sidebar -->
            <div id="sidebar">
                <p>lorem ipsum</p>
            </div>
            
        </div>

        <div class="footer">
            <div class="copyright">
				Made possible with <a href="http://fuelphp.com/">FuelPHP</a>
                <br/>
				Developed by Alex Bulla &amp; Michael Gumowski.
            </div>
            <div class="stats">Page renedered in {exec_time}s &middot; Memory Usage {mem_usage}MB</div>
        </div>

    </body>
</html>