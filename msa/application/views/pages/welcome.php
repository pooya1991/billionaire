<?php
defined('BASEPATH') OR exit('No divect script access allowed');
?>
<style type="text/css">


.vertical-menu a {
   
    color: #fff; /* Black text color */
    display: block; /* Make the links appear below each other */
    padding: 12px; /* Add some padding */
    text-decoration: none; /* Remove underline from links */
    font-size: 0.8em;
    line-height: 0.9em !important;
}
.vertical-menu ,.post {
   
    border-radius: 15px;
    border:1px solid #fff;

}
.post{
  padding: 15px;
  margin-bottom: 10px;
}
.post a{
  color: #fff;
}
.post p{
  margin-right: 50px;
  font-size: 0.9em;
}

.vertical-menu a:hover {
    text-decoration: underline; /* Dark grey background on mouse-over */
}

.vertical-menu a.active {
    display: list-item;
list-style: inside;
list-style-type: square;
list-style-position: inside;
}
</style>
<div id="page-wrapper" style="padding-top: 55px;">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
               <div class="panel panel-primary ">
                  <div class="panel-body ">
                    <div class="panel-body ">
                        <div class="card ">
                          <div class="card-block">
                            <h5 class="block-title" style="float: right;margin: 0px;">فعالسازی حساب</h5>
                          </div>
                        </div>
                        <div class="card ">
                          <div class="card-block" >
                            <div class="post">
                              <h6> دسترسی شما به پنل قبل از فعال سازی حساب کاربری امکان پذیر نمی باشد.
                              لطفا برای فعال کردن حساب خود ایمیل ارسال شده از سوی بیلیونر را مطالعه فرمایید. </h6>
                              <a href="<?=base_url();?>signup/login/logout"> خروج</a>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>

          </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>



<!-- /#page-wrapper -->


