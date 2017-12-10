<?php
defined('BASEPATH') OR exit('No divect script access allowed');
?>
<style type="text/css">
.table th,.table td{
  font-size: .8rem !important;
}
input[type=checkbox] 
{
visibility: hidden;
}

/* SQUARED ONE */
.squaredChk
{
width: 10px;    
margin:  auto;
position: relative;
}

.squaredChk label 
{
cursor: pointer;
position: absolute;
width: 20px;
height: 20px;
top: 0;
border-radius: 4px;
background: #ffffff;
border: 2px solid #aaaaaa
}

.squaredChk label:after 
{
-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
filter: alpha(opacity=0);
opacity: 0;
content: '';
position: absolute;
border: 1px solid #1abc9c;
border-radius: 2px;
width: 17px;
height: 16px;
background: #1abc9c;
top: 0px;
left: 0px;
transition: visibility 0s .5s, opacity .5s linear;
}

.squaredChk label:hover::after 
{
-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
filter: alpha(opacity=30);
opacity: 0.3;
transition: visibility 0s .5s, opacity .5s linear;

}

.squaredChk input[type=checkbox]:checked + label:after 
{
-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
filter: alpha(opacity=100);
opacity: 1;
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
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;">اعلانات</h5>
                      </div>
                    </div>
                    <div class="card panel-transparent">
                      <div class="card-block" style="min-height: 200px;">
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
               <div class="panel panel-primary ">
                  <div class="panel-body ">
                    <div class="panel-body ">
                        <div class="card ">
                          <div class="card-block">
                            <h5 class="block-title" style="float: right;margin: 0px;">سبد شما</h5>
                          </div>
                        </div>
                        <div class="card panel-transparent">
                          <div class="card-block" >
                            <div class="table-responsive no-border ">
                              <table class="table table-hover" >
                                <thead>
                                    <th></th>
                                    <th>سهم</th>
                                    <th></th>
                                    <th>درصد</th>
                                    <th>تعداد</th>
                                    <th>مبلغ</th>
                                </thead>
                                <tbody>
                                <?php
                                if(is_array($stocks))
                                foreach ($stocks as $key => $value) {
                                  //if($value['amount']!=0)
                                  echo '
                                  <tr>
                                      <td><i class="fa fa-info-circle"></i></td>
                                      <td>'.$value['title_fa'].'</td>
                                      <td style="min-width:50px; "> 
                                        <div class="progress progress-rtl">
                                          <div class="progress-bar progress-bar-info" role="progressbar" style="width:'.($value['percent']*100).'%">
                                          </div>
                                        </div>
                                      </td>
                                      <td>'.($value['percent']*100).'%</td>
                                      <td>'.$value['amount'].'</td>
                                      <td>'.$value['amount']*$value['price'].'</td>
                                    </tr>

                                  ';
                                }

                                ?>
                                </tbody>
                              </table>
                            </div>
                            <div style="clear: both;padding: 15px;text-align: center;">
                              <button type="button"  class="btn icon  btn-default btn-fill" style="width: 150px;">بازبینی سبد فعلی</button>
                              <button type="button"  class="btn icon  btn-primary btn-fill" style="width: 150px;">موافقم </button>
                            </div>
                          </div>
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
                        <h5 class="block-title" style="float: right;margin: 0px;"> ویرایش اطلاعات شخصی </h5>
                      </div>
                      <div class="card panel-transparent">
                        <div class="card-block row" style="text-align: center;">
                      <?php
                          if (is_array($userrisk)) {
                            echo '
                          <div class="col-lg-6 col-md-6 col-sm-12"  style="padding: 15px;text-align: center;"> 
                            <div style="" >
                              <span style="">عدد ریسک شما <b class="trisknumber">'.$userrisk['risk_number'].'</b></span>
                            </div>
                            <div class="" dir="ltr" style="font-size:0.7em;padding: 20px;">
                              <span id="tex7SliderVal1" style="float: right;">'.$userrisk['up_number'].'%</span>
                              <span id="tex7SliderVal2" style="float: left;">'.$userrisk['down_number'].'%</span>
                            </div>
                            <div style="float: left; width: 100%;">
                                <img src="'.base_url().'/images/bord.png" style="min-width: 170px;width: 70%;height: 35px;"/>
                            </div>
                            <div style="clear: both;padding-top: 15px;">
                              <button type="button"  class="btn icon  btn-primary btn-fill" onclick="trebalencing()" style="width: 150px;">سبد گردانی با ریسک فعلی </button>
                            </div>
                            <div style="padding-top: 15px;">
                              <button type="button" onclick="riskform()" class="btn icon  btn-primary" style="width: 150px;"> ارزیابی مجدد</button>
                            </div>
                          </div>
                            ';
                          }else{
                            echo '
                          <div class="col-lg-6 col-md-6 col-sm-12"  style="padding: 15px;text-align: center;"> 
                            <div style="padding: 35px;" >
                              <h6>برای مشخص شدن سطح ریسک خود آزمون ارزیابی را انجام دهید.</h6>
                            </div>
                            <div style="padding-top: 15px;">
                              <button type="button" onclick="riskform()" class="btn icon  btn-primary" style="width: 150px;"> ارزیابی ریسک</button>
                            </div>
                          </div>
                            ';
                          }
                        ?>

                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <h6 style="text-align: center !important;">سبد سهام</h6>  
                            <?=(isset($circlechart)) ? $circlechart : "" ;?>
                            <p style="font-size: 10px;text-align: center !important;">هدف گذاری مالیافزایش سرمایه</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;">  روند سرمایه گذاری</h5>
                      </div>
                    </div>
                    <div class="card panel-transparent">
                      <div class="card-block" >
                        <div class="table-responsive no-border ">
                             <?=(isset($mainchart)) ? $mainchart : "" ;?> 
                        </div>
                      </div>
                    </div>
                    <div class="card ">
                      
                    </div>
                      <div class="card-block" style="color: #FFF; ">
                        <input class=" info-block panel-transparent" type="text" id="tamount" value="<?=$userrisk['cash'];?>" style="width: calc(100% - 100px);">
                        کل سرمایه
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


function riskform() {
  $('#riskformstep1').modal('show');
  $('#mainNav').css('padding-right','0px');
} 
function riskformstep(a,b,c) {
  if(a=="#riskformstep6"){
    getriskinfo();
  }
  if(b=="#riskformstep14"){
    $('.risknumber').html($(c).attr('value'));
    $('.trisknumber').html($(c).attr('value'));
    addslider($(c).attr('value1'),$(c).attr('value2'));
  }
  if(a=="#riskformstep14"){

     saverisk();
  }
  $(a).modal('hide');
  $(b).modal('show');
  $('#mainNav').css('padding-right','0px');
} 

function getriskinfo() {
   var values = {
    risk:$("input#ex6").val()
   };
    $.ajax({
        url: '<?php echo base_url();  ?>actions/risk_items',
            type: 'POST',
            dataType: 'json',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
        success:function(data)
        {
          var response = data.result;
          if(response.error){
            $.each(response['error_detalis'], function (index, object) {
                  $('ul.pregister').append("<li>"+object+"</li>")
            });
          }else{
            if(response.data){
              object=response.data;
              $('.riskitem7-1-1').html(+(parseFloat(object[2]).toFixed(2))+"%");
              $('.riskitem7-1-2').html(+(parseFloat(object[1]).toFixed(2))+"%");
              $('.riskitem7-2-1').html(+(parseFloat(object[0]))+"%");
              $('.riskitem7-2-2').html("-"+(parseFloat(object[0]))+"%");
              $('.riskitem7-3-1').html(+(parseFloat(object[5]).toFixed(2))+"%");
              $('.riskitem7-3-2').html(+(parseFloat(object[4]).toFixed(2))+"%");
              $('.riskitem8-1-1').html(+(parseFloat(object[8]).toFixed(2))+"%");
              $('.riskitem8-1-2').html(+(parseFloat(object[7]).toFixed(2))+"%");
              $('.riskitem9-3-1').html(+(parseFloat(object[11]).toFixed(2))+"%");
              $('.riskitem9-3-2').html(+(parseFloat(object[10]).toFixed(2))+"%");
              $('.riskitem10-2-1').html(+(parseFloat(object[20]).toFixed(2))+"%");
              $('.riskitem10-2-2').html(+(parseFloat(object[19]).toFixed(2))+"%");
              $('.riskitem11-2-1').html(+(parseFloat(object[14]).toFixed(2))+"%");
              $('.riskitem11-2-2').html(+(parseFloat(object[13]).toFixed(2))+"%");
              $('.riskitem12-2-1').html(+(parseFloat(object[17]).toFixed(2))+"%");
              $('.riskitem12-2-2').html(+(parseFloat(object[16]).toFixed(2))+"%");
              $('.riskitem13-2-1').html(+(parseFloat(object[23]).toFixed(2))+"%");
              $('.riskitem13-2-2').html(+(parseFloat(object[22]).toFixed(2))+"%");
              $('.riskitem7-1 ').attr('value',object[3]);
              $('.riskitem7-1 ').attr('value1',object[1]);
              $('.riskitem7-1 ').attr('value2',object[2]);
              $('.riskitem7-3 ').attr('value',object[6]);
              $('.riskitem7-3 ').attr('value1',object[4]);
              $('.riskitem7-3 ').attr('value2',object[5]);
              $('.riskitem8-1 ').attr('value',object[9]);
              $('.riskitem8-1 ').attr('value1',object[7]);
              $('.riskitem8-1 ').attr('value2',object[8]);
              $('.riskitem9-3 ').attr('value',object[12]);
              $('.riskitem9-3 ').attr('value1',object[10]);
              $('.riskitem9-3 ').attr('value2',object[11]);
              $('.riskitem10-2 ').attr('value',object[21]);
              $('.riskitem10-2 ').attr('value1',object[19]);
              $('.riskitem10-2 ').attr('value2',object[20]);
              $('.riskitem11-2 ').attr('value',object[15]);
              $('.riskitem11-2 ').attr('value1',object[13]);
              $('.riskitem11-2 ').attr('value2',object[14]);
              $('.riskitem12-2 ').attr('value',object[18]);
              $('.riskitem12-2 ').attr('value1',object[16]);
              $('.riskitem12-2 ').attr('value2',object[17]);
              $('.riskitem13-2 ').attr('value',object[24]);
              $('.riskitem13-2 ').attr('value1',object[22]);
              $('.riskitem13-2 ').attr('value2',object[23]);
            }
          }
          
        }
      }); 
}
</script>

<style type="text/css">
.model-footer{
  bottom: 0px;
  position: absolute;
  width: 100%;
}
.model-footer button{
  padding: 10px 40px 10px;

}
.content-header span{
  border: 1px solid #fff;
  border-radius: 5px;
  font-size: 1em;
  text-align: center;
  float: left;
  width: 50px;
  margin-left: 15px;
}
#riskformstep1 .content p{
  clear: both;
  padding: 30px 48px;
  line-height: 1.7em !important;
}
.content-header{
  padding-top: 20px;
}

