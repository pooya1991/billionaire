<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="hooman.qorbani">
    <link rel="icon" href="<?php echo base_url();  ?>images/favicon.ico" type="image/x-icon">
    <title>SynSkill | Synergize Skill</title>

    <!-- Bootstrap Core CSS -->
   <link href="<?php echo base_url();  ?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();  ?>assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <style type="text/css">
        /*!
 * Start Bootstrap - Stylish Portfolio Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

/* Global Styles */

html,
body {
    width: 100%;
   
}

body {
    font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
    background: url(<?php echo base_url();  ?>img/bg.png)   ;
}

.text-vertical-center {
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}

.text-vertical-center h1 {
    margin: 0;
    padding: 0;
    font-size: 4.5em;
    font-weight: 700;
}
a{  color: #501145; }
a:hover , a:active , a:visited{  color: #963986; }
/* Custom Button Styles */

.btn-dark {
    border-radius: 0;
    color: #fff;
    background-color: #501145;
}

.btn-dark:hover,
.btn-dark:focus,
.btn-dark:active {
    color: #fff;
    background-color: rgba(0,0,0,0.7);
}

.btn-light {
    border-radius: 0;
    color: #333;
    background-color: rgb(255,255,255);
}

.btn-light:hover,
.btn-light:focus,
.btn-light:active {
    color: #333;
    background-color: rgba(255,255,255,0.8);
}

/* Custom Horizontal Rule */

hr.small {
    max-width: 100px;
}

/* Side Menu */

#sidebar-wrapper {
    z-index: 1000;
    position: fixed;
    right: 0;
    width: 250px;
    height: 100%;
    margin-right: -250px;
    overflow-y: auto;
    background: #222;
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}

.sidebar-nav {
    position: absolute;
    top: 0;
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.sidebar-nav li {
    text-indent: 20px;
    line-height: 40px;
}

.sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #999;
}

.sidebar-nav li a:hover {
    text-decoration: none;
    color: #fff;
    background: rgba(255,255,255,0.2);
}

.sidebar-nav li a:active,
.sidebar-nav li a:focus {
    text-decoration: none;
}

.sidebar-nav > .sidebar-brand {
    height: 55px;
    font-size: 18px;
    line-height: 55px;
}

.sidebar-nav > .sidebar-brand a {
    color: #999;
}

.sidebar-nav > .sidebar-brand a:hover {
    color: #fff;
    background: none;
}

#menu-toggle {
    z-index: 1;
    position: fixed;
    top: 0;
    right: 0;
}

#sidebar-wrapper.active {
    right: 250px;
    width: 250px;
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}

.toggle {
    margin: 5px 5px 0 0;
}

/* Header */

.header {
    display: table;
    position: relative;
    width: 100%;
    height: 100%;
    
    
}

/* About */

.about {
    padding: 50px 0;
}

/* Services */

.services {
    padding: 50px 0;
}

.service-item {
    margin-bottom: 30px;
}

/* Callout */

.callout {
    display: table;
    width: 100%;
    height: 400px;
    color: #fff;
    background: url(<?php echo base_url();  ?>img/callout.jpg) no-repeat center center scroll;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -o-background-size: cover;
}

/* Portfolio */

.portfolio {
    padding: 50px 0;
}

.portfolio-item {
    margin-bottom: 30px;
}

.img-portfolio {
    margin: 0 auto;
}

.img-portfolio:hover {
    opacity: 0.8;
}

/* Call to Action */

.call-to-action {
    padding: 50px 0;
}

.call-to-action .btn {
    margin: 10px;
}

/* Map */

.map {
    height: 500px;
}

@media(max-width:768px) {
    .map {
        height: 75%;
    }
}

/* Footer */


    </style>
   

</head>

<body>

   

    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
            <img style="width: 50%;" src="<?php echo base_url();  ?>img/wlc.png">
            <!-- <br/> -->
            <!-- <a href="http://synskill.com/beta/" class="btn btn-dark btn-lg">See Beta version</a> -->
        </div>

    </header>
    <!-- Main contect -->
    <main class="container" style="text-align: center;">
        <article class="col-md-offset-4 col-xs-offset-3 col-lg-offset-4 col-xs-6 col-md-4 col-lg-4">
            <?php echo form_open(base_url('welcome'),'calss=form-inline') ?>
                  <div  class="form-group row">
                    <label class="sr-only" for="exampleInputEmail3">Email address</label>
                    <input type="email" name='email' class="form-control" id="exampleInputEmail3" placeholder="Email">
                  </div>
                  <button type="submit" class="btn btn-default">Send</button>
                </form>
        </article>
    </main>
   

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4><strong></strong>
                    </h4>
                    
                    
                    <br>
                    <ul class="list-inline">
                        <li style="font-size: 50px;">
                            <a href="https://www.facebook.com/SynSkill-1657276531212505/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="font-size: 50px;">
                           <a href="https://www.instagram.com/synskill/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="font-size: 50px;">
                            <a href="http://telegram.me/synskill" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                    <hr class="small">
                    <ul class="list-unstyled">
                        <!-- <li><i class="fa fa-phone fa-fw"></i> (123) 456-7890</li> -->
                        <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:info@synskill.com">info@Synskill.com</a>
                        </li>
                    </ul>
                    <p class="text-muted">Copyright &copy; Synskill.com 2016</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
