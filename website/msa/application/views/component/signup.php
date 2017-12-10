<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<header class="masthead" >
  <div class="header-content">
    <div class="header-content-inner">
      <div class="row">
        <div class="col-md-7">
          <div class="col-md-12 " style="text-align: center;">
            <a href="<?php echo base_url();?>">
            <img src="<?php echo base_url(); ?>images/logo.png" style="width: 50%;">
            </a>
          </div>
        </div>
        <div class="col-md-5">
          <div class="panel panel-registertwo">
            <!-- <div class="panel-heading">
              <div class="row">
                <div class="col-xs-6">
                  <a href="#" id="registertwo-form-link">عضویت شرکت</a>
                </div>
                <div class="col-xs-6" >
                  <a href="#" class="active" id="register-form-link">عضویت شخص</a>
                </div>
              </div>
              <hr>
            </div> -->
          <div class="col-md-12">
            <ul class="pregister">
            </ul>
          </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form id="registertwo-form"  role="form" style="display: none;">
                    <div class="form-group">
                      <input type="email" name="email" id="email" tabindex="1" class="form-control coregister" placeholder="آدرس ایمیل" value="" aria-describedby="inputStatus">
                 
                    </div>
                     <div class="form-group">
                      <input type="text" name="name" id="name" tabindex="2" class="form-control coregister" placeholder="نام شرکت" value="">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="password" tabindex="3" class="form-control coregister" placeholder="گذرواژه">
                    </div>
                    <div class="form-group">
                      <input type="password" name="confirm-password" id="confirm-password" tabindex="4" class="form-control coregister" placeholder="تکرار گذرواژه">
                    </div>
                    <div class="form-group">
                          <input type="button" name="register-submit" id="register-submit" tabindex="5" class="form-control btn " value="پذبرش قوانین و ثبت نام" onclick="cosignup()">
                    </div>
                  </form>
                  <form id="register-form"  role="form" style="display: block;">
                    <div class="form-group">
                      <input type="email" name="email" id="email" tabindex="10" class="form-control register" placeholder="آدرس ایمیل" value="">
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <input type="text" name="lname" id="lname" tabindex="12" class="form-control register" placeholder="نام خاونادگی" value="">
                      </div>
                      <div class="form-group col-md-6">
                        <input type="text" name="fname" id="fname" tabindex="11" class="form-control register" placeholder="نام" value="">
                      </div>
                      
                    </div>
                    <div class="form-group">
                      <input type="text" name="phone" id="phone" tabindex="14" class="form-control register" placeholder="تلفن ثبت نام" value="">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="password" tabindex="15" class="form-control register" placeholder="گذرواژه">
                    </div>
                    <div class="form-group">
                      <input type="password" name="confirm-password" id="confirm-password" tabindex="16" class="form-control register" placeholder="تکرار گذرواژه">
                    </div>
                    <div class="form-group">
                      <select id="gender" class="form-control">
                        <option value="0" selected>مرد</option>
                        <option value="1">زن</option>
                      </select>
                    </div>
                    <div class="form-group">
                          <input type="button" name="register-submit" id="register-submit" tabindex="17" class="form-control btn btn-primary  btn-fill" value="پذیرش قوانین و ثبت نام" onclick="psignup()">
                    </div>
                  </form>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-6 col-md-6">
                        <div class="text-right">
                          <a href="<?php echo base_url();?>login" tabindex="5" class="forgot-password">قوانین و مقررات...!</a>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="text-right">
                          <a href="<?php echo base_url();?>login" tabindex="5" class="forgot-password">پیشتر ثبت نام کردید</a>
                        </div>
                      </div>                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<script type="text/javascript">
$(function() {

    $('#registertwo-form-link').click(function(e) {
    $("#registertwo-form").delay(100).fadeIn(100);
    $("#register-form").fadeOut(100);
    $('#register-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
  });
  $('#register-form-link').click(function(e) {
    $("#register-form").delay(100).fadeIn(100);
    $("#registertwo-form").fadeOut(100);
    $('#registertwo-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
  });

});
/* autocomplet : this function will be executed every time we change the text*/
function psignup() {
   var values = {
    email:$("input[name=email].register").val(),
    fname:$("input[name=fname].register").val(),
    lname:$("input[name=lname].register").val(),
    phone:$("input[name=phone].register").val(),
    passwd:$("input[name=password].register").val(),
    repasswd:$("input[name=confirm-password].register").val(),
    type:1,
    gender:$("#gender option:selected").val()
   };
    $.ajax({
        url: '<?php echo base_url();  ?>signup/register',
            type: 'POST',
            dataType: 'json',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
        success:function(data)
        {
          $('ul.pregister').html("");
          var response = data.result;
          if(response.error){
            $.each(response['error_detalis'], function (index, object) {
                  $('ul.pregister').append("<li>"+object+"</li>")
            });
          }else{
            if(response.data){
              location.reload();
            }
          }
          
        }
      }); 
}
function cosignup() {
   var values = {
    email:$("input[name=email].coregister").val(),
    fname:$("input[name=fname].coregister").val(),
    passwd:$("input[name=password].coregister").val(),
    repasswd:$("input[name=confirm-password].coregister").val(),
    type:2
   };
    $.ajax({
        url: '<?php echo base_url();  ?>signup/register',
            type: 'POST',
            dataType: 'json',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
        success:function(data)
        {
          $('ul.pregister').html("");
          var response = data.result;
          if(response.error){
            $.each(response['error_detalis'], function (index, object) {
                  $('ul.pregister').append("<li>"+object+"</li>")
            });
          }else{
            if(response.data){
              location.reload();
            }
          }
          
        }
      }); 
}
</script>




    
                   