#ck-button {
  margin: 5px;
  border-radius: 8px;
  border: 1px solid #D0D0D0;
  overflow: auto;
  float: left;
  width: 45%;
}

#ck-button label {
  float: left;
  width: 100%;
  margin-bottom: unset;
  cursor: pointer;

}

#ck-button label span {
    text-align:center;
    padding:3px 0px;
    display:block;
    border-radius:4px;

}

#ck-button label input {
    position:absolute;
    top:-20px;

}

#ck-button input:hover + span {
    background-color:#62e4ca;
}
#ck-button input:checked:focus + span {
    box-shadow: 0 0 0 3px rgba(26,188,156,.5);
}

#ck-button input:checked + span {
    background-color:#1abc9c;
    color:#fff;
}

#ck-button input:checked:hover + span {
    background-color:#62e4ca;
    color:#fff;
}
#riskformstep3 .content p{
  padding: 15px 10px 15px 10px;
  text-align: center !important;
  clear: both;
  font-size: 0.9em;
}
#riskformstep3 .content textarea{
  border-radius: 8px;
  border: 1px solid #D0D0D0;
  background: #0b2332 !important;
  background-color:unset;
  color: #fff;
  width: 90%;
  height: 150px; 
  padding: 5px;
}
.slider-horizontal{
  width: 90% !important;
}
</style>



