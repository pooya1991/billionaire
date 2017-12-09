<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
  <!-- Bootstrap core CSS -->
    <link href="<?=base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Plugin CSS -->
    <link href="<?=base_url();?>assets/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap-slider.css" />

    <!-- Custom styles for this template -->
    <link href="<?=base_url();?>assets/css/creative.min.css" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url();  ?>assets/jquery/jquery-3.2.1.min.js"></script>

    <script src="<?=base_url();?>assets/js/code/highstock.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap-datepicker.fa.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap-slider.js"></script>
     <!-- Bootstrap core JavaScript -->
    <script src="<?=base_url();?>assets/popper/popper.min.js"></script>
    <script src="<?=base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
   <script src="<?=base_url();?>assets/magnific-popup/jquery.magnific-popup.min.js"></script>


<style type="text/css">
.navbar{
    background: #1abc9c !important;
    border-color: #1abc9c !important;
    padding: 0px;
  }
  .h6, h6 {
    font-size: 0.9rem;
}
#wrapper, #page-wrapper ,body{
  background: #0f3045;

}

.navbar .menu *{
  color: #fff;
  text-align: right !important;

}
.navbar *{
  color: #fff;

}
.nav-link {
    
    vertical-align: middle;
    display: block;
    padding: 0px;
    padding-top: 10px;
}
.nav-link:hover, .nav-link:focus {
    color: #fff;

}
.top-nav > .open > .dropdown-menu {
    float: left;
    position: absolute;
    margin-top: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    background-color: #1abc9c;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: none !important;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.navbar-light .navbar-nav .nav-link,.navbar-light .navbar-nav .nav-link:hover {
    color: rgba(255,255,255,.7);
}
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: .5rem 0;
        padding-left: 0px;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #1abc9c;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem;
    direction: ltr;
    padding-left: 15px;
}
#mainNav .navbar-nav > li.nav-item > a.nav-link:hover {
    color: #FFF;
}

</style>
  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">        
        <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav menu" style="">

              <li class="nav-item hidden-xs" >
                <img src="<?=base_url();?>images/logow.png" style="width: 50px;padding-top: 5px;padding-bottom: 5px;">
              </li>
              <li class=" nav-item <?=($menu=='home') ? 'active' : "" ;?>">
                  <a class="nav-link js-scroll-trigger " href="<?=base_url();?>home"> <h6>نمایش زنده اطلاعات </h6></a>
              </li>
              <!-- <li class=" nav-item <?=($menu=='algorithm') ? 'active' : "" ;?>">
                  <a class="nav-link js-scroll-trigger " href="<?=base_url();?>algorithm"><h6> خرید و فروش الگوریتمیک </h6></a>
              </li> -->
              <!-- <li class=" nav-item <?=($menu=='strategy') ? 'active' : "" ;?>">
                  <a class="nav-link js-scroll-trigger " href="<?=base_url();?>strategy"> <h6>پیروی از استراتژی های موفق </h6></a>
              </li> -->
              <li class=" nav-item <?=($menu=='rebalanc') ? 'active' : "" ;?>">
                  <a class="nav-link js-scroll-trigger " href="<?=base_url();?>rebalancing"> <h6>سبدگردانی هوشمند</h6></a>
              </li>
              <li class=" nav-item <?=($menu=='learning') ? 'active' : "" ;?>">
                  <a class="nav-link js-scroll-trigger " href="<?=base_url();?>learning"><h6>آموزش </h6></a>
              </li>

          </ul>
          <ul class="navbar-nav " style="position: absolute;left: 0px;padding-left: 20px; top:12px;">
              <li class="dropdown " >
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="fa fa-user"></i> <?=(isset($displayname)) ? $displayname : ""; ?> <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                      <li>
                          <a href="<?=base_url('profile');?>"><i class="fa fa-fw fa-user"></i> پروفایل</a>
                      </li>
                      <li>
                          <a href="#"><i class="fa fa-fw fa-envelope"></i> پیام ها</a>
                      </li>
                      <li>
                          <a href="#"><i class="fa fa-fw fa-gear"></i> تنضیمات</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                          <a href="<?=base_url();?>signup/login/logout"><i class="fa fa-fw fa-power-off"></i> خروج</a>
                      </li>
                  </ul>
              </li>
            </ul>

        </div>
    </nav>

