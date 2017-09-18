<!DOCTYPE html>
<html lang="en">
    <head>
        <title>onRamp</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/images/onRamp.jpg')?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">    
        <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css')?>">
        <script src="//cdn.ckeditor.com/4.7.2/standard/ckeditor.js"></script>
       
  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
    <body>
    <header>
        <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo base_url();?>admin/projects">onRamp</a>
    </div>
    <ul class="nav navbar-nav">
        <?php if($this->session->has_userdata("loggedIn")):?>


      <li class="active"><a href="<?php echo base_url();?>admin/projects/create">Create Projects</a></li>
            <li class="active"><a href="<?php echo base_url();?>admin/category/create">Create Catergory</a></li>

                 <li><a href="<?php echo base_url();?>admin/projects">View Projects</a></li>
      <li><a href="<?php echo base_url();?>admin/students">View Students</a></li>
      <li><a href="<?php echo base_url();?>admin/submissions">View Submissions</a></li>
      <!-- <li class="active"><a href="<?php echo base_url();?>admin/category/create">Create Catergory</a></li> -->
      <?php endif ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <?php if(!$this->session->has_userdata("loggedIn")):?>
      <li><a href="<?php echo base_url();?>admin/register"><span class="glyphicon glyphicon-user"></span> Register</a></li>
      <li><a href="<?php echo base_url();?>admin/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      <?php else: ?>
        <li><a href="<?php echo base_url();?>admin/logout">Log Out</a></li>

      <?php endif?>
    </ul>
  </div>
</nav>
    </header>
    
    <div class="container-fluid">
    <!-- <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li style="padding: 10px 0 0;">
                        <a href="index.html" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i><span class="hide-menu">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="profile.html" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i><span class="hide-menu">Profile</span></a>
                    </li>
                    <li>
                        <a href="basic-table.html" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">Basic Table</span></a>
                    </li>
                    <li>
                        <a href="fontawesome.html" class="waves-effect"><i class="fa fa-font fa-fw" aria-hidden="true"></i><span class="hide-menu">Icons</span></a>
                    </li>
                    <li>
                        <a href="map-google.html" class="waves-effect"><i class="fa fa-globe fa-fw" aria-hidden="true"></i><span class="hide-menu">Google Map</span></a>
                    </li>
                    <li>
                        <a href="blank.html" class="waves-effect"><i class="fa fa-columns fa-fw" aria-hidden="true"></i><span class="hide-menu">Blank Page</span></a>
                    </li>
                    <li>
                        <a href="404.html" class="waves-effect"><i class="fa fa-info-circle fa-fw" aria-hidden="true"></i><span class="hide-menu">Error 404</span></a>
                    </li>
                </ul>
                <div class="center p-20">
                    <span class="hide-menu"><a href="http://wrappixel.com/templates/pixeladmin/" target="_blank" class="btn btn-danger btn-block btn-rounded waves-effect waves-light">Upgrade to Pro</a></span>
                </div>
            </div>
        </div> -->
        <div class="container">
    
    