<!-- Modal -->
<div class="modal " id="riskformstep1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 350px; ">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card" >
        <h6 style="text-align: center !important;">عدد ریسک شما چیست؟</h6>
        <div class="content">
          <div class="content-header">
            <span>ریسک 43</span>
            <span>ریسک 44</span>
            <span>ریسک 45</span>
            <span>ریسک 46</span>
            <span>ریسک 47</span>
          </div>
          <p>
          به کمک سوالاتی که از شما در ادامه پرسیده می شود میزان پذیرش ریسک  خود را ثبت کنید واطمینان حاصل کنید سبد  انتخابی شما متناسب با شما است.
          </p>
        </div>
        <div class="model-footer">
          <button class="btn btn-primary" onclick="riskformstep('#riskformstep1','#riskformstep2')"> شروع </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal " id="riskformstep2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px; ">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">هدف مالی شما از سرمایه گذاری در بورس چیست؟</h6>
        <div class="content" style="padding: 30px 0px 0px 18px;">
          <div id="ck-button">
             <label>
                <input type="checkbox" class="tcheck" value="1"><span>پس از بازنشستگی</span>
             </label>
          </div>
          <div id="ck-button">
             <label>
                <input type="checkbox" class="tcheck" value="2"><span>پس انداز</span>
             </label>
          </div>
          <div id="ck-button">
             <label>
                <input type="checkbox" class="tcheck" value="3"><span>افزایش ثروت</span>
             </label>
          </div>
          <div id="ck-button">
             <label>
                <input type="checkbox" class="tcheck" value="4"><span>درآمد ثابت</span>
             </label>
          </div>
          <div id="ck-button">
             <label>
                <input type="checkbox" class="tcheck" value="5"><span>پرداخت بدهی</span>
             </label>
          </div>
          <div id="ck-button">
             <label>
                <input type="checkbox" class="tcheck" value="6"><span>موارد دیگر</span>
             </label>
          </div>
        </div>
        <div class="model-footer ">
          <button class="btn btn-primary" onclick="riskformstep('#riskformstep2','#riskformstep3')"> بعدی </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal " id="riskformstep3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">وضعیت مالی شما چگونه است؟</h6>
        <div class="content">
          <p> شرایط جذاب کاری، ارثیه و یا مبالغ قابل توجهی که تصمیم دارید به واسطه  آنها سرمایه گذاری کنید</p>
          <textarea id="discription"></textarea>
        </div>
        <div class="model-footer">
          <button class="btn btn-primary" onclick="riskformstep('#riskformstep3','#riskformstep4')"> بعدی </button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal " id="riskformstep4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">بازنشستگی</h6>
        <div class="content">
          <div style="padding: 15px 50px; text-align: center;">
            <label class="control-label" for="datepicker3">تاریخ تولد</label>
            <div class="form-group row">
              <div class="col-md-6">
                <input style="background: #0b2332 !important; color: #fff; border-color: #FFF;" class="form-control" type="text" id="year" placeholder="1367 " />
              </div>
              <div class="col-md-3">
                <input style="background: #0b2332 !important; color: #fff; border-color: #FFF;" class="form-control" type="text" id="month" placeholder="02" />
              </div>
              <div class="col-md-3">
                <input style="background: #0b2332 !important; color: #fff; border-color: #FFF;" class="form-control" type="text" id="day" placeholder="23" />
              </div>

            </div>
          </div>
          <div style="padding: 10px 90px; text-align: center;">
            <label class="control-label" for="datepicker4">سن بازنشتگی که در نظر دارید</label>
            <div class="form-group">
                <input style="background: #0b2332 !important; color: #fff; border-color: #FFF;" class="form-control" type="text" id="retierment" placeholder="60" />
            </div>
          </div>
        </div>
        <div class="model-footer">
          <button class="btn btn-primary" onclick="riskformstep('#riskformstep4','#riskformstep5')"> بعدی </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal " id="riskformstep5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style=" max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">قصد چه میزان سرمایه گذاری دارید؟</h6>
        <div class="content">
          <div style="padding: 60px 40px; text-align: center;">
            <div class="form-group">
                <input style="background: #0b2332 !important; color: #fff; border-color: #FFF;" placeholder="20,000,000" class="form-control" type="text" id="amount" required="required" /> ریال
            </div>
            <label class="control-label" style="font-size: 0.8em;">مجموع سرمایه گذاری های شما در تمامی سبد ها مدنظر است</label>
          </div>
        </div>
        <div class="model-footer">
          <button class="btn btn-primary" onclick="riskformstep('#riskformstep5','#riskformstep6')"> بعدی </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal " id="riskformstep6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">میزان ریسک قابل پذیرش برای شما چقدر است؟</h6>
        <div class="content">

          <div class="" dir="ltr" style="padding-top: 15px;">
            <div style="padding-top: 15px;text-align: right !important;padding-right: 10px;">
            <label style="font-size: 0.7em;width: 50%;">این شانس برای شما وجود خواهد داشت که به این میزان سود کنید</label><span id="ex6SliderVal1" style="vertical-align: super;padding: 5px;">12</span>%
            

            </div>
            <input id="ex6" width="85%"  type="text" data-slider-min="5" data-slider-max="20" data-slider-step="0.2" data-slider-rtl="false" data-slider-value="12" data-slider-enabled="true"/>

            <div style="padding-top: 15px;text-align: left !important;padding-left: 10px;">
              <span id="ex6SliderVal2" style="vertical-align: super;padding: 5px;">-12</span>%
              <label style="width: 40%;font-size: 0.7em;">طی شش ماه آینده شما با این میزان از ریسک مواجهید</label>
            </div>
        </div>
        <div class="model-footer">
          <button class="btn btn-primary" onclick="riskformstep('#riskformstep6','#riskformstep7')"> بعدی </button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">


