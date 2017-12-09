<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="hooman.qorbani">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo base_url();  ?>assets/css/class.css" />
<link rel="stylesheet" href="<?php echo base_url();  ?>assets/css/templatestyle_fa.css" />
<link href="<?php echo base_url();  ?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php echo base_url();  ?>assets/css/font-awesome.min.css">
<link href="<?php echo base_url();  ?>assets/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<title>SynSkill | Syncing Skill</title>
<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>assets/js/template.js"></script>
<script type="text/javascript" src="<?php echo base_url();  ?>assets/js/jquery-1.11.2.js"></script>
<script src="<?php echo base_url();  ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();  ?>assets/js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();  ?>assets/js/jquery.transit.min.js"></script>
<script  type="text/javascript" src="<?php echo base_url();  ?>assets/js/base.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&amp;language=fa"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=API_KEY"  type="text/javascript"></script>-->


</head>
<body>
<div id="Total">
<div id="header">
          <div id="sitesetting" class='col-md-2'>
            <?php  if(isset($sitesetting)) echo $sitesetting; ?>
            </div>
            <div id="firstmenu" class='col-md-6 col-sm-7 col-md-offset-2  hidden-xs'>
                <?php  if(isset($menus)) echo $menus; ?>
            </div>
            <div id="sitelogo" class='col-md-2'>
                <a href="#"><span id="one">SYN</span><span class="Prographtext">SKILL</span></a>
            </div>
            
</div>
<div id="dashbord" class="Prograph">
                <!--<div id="scrolldashbord" class="">  
                          <a id="goregister"><img src="Images/menu.png" /></a>  
            </div>-->
                      <div id="profile" class="">
                            <?php if(isset($login)) echo $login  ?>
                      </div>
                        <div id="profilesetting" class=""></div>
                        <div id="notifactions" class="dashbordcontent"></div>
                        <div id="sitesearch" class='hidden-xs'></div>
</div>
 <div id="main" class="container" >
         
        <div id="main_content" class="row" >
              <div id="right_content"  class="col-md-0"></div>
                <div id="center_content" class="col-md-12 ">
                <link rel="stylesheet" href="<?php echo base_url();  ?>assets/modules/login/css/login.css" />
<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>assets/modules/login/js/login.js"></script>
     <div class="signupcontent">
    
      <div class="col-md-8 col-sm-8 sign_adver">
          <img src="<?php echo base_url();  ?>Images/signadver.jpg" />
      </div>
      <div class="col-md-4 col-sm-4">
       
        
      <?php 
      $this->load->helper('form');     
      $this->load->library("form_validation");
      ?>     
       <?php if (validation_errors()) : ?>
          <div class="col-md-12 alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        <?php endif; ?>
   
      <?php  echo form_open('signup/signup/register', 'class="" id="registerForm" name="registerForm"'); 
    ?>                        
                <div class="form-group">
                  <?php 
                    $attributes = array(
                      'class' => 'form-control',
                      'id' => 'username',
                      'name' => 'username',
                      'placeholder' => 'Username',
                      'required' =>'required'

                     );
                     echo form_input($attributes);  ?>                
                </div>
                
              <div class="form-group">
                     <?php 
                    $attributes = array(
                      'class' => 'form-control',
                      'id' => 'email',
                      'name' => 'email',
                      'placeholder' => 'Email'

                     );
                     echo form_input($attributes);  ?>                
              </div>
              <div class="form-group">
                 <?php 
                    $attributes = array(
                      'class' => 'form-control',
                      'id' => 'regpassword',
                      'name' => 'regpassword',
                      'placeholder' => 'Password',
                      'required' =>'required'

                     );
                     echo form_password($attributes);  ?>                
                </div>
              <div class="form-group">
                 <?php 
                    $attributes = array(
                      'class' => 'form-control',
                      'id' => 'regpassword_confirm',
                      'name' => 'regpassword_confirm',
                      'placeholder' => 'Confirm Password',
                      'required' =>'required'

                     );
                     echo form_password($attributes);  ?> 
                </div>
              <div class="form-group">
                  <label>Male
                   <?php 
                    $attributes = array(
                      
                      'name'=> 'gender',
                      'id'=> 'gender',
                      'value'=> 'male',
                      'checked'=> TRUE

                     );
                     echo form_radio($attributes);  ?>  
                    </label>
                   <label>Female
                     <?php 
                    $attributes = array(
                      
                      'name'=> 'gender',
                      'id'=> 'gender',
                      'value'=> 'female'
                     );
                     echo form_radio($attributes);  ?> 
                   </label>
                </div>
               <label> 
               Birthday
              <div id="birthinfobox" class="form-inline form-group">
                <div class="form-group">
                  <?php 
                       $attributes = array(
                       'class' => 'form-control'
                     );
                      $options = array() ; 
                       for($i=0;$i<=80;$i++)
                          {     
                           $options[(date('Y')-$i)]=(date('Y')-$i); 
                          }
                                           
                      echo form_dropdown('yearcombo', $options,'',$attributes);
                   ?>                   
                  </div>
                  <div class="form-group">
                    <?php 
                           $attributes = array(
                           'class' => 'form-control'
                         );
                          $options = array() ; 
                           for($i=1;$i<=31;$i++)
                              {     
                               $options[$i]=($i); 
                              }
                                               
                          echo form_dropdown('daycombo', $options,'',$attributes);
                       ?> 
                  </div>
              
                <div class="form-group">
                      <?php 
                           $attributes = array(
                           'class' => 'form-control'
                         );
                          $options = array() ; 
                           for($i=1;$i<=12;$i++)
                              {     
                               $options[$i]=($i); 
                              }
                                               
                          echo form_dropdown('monthcombo', $options,'',$attributes);
                       ?> 
                  </div>
                 </div> 
                 </label>
                <div class="form-group">
                  <p class="text-right">
                By clicking Sign Up, you agree to our <span class="text-info"> Terms</span> and that you have 
read our <span class="text-info">Data Policy</span>, including our <span class="text-info">Cookie Use</span>.
          </p>
                </div> 
            <div class="form-group" style="text-align:center;">

            <?php 
              $attributes = array(
                  'class' => 'btn btn-synskill',
                  'id' => 'register-btn',          
                  'value' => 'Sign up'
                 );
                echo form_submit($attributes);
              ?>             
            </div>
                 <hr style="  border-top: 1px solid #afaf88;">
                 
              <strong class="text-right" >
                      <span class="text-info">Create a Page</span> for a celebrity, band or business.
                    </strong>
           
         <?php echo form_close(); ?>
         
    </div>
</div>


                </div>
                <div id="left_content" class="col-md-0" ></div>
      
        </div>
    <div id="footer" class="row"></div>
</div>


</div>


</body>

</html>




    
                   
