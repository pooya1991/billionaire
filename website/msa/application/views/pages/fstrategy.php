<?php
defined('BASEPATH') OR exit('No divect script access allowed');
?>
<style type="text/css">
.follow img{
  margin-left: 10px;
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
            <div class="col-lg-5 col-md-5 col-sm-12">
               <div class="panel panel-primary ">
                  <div class="panel-heading">
                    
                    
                  </div>
                  <div class="panel-body ">
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;">برترین معامله گران</h5>
                        <input class=" btn-transparent btn" type="text" name="search" placeholder="جستجوی کاربر" style="width: calc(100% - 180px);">
                      </div>
                    </div>
                    <div class="card panel-transparent">
                      <div class="card-block">
                        <div class="table-responsive no-border ">
                          <table class="table ranguser table-hover" style="direction: rtl;">
                            <thead>
                                <th>رتبه</th>
                                <th>کاربر</th>
                                <th></th>
                                <th>بازگشت سرمایه</th>
                                <th>تعداد معامله</th>
                                <th>هفته</th>
                                <th>بهترین معامله</th>
                                <th>بدترین معامله</th>
                                <th>درصد موفقیت</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr onclick="userinfobox(1)">
                                    <td>1</td>
                                    <td> <img  src="<?=base_url();?>images/user-p.png" class="img-circle" alt="" width="30" height="30"> </td>
                                    <td><span  class="text-primary"> hooman.q </span></td>
                                    <td> <span  class="btn-primary btn"> 330% </span></td>
                                    <td> <span class="btn-primary btn"> 72 </span></td>
                                    <td> <span class="btn-primary btn"> 423 </span></td>
                                    <td> <span class="btn-primary btn"> 1352 </span></td>
                                    <td> <span class="btn-primary btn"> -252.5 </span></td>
                                    <td> <span class="btn-primary btn"> 60% </span></td>
                                    <td class="follow"> <img src="<?=base_url();?>images/addeduser.png" class="img-circle" alt="" width="20" height="20"> </td>
                                </tr>
                                <tr onclick="userinfobox(2)">
                                    <td>2</td>
                                    <td> <img  src="<?=base_url();?>images/defaultm.png" class="img-circle" alt="" width="30" height="30"> </td>
                                    <td><span > hooman.q </span></td>
                                    <td> <span class="btn-default btn"> 330% </span></td>
                                    <td> <span class="btn-default btn"> 72 </span></td>
                                    <td> <span class="btn-default btn"> 423 </span></td>
                                    <td> <span class="btn-default btn"> 1352 </span></td>
                                    <td> <span class="btn-default btn"> -252.5 </span></td>
                                    <td> <span class="btn-default btn"> 60% </span></td>
                                    <td class="follow"> <img src="<?=base_url();?>images/adduser.png" class="img-circle" alt="" width="20" height="20"> </td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                     
                    <div class="panel-body ">
                        <div class="card ">
                          <div class="card-block">
                            <h5 class="block-title" style="float: right;margin: 0px;">دعوت از دوستان</h5>
                          </div>
                        </div>
                        <div class="card panel-transparent">
                          <div class="card-block" >
                            <div class="" style="padding: 20px; text-align: center;">
                                <h6>ارسال لینک عضویت:</h6>
                                <a style="padding: 5px;" href=""><i class="fa fa-linkedin fa-2x" aria-hidden="true"></i></a>
                                <a style="padding: 5px;" href=""><i class="fa fa-telegram fa-2x" aria-hidden="true"></i></a>
                                <a style="padding: 5px;" href=""><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
                                <a style="padding: 5px;" href=""><i class="fa fa-link fa-2x" aria-hidden="true"></i></a>
                            </div>
                          </div>
                        </div>
                    </div>

                    
                  </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="panel panel-primary ">
                  <div class="panel-heading">
                                    
                  </div>
                  <div class="panel-body">
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;"> آخرین معاملات </h5>
                        <input class=" btn-transparent btn" type="text" name="search" placeholder="جستجوی کاربر، سهم" style="width: calc(100% - 150px);">
                      </div>
                      <div class="card panel-transparent">
                        <div class="card-block">

                            <div class="table-responsive no-border ">
                              <table class="table table-hover" >
                                <thead>
                                    <th>کاربر</th>
                                    <th>سهم</th>
                                    <th>قیمت</th>
                                    <th>حجم</th>
                                    <th>زمان</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr onclick="feedbox(1)">
                                        <td> pooyach</td>
                                        <td>فخوز</td>
                                        <td>2450</td>
                                        <td>230</td>
                                        <td> لحظاتی پیش</td>
                                        <td><span class="btn-primary btn"> کپی شد </span></td>
                                    </tr>
                                    <tr onclick="feedbox(2)">
                                        <td> milad</td>
                                        <td>ایراپ</td>
                                        <td>2450</td>
                                        <td>230</td>
                                        <td> لحظاتی پیش</td>
                                        <td><span class="btn-default btn"> کپی کردن </span></td>
                                    </tr>

                                </tbody>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;"> پروفایل </h5>
                      </div>
                    </div>
                    <div class="card panel-transparent">
                      <div class="card-block" >
                        <div class="col-md-6 " style="float: left;">
                            <div class="info-block" style="direction: rtl;padding-right: 30px !important;">
                                <div style="cursor: pointer;" class="row" onclick="followingbox(2)">
                                    <img style="float: right; padding: 5px;" src="<?=base_url();?>images/addeduser.png" class="img-circle" alt="" width="35" height="35">
                                    <h6 style="float: right;padding: 10px;">دنبال کردن</h6>
                                    <h6 style="float: right;padding: 10px;">723</h6>
                                 </div>
                                 <div class="row">
                                    <img style="float: right;padding: 5px;" src="<?=base_url();?>images/adduser.png" class="img-circle" alt="" width="35" height="35">
                                    <h6 style="float: right;padding: 10px;">دنبال شدن</h6>
                                    <h6 style="float: right;padding: 10px;">425</h6>
                                 </div>
                                 
                            </div>
                            <div class="info-block" style="direction: rtl;padding-right: 30px !important;">
                                <div class="row">
                                    <h6 style="float: right;padding: 10px;">بازگشت سرمایه</h6>
                                    <h6 style="float: right;padding: 10px;">230%</h6>
                                 </div>
                                 <div class="row">
                                    <h6 style="float: right;padding: 10px;">درصد موفقیت</h6>
                                    <h6 style="float: right;padding: 10px;">720%</h6>
                                 </div>
                                
                            </div>
                            <div class="info-block" style="direction: rtl;padding-right: 30px !important;">
                                <div class="row">
                                    <h6 style="float: right;padding: 10px;">بهترین معامله</h6>
                                    <h6 style="float: right;padding: 10px;">+73.9</h6>
                                 </div>
                                 <div class="row">
                                    <h6 style="float: right;padding: 10px;">بدترین معامله</h6>
                                    <h6 style="float: right;padding: 10px;">-29.0</h6>
                                 </div>                                                           
                            </div>

                        </div>
                        <div class="col-md-6 "  style="float: right; padding-top: 50px; text-align: center;">
                            <img src="<?=base_url();?>images/defaultm.png" class="img-circle" alt="" width="150" height="150">
                            <h6 style="text-align: center !important; margin-top: 10px;">کریم فیضی </h6>
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
<script type="text/javascript">
function userinfobox(argument) {
  $('#userinfoboxModal').modal('show');
  $('#followingModal').modal('hide');
}
function feedbox(argument) {
  $('#feedboxModal').modal('show');
}
function followingbox(argument) {
  $('#followingModal').modal('show');
}
</script>

<!-- Modal -->
<div class="modal fade" id="userinfoboxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body card">
        <div class="container demo-1">
          <div class="top">
            <div class="row">
              <div class="col-md-4 ml-auto">
                <h6>درصد موفقیت</h6>
                <h6>87.23 %</h6>
              </div>
              <div class="col-md-4 ml-auto" style="border-left: 1px solid ;border-right: 1px solid ;">
                <h6> دنبال میکند</h6>
                <h6>126</h6>
              </div>
              <div class="col-md-4 ml-auto">
                <h6>دنبال میشود</h6>
                <h6>38</h6>
              </div>
            </div>
            <div class="row">
              <h4 style="text-align: left !important;padding-top: 50px;">Milad Ashtab</h4>
            </div>
          </div>
          <div class="bottom" style="text-align: left !important;">
              
              <a href="#"><img style="background: #2d4f6a;border-radius: 50%;" src="<?=base_url();?>images/defaultm.png" class="img-circle" alt="" width="100" height="100"></a>
              <button class="btn btn-default "><h6> دنبال کردن </h6></button>
                <div class="checkbox" style="padding-top: 25px;">
                  <label><input type="checkbox" id="ex7-enabled"> کپی معاملات کاربر به صورت اتوماتیک</label>
                </div>
                  <div class="row well" dir ="rtl" style="padding-top: 15px;">

                  <input id="ex7" width="100%"  type="text" data-slider-min="0" data-slider-max="200" data-slider-step="1" data-slider-value="100" data-slider-enabled="false"/>

                  </div>
                  <h6 style="padding-top: 15px;"><span id="ex7SliderVal">100</span>%   
                  درصد برابری سفارش شما نسبت به اصل معاملات این کاربر</h6>
          </div>    
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="feedboxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 450px;">
    <div class="modal-content">
      <div class="modal-body card">
        <div class="row">
            <div class="col-md-4 ml-auto">
              <a href="#"><img style="background: #2d4f6a;border-radius: 50%;" src="http://localhost/billionaire/msa/images/defaultm.png" class="img-circle" alt="" width="100" height="100"></a>
            </div>
            <div class="col-md-8 ml-auto" >
              <h4 style="text-align: left !important;" >Milad Ashtab</h4>
              <h6 style="text-align: left !important;padding-left: 35px" >درصد موفقیت</h6>
              <h5 style="text-align: left !important;padding-left: 60px;" >38%</h5>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12 ml-auto" style="text-align: center;">
            <h6 style="background: #2d4f6a;border-radius: 50%; width: 80px; height: 80px;line-height: 5.4em !important;border: 1px solid;color: #fff;margin: auto;">فخوز</h6>
            <h6 class="text-success" style="width: 70px;margin-left: 60%;margin-top: -45px;margin-bottom: 45px;">صعودی <i class="fa fa-level-up" aria-hidden="true"></i>
            </h6> 
<!--                   <h6 class="text-danger" ">نزولی <i class="fa fa-level-down" aria-hidden="true"></i>
            </h6> -->
          </div>
          <div class="col-md-12 ml-auto" style="text-align: center;">
            <h6>سود تا این لحظه </h6>
            <h5 style="text-align: center !important;">+36% </h5>
          </div>
          <div class="col-md-12 ml-auto" >
            <div class="row">
              <div class="col-md-6 ml-auto" >
                <h6> 346،012،512 تومان</h6>
              </div>
              <div class="col-md-6 ml-auto" >
                <h6>مجموعِ ارزش معاملات کپی شده</h6>
              </div>
            </div>
          </div>
          <div class="col-md-12 ml-auto" >
            <div class="row">
              <div class="col-md-6 ml-auto ">
                <h6>81 نفر</h6>
              </div>
              <div class="col-md-6 ml-auto" >
                <h6> کپی شده توسط</h6>
              </div>
              
            </div>
          </div>
          <div class="col-md-12 ml-auto" >
            <div class="row">
              <div class="col-md-6 ml-auto" >
                <button class="btn btn-default "><h6> صرف نظر </h6></button>
              </div>
              <div class="col-md-6 ml-auto" >
                <button class="btn btn-primary "><h6> کپی کن </h6></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;max-height: 500px; ">
    <div class="modal-content">
      <div class="modal-body card">
        <h5 style="text-align: center !important;">لیست افرادی که دنبال می کنید</h5>
        <table width="100%">
          <tbody>
            <tr >
              <td> <img  src="<?=base_url();?>images/user.png" class="img-circle" alt="" width="30" height="30"> </td>
              <td><h6  class=""> hooman.q </h6></td>
              <td> <h6  class="btn-default btn" onclick="userinfobox(1)"> کپی شده </h6></td>
              <td> <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
            </tr>
            <tr >
              <td> <img  src="<?=base_url();?>images/user.png" class="img-circle" alt="" width="30" height="30"> </td>
              <td><h6  class=""> hooman.q </h6></td>
              <td> <h6  class="btn-default btn"> کپی کردن </h6></td>
              <td> <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
            </tr>
            <tr >
              <td> <img  src="<?=base_url();?>images/user.png" class="img-circle" alt="" width="30" height="30"> </td>
              <td><h6  class=""> hooman.q </h6></td>
              <td> <h6  class="btn-primary btn" onclick="userinfobox(1)"> کپی شده </h6></td>
              <td> <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
            </tr>
            <tr >
              <td> <img  src="<?=base_url();?>images/user.png" class="img-circle" alt="" width="30" height="30"> </td>
              <td><h6  class=""> hooman.q </h6></td>
              <td> <h6  class="btn-default btn" onclick="userinfobox(1)"> کپی شده </h6></td>
              <td> <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">


// Without JQuery
var slider = new Slider("#ex7");

$("#ex7-enabled").click(function() {
  if(this.checked) {
    // Without JQuery
    slider.enable();
  }
  else {
    // Without JQuery
    slider.disable();
  }
});
slider.on("slide", function(sliderValue) {
  document.getElementById("ex7SliderVal").textContent = sliderValue;
});


</script>