// Without JQuery
var slider = new Slider("#ex6");
slider.on("slide", function(sliderValue) {
  document.getElementById("ex6SliderVal1").textContent = sliderValue;
  document.getElementById("ex6SliderVal2").textContent = sliderValue*-1;
});

function addslider(v1,v2) {
  $('#ex7').attr('data-slider-min',v1);
  $('#ex7').attr('data-slider-max',v2);
  $("#ex7SliderVal1").html(parseFloat(v1).toFixed(2));
  $("#ex7SliderVal2").html(parseFloat(v2).toFixed(2));
  $("#tex7SliderVal2").html(parseFloat(v1).toFixed(2));
  $("#tex7SliderVal1").html(parseFloat(v2).toFixed(2));
}

</script>
<style type="text/css">
.riskstep .content div{
  width: 30%;
  float: left;
  text-align: center !important;

}
.riskstep2 .content div{
  width: 45%;
  float: left;
  text-align: center !important;

}
.riskstep .content label,.riskstep2 .content label{
  width: 100%;
  text-align: center !important;
  margin-top: 10px;
  height: 50px;
}
.riskstep .content,.riskstep2 .content,.risklaststep .content {
  padding: 25px 15px 25px 15px;
}
.riskstep .content img,.riskstep2 .content img,.risklaststep .content img{
  cursor: pointer;
  height: 130px;
  width: 40px;
}
.riskstep  .model-footer,.riskstep2  .model-footer,.risklaststep  .model-footer {
  height: 40px;

}

