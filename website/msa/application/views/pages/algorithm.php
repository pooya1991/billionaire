<?php
defined('BASEPATH') OR exit('No divect script access allowed');
?>
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
                  <div class="panel-body ">
                    <div class="panel-body ">
                        <div class="card ">
                          <div class="card-block">
                            <h5 class="block-title" style="float: right;margin: 0px;">اندیکاتور</h5>
                          </div>
                        </div>
                        <div class="card panel-transparent">
                          <div class="card-block" >
                            <div class="" style="padding: 20px; text-align: center;">
                                <h6 style="margin: 50px; text-align: center;">لطفا لیست معاملات خود را در قالب فایل اکسل بارگذاری کنید</h6>
                                <button class="btn btn-primary " style="border-width: 2px;font-size: 18px;">بارگذاری معاملات</button>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;">نمودار</h5>
                      </div>
                    </div>
                    <div class="card panel-transparent">
                      <div class="card-block">
                         <?=(isset($mainchart)) ? $mainchart : "" ;?>
                      </div>
                    </div>

                    
                  </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="panel panel-primary ">
                  
                  <div class="panel-body">
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;"> استراتژی های من </h5>
                      </div>
                      <div class="card panel-transparent">
                        <div class="card-block">

                            <div class="table-responsive no-border ">
                              <table class="table table-hover" >
                                <thead>
                                    <th>استراتژس</th>
                                    <th>نام سهم / دیدبان</th>
                                    <th>درصد موفقیت</th>
                                    <th>بازگشت سرمایه</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> معقول</td>
                                        <td>دیدبان معقول</td>
                                        <td>53%</td>
                                        <td>126%</td>
                                        <td> <img src="<?=base_url();?>images/bell.png" class="img-circle" alt="" width="20" height="20"></td>
                                    </tr>
                                    <tr>
                                        <td> تک سهم</td>
                                        <td>فخوز</td>
                                        <td>70%</td>
                                        <td>126%</td>
                                        <td> <img src="<?=base_url();?>images/abell.png" class="img-circle" alt="" width="20" height="20"></td>
                                    </tr>
                                    <tr>
                                        <td> معقول</td>
                                        <td>دیدبان معقول</td>
                                        <td>53%</td>
                                        <td>126%</td>
                                        <td> <img src="<?=base_url();?>images/bell.png" class="img-circle" alt="" width="20" height="20"></td>
                                    </tr>
                                    <tr>
                                        <td> تک سهم</td>
                                        <td>فخوز</td>
                                        <td>70%</td>
                                        <td>126%</td>
                                        <td> <img src="<?=base_url();?>images/abell.png" class="img-circle" alt="" width="20" height="20"></td>
                                    </tr>
                                </tbody>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;"> تعیین استراتژی </h5>
                      </div>
                    </div>
                    <div class="card panel-transparent">
                      <div class="card-block" >
                        <div class="col-md-6 " style="float: left;">
                            <div class="info-block">
                                <div style="padding: 10px; text-align: center;">
                                        <label class="control-label" for="datepicker3">تاریخ شروع</label>
                                        <div class="form-group">
                                            <input style="background: #0f3045 !important; color: #fff; border-color: #FFF;" class="form-control" type="text" id="datepicker3" />
                                        </div>
                                </div>
                            </div>
                            <div class="info-block">
                                <div style="padding: 10px; text-align: center;background: #0f3045 !important; color: #fff;">
                                        <label class="control-label" for="datepicker4">تاریخ پایان</label>
                                        <div class="form-group">
                                            <input style="background: #0f3045 !important; color: #fff;border-color: #FFF;" class="form-control" type="text" id="datepicker4" />
                                        </div>
                                </div>
                            </div>
                            <div ">
                                      <button class="btn btn-primary btn-fill" style="border-width: 2px;font-size: 20px;">ذخیره ستراتژی </button>
                            </div>
                        </div>
                        <div class="col-md-6 "  style="float: right; padding-top: 12px;  text-align: right;">
                          <input class=" btn" type="text" name="search" placeholder=" نام سهم" style="width: calc(100% ); background: #0f3045 !important; color: #fff;border-radius: none;">
                            <div class="info-block" style="height: 150px;">
                              <span>فخوز</span>،
                              <span>ایراپ</span>
                            </div>
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

   $("#datepicker4").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: "yyyy/mm/dd"
                });   
      $("#datepicker3").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: "yyyy/mm/dd"
                });   
</script>


