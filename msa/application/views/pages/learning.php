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
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="panel panel-primary ">
                  <div class="panel-heading">
                    <button type="button" class="btn icon btn-transparent">
                        <i class="fa fa-refresh btn-icon" aria-hidden="true"></i></button>
                    <button type="button" class="btn icon  btn-transparent">
                        <i class="fa fa-bars btn-icon" aria-hidden="true"></i></button>
                    <input class=" btn-transparent btn" type="text" name="search" placeholder="جستجوی سفارش" style="width: calc(100% - 78px);">
                  </div>
                  <div class="panel-body">

                  </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
               <div class="panel panel-primary ">
                  <div class="panel-body ">
                    <div class="panel-body ">
                        <div class="card ">
                          <div class="card-block">
                            <h5 class="block-title" style="float: right;margin: 0px;">آموزش</h5>
                          </div>
                        </div>
                        <div class="card ">
                          <div class="card-block" >
                            <div id="post1" class="post panel-transparent">
                              <h6 class="post-header">
                                <a href="post1" >پست آموزشی 1</a>
                              </h6>
                              <p class="post-content">
                                MA  یک اندیکاتور تحلیل فنی است که با حذف noise از نمودار نوسانات قیمت باعث تسهیل فرآیند تحلیل وضعیت قیمت است. میانگین متحرک یک اندیکاتور دنبال کننده ی گرایش بازار است چرا که بر مبنای قیمت های پیشین عمل می کند. دو نوع اصلی میانگین متحرک شامل SMA یا میانگین ساده متحرک که ارزشی یکسان برای ارزش سهام در محاسبه میانگین در نظر میگیرد و EMA یا میانگین تشریحی متحرک که ارزشی بیشتر برای قیمت های جدید تر در نظر می گیرد، است. مهمترین کاربرد میانگین متحرک تعیین گرایش های بازار و سطح اقبال یا مقاومت به یک سهم است. آنها همچنین اساس بسیار دیگر از اندیکاتور ها هستند که در ادامه توضیح داده خواهند .
                              </p>
                            </div>
                            <div id="post2" class="post panel-transparent">
                              <h6 class="post-header">
                              <a href="post2" >پست آموزشی 2</a>
                              </h6>
                              <p class="post-content">
                                MA  یک اندیکاتور تحلیل فنی است که با حذف noise از نمودار نوسانات قیمت باعث تسهیل فرآیند تحلیل وضعیت قیمت است. میانگین متحرک یک اندیکاتور دنبال کننده ی گرایش بازار است چرا که بر مبنای قیمت های پیشین عمل می کند. دو نوع اصلی میانگین متحرک شامل SMA یا میانگین ساده متحرک که ارزشی یکسان برای ارزش سهام در محاسبه میانگین در نظر میگیرد EMA یا میانگین تشریحی متحرک که ارزشی ب .
                              </p>
                            </div>
                            <div id="post3" class="post panel-transparent">
                              <h6 class="post-header">
                                <a href="post3" >پست آموزشی 3</a>
                              </h6>
                              <p class="post-content">
                                MA  یک اندیکاتور تحلیل فنی است که با حذف noise از نمودار نوسانات قیمت باعث تسهیل فرآیند تحلیل وضعیت قیمت است. میانگین متحرک یک اندیکاتور دنبال کننده ی گرایش بازار است چرا که بر مبنای قیمت های پیشین عمل می کند. دو نوع اصلی میانگین متحرک شامل SMA یا میانگین ساده متحرک که ارزشی یکسان برای ارزش سهام در محاسبه میانگین در نظر میگیرد EMA یا میانگین تشریحی متحرک که ارزشی ب .
                              </p>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="panel panel-primary ">
                  <div class="panel-body">
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;"> فهرست اندیکاتور </h5>
                      </div>
                      <div class="card ">
                        <div class="card-block">
                             <div class="vertical-menu panel-transparent">
                                <a href="#post1" class="active">شاخص توده ای</a>
                                <a href="#post2">شاخص توان</a>
                                <a href="#post3">نوسان سنج چابکین</a>
                                <a href="#">شاخص مالی چابکین</a>
                                <a href="#">نوسان سنج تکانه قیمت در نقطه تصمیم</a>
                                <a href="#">گرایش سنج چنده</a>
                                <a href="#">شاخص حجم منفی</a>
                                <a href="#">میانگین متحرک</a>
                                <a href="#">نوارهای بولیدگر</a>
                                <a href="#">پهنای نوار</a>
                                <a href="#">تریکس</a>
                                <a href="#">آرون</a>
                                <a href="#">منحنی کایاک</a>
                                <a href="#">شاخص جهت دار</a>
                                <a href="#">نوسان سنج آرون</a>
                                <a href="#">شاخص آلسر</a>
                                <a href="#">نوسان سنج نهایی</a>
                                <a href="#">ورتکس</a>
                                <a href="#">شاخص جریان سرمایه</a>
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