</style>


<!-- Modal -->
<div class="modal riskstep" id="riskformstep7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">اگر بخواهید شرایط قبلی را بهبود ببخشید کدامیک از موارد زیر برای شما مطلوب تر است؟</h6>
        <div class="content">
          <div >
            <label class="riskitem7-1-1">0%</label>
            <img src="<?=base_url('images/risk-3.png');?>"  onclick="riskformstep('#riskformstep7','#riskformstep8')" />
            <label class="riskitem7-1-2">0%</label>
          </div>
          <div >
            <label class="riskitem7-2-1">0%</label>
            <img src="<?=base_url('images/risk-1.png');?>" style="cursor: unset;" />
            <label class="riskitem7-2-2" >0%</label>
          </div>
          <div >
            <label class="riskitem7-3-1">+0%</label>
            <img src="<?=base_url('images/risk-2.png');?>"  onclick="riskformstep('#riskformstep7','#riskformstep9')" />
            <label class="riskitem7-3-2">0%</label>
          </div>
          <div class="model-footer">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal riskstep" id="riskformstep8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">تحت شرایط زیر انتخاب شما چه خواهد بود؟</h6>
        <div class="content">
          <div >
            <label class="riskitem8-1-1">0</label>
            <img src="<?=base_url('images/risk-8-1.png');?>"  onclick="riskformstep('#riskformstep8','#riskformstep11')" />
            <label class="riskitem8-1-2">0</label>
          </div>
          <div >
            <label class="riskitem7-1-1">0</label>
            <img src="<?=base_url('images/risk-3.png');?>"  onclick="riskformstep('#riskformstep8','#riskformstep10')" />
            <label class="riskitem7-1-2">0</label>
          </div>
          <div >
            <label class="riskitem7-2-1">0</label>
            <img src="<?=base_url('images/risk-1.png');?>"  style="cursor: unset;" />
            <label class="riskitem7-2-2">0</label>
          </div>
        </div>
        <div class="model-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal riskstep" id="riskformstep9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">تحت شرایط زیر انتخاب شما چه خواهد بود؟</h6>
        <div class="content">
          <div >
            <label class="riskitem7-2-1">0</label>
            <img src="<?=base_url('images/risk-1.png');?>" style="cursor: unset;" />
            <label class="riskitem7-2-2">0</label>
          </div>
          <div >
            <label class="riskitem7-3-1"> 0</label>
            <img src="<?=base_url('images/risk-2.png');?>"  onclick="riskformstep('#riskformstep9','#riskformstep13')" />
            <label class="riskitem7-3-2">0</label>
          </div>
          <div >
            <label class="riskitem9-3-1"></label>
            <img src="<?=base_url('images/risk-9-1.png');?>"  onclick="riskformstep('#riskformstep9','#riskformstep12')" />
            <label class="riskitem9-3-2">0</label>
          </div>
        </div>
        <div class="model-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal riskstep2" id="riskformstep10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">تحت شرایط زیر انتخاب شما چه خواهد بود؟</h6>
        <div class="content">
          <div class="riskitem7-1">
            <label class="riskitem7-1-1"> 0</label>
            <img src="<?=base_url('images/risk-3.png');?>" onclick="riskformstep('#riskformstep10','#riskformstep14','.riskitem7-1')" />
            <label class="riskitem7-1-2">0</label>
          </div>
          <div class="riskitem10-2">
            <label class="riskitem10-2-1">0</label>
            <img src="<?=base_url('images/risk-8-1.png');?>"   onclick="riskformstep('#riskformstep10','#riskformstep14','.riskitem10-2')" />
            <label class="riskitem10-2-2"></label>
          </div>
        </div>
        <div class="model-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal riskstep2" id="riskformstep11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">تحت شرایط زیر انتخاب شما چه خواهد بود؟</h6>
        <div class="content">
          <div class="riskitem8-1" >
            <label class="riskitem8-1-1"> 0</label>
            <img src="<?=base_url('images/risk-8-1.png');?>"  onclick="riskformstep('#riskformstep11','#riskformstep14','.riskitem8-1')" />
            <label class="riskitem8-1-2">0</label>
          </div>
          <div class="riskitem11-2" >
            <label class="riskitem11-2-1">0</label>
            <img src="<?=base_url('images/risk-11-1.png');?>"  onclick="riskformstep('#riskformstep11','#riskformstep14','.riskitem11-2')" />
            <label class="riskitem11-2-2">-22%</label>
          </div>
        </div>
        <div class="model-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal riskstep2" id="riskformstep12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">تحت شرایط زیر انتخاب شما چه خواهد بود؟</h6>
        <div class="content">
          <div class="riskitem9-3" >
            <label class="riskitem9-3-1"></label>
            <img src="<?=base_url('images/risk-9-1.png');?>"   onclick="riskformstep('#riskformstep12','#riskformstep14','.riskitem9-3')" />
            <label class="riskitem9-3-2">0</label>
          </div>
          <div class="riskitem12-2" >
            <label class="riskitem12-2-1">0</label>
            <img src="<?=base_url('images/risk-12-1.png');?>"  onclick="riskformstep('#riskformstep12','#riskformstep14','.riskitem12-2')" />
            <label class="riskitem12-2-2">0</label>
          </div>
        </div>
        <div class="model-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal riskstep2" id="riskformstep13" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">تحت شرایط زیر انتخاب شما چه خواهد بود؟</h6>
        <div class="content">
          <div class="riskitem7-3">
            <label class="riskitem7-3-1">0</label>
            <img src="<?=base_url('images/risk-2.png');?>"   onclick="riskformstep('#riskformstep13','#riskformstep14','.riskitem7-3')" />
            <label class="riskitem7-3-2">0</label>
          </div>
          <div class="riskitem13-2">
            <label class="riskitem13-2-1">0</label>
            <img src="<?=base_url('images/risk-9-1.png');?>"   onclick="riskformstep('#riskformstep13','#riskformstep14','.riskitem13-2')" />
            <label class="riskitem13-2-2">0</label>
          </div>
        </div>
        <div class="model-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal risklaststep" id="riskformstep14" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 350px;">
    <div class="modal-content" style="height: 360px; overflow: hidden;">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">عدد ریسک شما</h6>
        <div class="content">
          <div class="content-header" style="width: 100% !important;padding-top: 0px;">
            <span style="margin-left: 130px;">ریسک <b class="risknumber">0</b></span>
          </div>
          <div class="" dir="ltr" style="padding-top: 70px;">
            <label style="width: 100%;">محدوده ی ریسک شما طی شش ماه آینده</label>
              <span id="ex7SliderVal2" style="float: right;">12%</span>
              <span id="ex7SliderVal1" style="float: left;">-12%</span>
              <div style="float: left; width: 70%;">
                <img src="<?=base_url();?>/images/bord.png" style="min-width: 170px;width: 90%;height: 80px;"/>
          </div>
        </div>
      </div>
        <div class="model-footer ">
          <button class="btn btn-primary saverisk" onclick="riskformstep('#riskformstep14','','')"> موافقم </button>
          <button class="btn btn-default " onclick="cancelrick()"> انصراف </button>
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">

