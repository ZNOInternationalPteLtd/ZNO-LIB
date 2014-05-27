<?php
/**************************
 * File name: left_menu.php / include left sidebar/menu
 * Added by :Britta Alex
 * Modified by:
 * Date:27-05-2014
 * Version:1.0
 **************************/
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <ul class="page-sidebar-menu" data-auto-scroll="false" data-auto-speed="200">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
                                
                                <li class="start ">
					<a href="index.php">
					<i class="fa fa-home"></i>
					<span class="title">Dashboard</span>
					</a>
				</li>
                                <li>
					<a href="javascript:;">
					<i class="fa fa-shopping-cart"></i>
					<span class="title">Manage Users</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="user_list.php?type=2">
							<i class="fa fa-bullhorn"></i>
							Technicians</a>
						</li>
						<li>
							<a href="user_list.php?type=1">
							<i class="fa fa-shopping-cart"></i>
							Admin</a>
						</li>
						<li>
                                                    <a href="customer_list.php">
							<i class="fa fa-tags"></i>
							Customers</a>
						</li>
						
					</ul>
				</li>
                    </ul>
                </div>
</div>