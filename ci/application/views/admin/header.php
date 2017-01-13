<!DOCTYPE html>
<html>
<head>
<style>
a i {
	padding-right:5px;
}
</style>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Dashboard</title>
<!-- BOOTSTRAP STYLES-->

<link href="<?php echo base_url('assets/css/bootstrap.css');?>" rel="stylesheet">
<!-- FONTAWESOME STYLES-->
<link href="<?php echo base_url('assets/css/font-awesome.css');?>" rel="stylesheet" />
<!-- CUSTOM STYLES-->
<link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/wickedpicker.css');?>" rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<?php if(isset($map['js'])):?>
<?php echo $map['js']; endif;?>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyD6GBSvL22a1DG-BBFkp_rkx1fmNb0T62c&sensor=true_OR_false"></script>
<script src="<?php echo base_url('assets/js/jquery-1.10.2.js');?>"></script>
</head>
<body>
<div id="wrapper">
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="adjust-nav">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <span class="logout-spn" > <a href="<?php echo site_url('admin/adminlogout'); ?>"><img src="<?php echo site_url('assets/img/logout_icon.png'); ?>" title="Logout"  style="width:40px; height:40px;"></a> </span> </div>
</div>
<!-- /. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation"> <a class="navbar-brand" href="<?php echo site_url('admin');?>"> <img src="<?php echo site_url('assets/img/logo.png'); ?>" width="150" /> </a>
  <div class="sidebar-collapse">
    <ul class="nav" id="main-menu">
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Employee</a>
        <?php $display=isset($activeurl)?($activeurl=="user" || $activeurl=="displayusers" ? "block" :"none"):'none';?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="user"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/adduser'); ?>" ><i class="fa fa-edit "></i>Add Employee</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="displayusers"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/displayusers'); ?>" ><i class="fa fa-edit "></i>Employee List </a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>7-Eleven Runs</a>
        <?php $display=isset($activeurl)?($activeurl=="addrole" || $activeurl=="displayrole" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="addrole"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/addrole'); ?>"><i class="fa fa-edit "></i>Add 7-Eleven Run </a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="displayrole"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/displayrole'); ?>"><i class="fa fa-edit "></i>7-Eleven Run List </a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Clients</a>
        <?php $display=isset($activeurl)?($activeurl=="addcompany" || $activeurl=="displaycompany" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="addcompany"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/addcompany'); ?>"><i class="fa fa-edit"></i>Add Client</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="displaycompany"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/displaycompany'); ?>"><i class="fa fa-edit "></i> Clients List</a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Fleets/Trucks</a>
        <?php $display=isset($activeurl)?($activeurl=="addtruck" || $activeurl=="displaytruck" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="addtruck"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/addtruck'); ?>"><i class="fa fa-edit"></i>Add Fleet</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="displaytruck"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/displaytruck'); ?>"><i class="fa fa-edit "></i>Fleet/Truck List</a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Fleet/Truck Roles</a>
        <?php $display=isset($activeurl)?($activeurl=="truckrole" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="truckrole"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/truckrole'); ?>"><i class="fa fa-edit"></i>Add/View Roles</a> </li>
        </ul>
      </li>
      
      <!--	  <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Add Hourly Amount</a>
        <?php //$display=isset($activeurl)?($activeurl=="addamount" || $activeurl=="displayamount" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php //echo $display;?>">
          <li class="<?php //echo (isset($activeurl)?($activeurl=="addamount"?"active-link":""):"");?>"> <a href="<?php //echo site_url('admin/addhourlyprice'); ?>"><i class="fa fa-edit"></i>Add hourly amount</a> </li>
          <li class="<?php //echo (isset($activeurl)?($activeurl=="displayamount"?"active-link":""):"");?>"> <a href="<?php //echo site_url('admin/displayhourlyamount'); ?>"><i class="fa fa-edit "></i> Display hourly amount</a> </li>
        </ul>
      </li>-->
      
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Jobs For Driver</a>
        <?php $display=isset($activeurl)?($activeurl=="driverassign" || $activeurl=="displaydriverassign" || $activeurl=="hourlyjobassign" || $activeurl=="displayhourlyjob" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="driverassign"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/driverassign'); ?>"><i class="fa fa-edit"></i>Assign 7-Eleven NSW Job</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="displaydriverassign"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/displaydriverassign'); ?>"><i class="fa fa-edit "></i>7-Eleven NSW Job List </a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="hourlyjobassign"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/hourlyjobassign'); ?>"><i class="fa fa-edit"></i>Assign Swire NSW Job</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="displayhourlyjob"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/displayhourlyjob'); ?>"><i class="fa fa-edit"></i>Swire NSW Job List</a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Jobs For Helper</a>
        <?php $display=isset($activeurl)?($activeurl=="helperassign" || $activeurl=="displayhelperassign" || $activeurl=="helperhourlyjobassign"|| $activeurl=="helperdisplayhourlyjob" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="helperassign"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/helperassign'); ?>"><i class="fa fa-edit"></i>Assign 7-Eleven NSW Job</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="displayhelperassign"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/displayhelperassign'); ?>"><i class="fa fa-edit "></i>7-Eleven NSW Job List </a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="helperhourlyjobassign"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/helperhourlyjobassign'); ?>"><i class="fa fa-edit"></i>Assign Swire Job</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="helperdisplayhourlyjob"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/helperdisplayhourlyjob'); ?>"><i class="fa fa-edit"></i>Swire NSW Job List </a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Weekly Roaster</a>
        <?php $display=isset($activeurl)?($activeurl=="weeklyassign" || $activeurl=="weeklyfixedamount" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="weeklyassign"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/weeklyassign'); ?>"><i class="fa fa-table "></i>&nbsp;7-Eleven Jobs Roaster</a> </li>
          
          <!--<li class="<?php //echo (isset($activeurl)?($activeurl=="weeklyassign"?"active-link":""):"");?>"> <a href="<?php //echo site_url('admin/weeklyassign'); ?>"><i class="fa fa-table "></i>&nbsp;Swire Jobs Roaster</a> </li>--> 
          
          <!--<li class="<?php //echo (isset($activeurl)?($activeurl=="weeklyfixedamount"?"active-link":""):"");?>">
                        <a href="<?php //echo site_url('admin/weeklyfixedamount'); ?>"><i class="fa fa-table "></i>&nbsp;Display users amount of current week </a>
                    </li>					-->
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Current Jobs</a>
        <?php $display=isset($activeurl)?($activeurl=="workingtask" || $activeurl=="hourlyworkingtask" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="workingtask"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/workingtask'); ?>"><i class="fa fa-table "></i>&nbsp;Current 7-Eleven Jobs</a> </li>
          <li class="<?php echo (isset($activeurl)?($activeurl=="hourlyworkingtask"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/hourlyworkingtask'); ?>"><i class="fa fa-table "></i>&nbsp;Current Swire Jobs</a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>E-Payforms</a>
        <?php $display=isset($activeurl)?($activeurl=="deliveryfixedamount" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="deliveryfixedamount"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/weeklyfixedamount'); ?>"><i class="fa fa-table "></i>&nbsp;View e-Payform List</a> </li>
        </ul>
      </li>
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Support</a>
        <?php $display=isset($activeurl)?($activeurl=="displaytruckinfo" ? "block" :"none"):"none";?>
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="displaytruckinfo"?"active-link":""):"");?>"> <a href="<?php echo site_url('admin/truckinfo'); ?>"><i class="fa fa-table "></i>&nbsp;7-Eleven Support</a> </li>
        </ul>
      </li>
      
      
      
      <li> <a href="javascript:void(0);" class="dump"><i class="fa fa-desktop"></i>Truck Feedbacks</a>
       
        <ul class="hide_penal" style="display:<?php echo $display;?>">
          <li class="<?php echo (isset($activeurl)?($activeurl=="displaytruckinfo"?"active-link":""):"");?>"> 
          <a href="<?php echo site_url('admin/trcukcomplaints'); ?>"><i class="fa fa-table "></i>&nbsp;Trucks Complaints</a> </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<br/>