var typingTimer;                //timer identifier
var doneTypingInterval = 500;  //time in ms, 5 second for example


//user is "finished typing," do something
       function ntfy(ico,msg,typ,tim) {
          $.notify({
              icon: ico,
              message: msg

            },{
                type: typ,    //success warning danger info 
                timer: tim
            });
       }



function saverisk() {
  var values = {
    userkey:'<?=$this->session->userdata('billogged_in')['userkey'];?>',
    target:{},
    up:$("#ex7SliderVal2").html(),
    down:$("#ex7SliderVal1").html(),
    number:$(".risknumber").html(),
    year:$('input#year').val(),
    month:$('input#month').val(),
    day:$('input#day').val(),
    amount:$('input#amount').val(),
    retierment:$('input#retierment').val(),
    discription:$('#discription').val()
   };
    i=0;
    $("input.tcheck:checked").each(function(){
        values.target[i++]=$(this).val();
   });

if(values.amount !== ""){
    $( ".saverisk" ).prop('disabled','disabled') ;
        $.ajax({
            url: '<?php echo base_url();  ?>profile/save_user_risk',
                type: 'POST',
                dataType: 'json',
                data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
            success:function(data)
            {
              var response = data.result;
              if(response.error){

                $.each(response['error_detalis'], function (index, object) {
                    
                });
              }else{
                if(response.data){
                    window.setTimeout(function(){
                        //Move to a new location or you can do something else
                        rebalencing();
                    }, 500);
                }
              }
              
            }
          });

}else{

    } 
}
function cancelrick() {
        $( ".saverisk" ).removeAttr('disabled') ;
}

function rebalencing() {
   var values = {
    userkey:'<?=$this->session->userdata('billogged_in')['userkey'];?>',
    risknum:$(".risknumber").html(),
    amount:$('input#amount').val(),
   };
    $.ajax({
        url: '<?php echo base_url();  ?>actions/rebalencing',
            type: 'POST',
            dataType: 'json',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
        success:function(data)
        {
          var response = data.result;
          if(response.error){
            $.each(response['error_detalis'], function (index, object) {
                  $('ul.pregister').append("<li>"+object+"</li>")
            });
          }else{
            if(response.data){
              object=response.data;
              location.reload(); 
            }
          }
          
        }
      }); 
}
function trebalencing() {
   var values = {
    userkey:'<?=$this->session->userdata('billogged_in')['userkey'];?>',
    risknum:parseInt($(".trisknumber").html()),
    amount:$('input#tamount').val(),
   };
    $.ajax({
        url: '<?php echo base_url();  ?>actions/rebalencing',
            type: 'POST',
            dataType: 'json',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
        success:function(data)
        {
          var response = data.result;
          if(response.error){
            $.each(response['error_detalis'], function (index, object) {
                  $('ul.pregister').append("<li>"+object+"</li>")
            });
          }else{
            if(response.data){
              object=response.data;
              location.reload(); 
            }
          }
          
        }
      }); 
}

</script>