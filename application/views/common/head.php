<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>The Farm at San Benito - <?php echo $title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

<!-- Stylesheets
============================================= -->
<link rel="icon" type="image/png" href="favicon.png" />
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Mr+De+Haviland" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Raleway:300,100" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
<link rel="stylesheet" href="http://thefarmatsanbenito.com.iis3002.shared-servers.com/themes/encore/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="/css/encore.css" type="text/css" />
<link rel="stylesheet" href="/css/font-icons.css" type="text/css" />
<link rel="stylesheet" href="/css/animate.css" type="text/css" />
<link rel="stylesheet" href="/css/magnific-popup.css" type="text/css" />
<link rel="stylesheet" href="/css/responsive.css" type="text/css" />
<!--<link rel="stylesheet" href="/css/fullcalendar.min.css" type="text/css" />-->
<link rel="stylesheet" href="/js/fullcalendar-3.0.1/fullcalendar.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" type="text/css" />
<link rel="stylesheet" href="/css/material.css" type="text/css">
<link rel="stylesheet" href="/css/style.css" type="text/css">
<link rel="stylesheet" href="/css/sweetalert.css" type="text/css">
<link href="/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />

<!-- External JavaScripts
============================================= -->
<script type="text/javascript" src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/themes/encore/js/jquery.js"></script>
<script type="text/javascript" src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/themes/encore/js/plugins.js"></script>

<!-- Import Owl stylesheet -->
<link rel="stylesheet" href="http://thefarmatsanbenito.com.iis3002.shared-servers.com/scripts/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="http://thefarmatsanbenito.com.iis3002.shared-servers.com/scripts/owl-carousel/owl.theme.css">
<!--  jQuery 1.7+ <script src="jquery-1.9.1.min.js"></script> -->
<script src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/scripts/owl-carousel/owl.carousel.js"></script>

<?php if ($this->uri->segment(1) === null) : ?>
<style>
/*
Fade content bs-carousel with hero headers
Code snippet by maridlcrmn (Follow me on Twitter @maridlcrmn) for Bootsnipp.com
Image credits: unsplash.com
*/

/********************************/
/*       Fade Bs-carousel       */
/********************************/
.fade-carousel {
    position: relative;
    height: 100vh;
}
.fade-carousel .carousel-inner .item {
    height: 100vh;
}
.fade-carousel .carousel-indicators > li {
    margin: 0 2px;
    background-color: #f39c12;
    border-color: #f39c12;
    opacity: .7;
}
.fade-carousel .carousel-indicators > li.active {
  width: 10px;
  height: 10px;
  opacity: 1;
}

/********************************/
/*          Hero Headers        */
/********************************/
.hero {
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 3;
    color: #fff;
    text-align: center;
/*     text-transform: uppercase; */
    text-shadow: 1px 1px 0 rgba(0,0,0,.75);
      -webkit-transform: translate3d(-50%,-50%,0);
         -moz-transform: translate3d(-50%,-50%,0);
          -ms-transform: translate3d(-50%,-50%,0);
           -o-transform: translate3d(-50%,-50%,0);
              transform: translate3d(-50%,-50%,0);
}
.hero h3 {
    margin: 0;
    padding: 0;
    color: #fff;
}

.hero p {
	color: #fff;
}

.fade-carousel .carousel-inner .item .hero {
    opacity: 0;
    -webkit-transition: 2s all ease-in-out .1s;
       -moz-transition: 2s all ease-in-out .1s; 
        -ms-transition: 2s all ease-in-out .1s; 
         -o-transition: 2s all ease-in-out .1s; 
            transition: 2s all ease-in-out .1s; 
}
.fade-carousel .carousel-inner .item.active .hero {
    opacity: 1;
    -webkit-transition: 2s all ease-in-out .1s;
       -moz-transition: 2s all ease-in-out .1s; 
        -ms-transition: 2s all ease-in-out .1s; 
         -o-transition: 2s all ease-in-out .1s; 
            transition: 2s all ease-in-out .1s;    
}

/********************************/
/*            Overlay           */
/********************************/
.overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 2;
    background-color: #080d15;
    opacity: .7;
}

/********************************/
/*          Custom Buttons      */
/********************************/
.btn.btn-lg {padding: 10px 40px;}
.btn.btn-hero,
.btn.btn-hero:hover,
.btn.btn-hero:focus {
    color: #f5f5f5;
    background-color: #1abc9c;
    border-color: #1abc9c;
    outline: none;
    margin: 20px auto;
}

/********************************/
/*       Slides backgrounds     */
/********************************/
.fade-carousel .slides .slide-1, 
.fade-carousel .slides .slide-2,
.fade-carousel .slides .slide-3 {
  height: 100vh;
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
}
.fade-carousel .slides .slide-1 {
  background-image: url(/images/learn_more_about_us.jpg); 
}
.fade-carousel .slides .slide-2 {
  background-image: url(/images/programmes.jpg);
}
.fade-carousel .slides .slide-3 {
  background-image: url(/images/log_in_register.jpg);
}

/********************************/
/*          Media Queries       */
/********************************/
@media screen and (min-width: 980px){
    .hero { width: 980px; }    
}
@media screen and (max-width: 640px){
    .hero h3 { font-size: 1em; }
    
    .hero p { line-height: 1em; }    
}

</style>
<?php endif; ?>

<style type="text/css">
	
.btn-text {
  color: #69B044 !important;
  font-weight: 700 !important;
  letter-spacing: 1px;
/*  border: 1px solid #D3EAC8;*/
  padding: 8px 12px;
  font-size: 13px !important;
  position: relative;
  top: 5px;
  z-index: 3;
}
.btn-text:before {
  content: "";
  display: block;
  position: absolute;
  width: 0%;
  height: 100%;
  top: 0;
  left: 0;
  background-color:rgba(105,176,68,0.15);
  -webkit-transition: all .3s ease;
  -moz-transition: all .3s ease;
  -o-transition: all .3s ease;
  transition: all .3s ease;
  z-index: 0;
}
.btn-text:hover:before {
  width: 100%;
}
.btn-text:hover .icon-arrow {
  margin-left: 3px;
  margin-right: 3px;
}
.btn-text .icon-arrow {
  position: relative;
  top: 2px;
  margin-left: 6px;
  -webkit-transition: all .3s ease;
  -moz-transition: all .3s ease;
  -o-transition: all .3s ease;
  transition: all .3s ease;
}

#owl-awards .item{
  margin: 10px;
}
#owl-awards .item img{
  display: block;
  width: 60%;
  margin: 0 auto;
  height: auto;
}
         
/****** LOGIN MODAL ******/


.loginmodal-container {
  padding: 30px;
  width: 100% !important;
  background-color: #F7F7F7;
  margin: 0 auto;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  overflow: hidden;
}

.loginmodal-container h1 {
  text-align: center;
  font-size: 1.8em;
}

.loginmodal-container input[type=submit] {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  position: relative;
}

.loginmodal-container select {
  height: 44px;
  font-size: 16px;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 0 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.loginmodal-container input[type=text], input[type=password] {
  height: 44px;
  font-size: 16px;
  /*width: 100%;*/
  color: #000;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 8px 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  text-align: center;
}

.loginmodal-container input[type=text]:hover, input[type=password]:hover {
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.loginmodal {
  text-align: center;
  font-size: 14px;
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  height: 36px;
  padding: 0 8px;
/* border-radius: 3px; */
/* -webkit-user-select: none;
  user-select: none; */
}

.loginmodal-submit {
  /* border: 1px solid #3079ed; */
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #4d90fe;
  padding: 17px 0px;
  font-size: 14px;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
}

.loginmodal-submit:hover {
  /* border: 1px solid #2f5bb7; */
  border: 0px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
}

.loginmodal-container a {
  text-decoration: none;
  color: #666;
  font-weight: 400;
  text-align: center;
  display: inline-block;
  opacity: 0.6;
  transition: opacity ease 0.5s;
} 

.login-help{
  font-size: 12px;
}
.tab-section {
    max-width: 860px;
    margin: 0 auto;
}
.tab-amenities {
    position: relative;
    margin-top: -183px;
    z-index: 10;
}
.tab-amenities.invert {
    margin-top: 0;
    clear: both;
}
.nav-tabs-ame {
    display: -ms-flex;
    display: -webkit-flex;
    display: flex;
    -ms-flex-direction: row;
    -webkit-flex-direction: row;
    flex-direction:         row;
    -ms-flex-wrap: nowrap;
    -webkit-flex-wrap: nowrap;
    flex-wrap:         nowrap;
    border-bottom: none;
}
.nav-tabs-ame > li {
    -ms-flex: 1;
    -webkit-flex: 1;
    flex: 1;
    text-align: center;
    text-transform: uppercase;
    margin-bottom: 0;
    float: none;
}
.nav-tabs-ame > li a {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    background-color: rgba(255,255,255,.35);
    border-radius: 0;
    padding: 25px 12px;
    border: none;
    border-bottom: none;
    margin-right: 2px;
}
.nav-tabs-ame > li [class^="icon-"] {
    font-size: 300%;
}
.nav-tabs-ame > li a:hover {
    border: none;
    background-color: rgba(255,255,255,.75);
}
.nav-tabs-ame > li.active a,
.nav-tabs-ame > li.active a:hover,
.nav-tabs-ame > li.active a:focus {
    color: #68B045;
    border: none;
    border-bottom: none;
}

.nav-tabs-small > li a {
    font-size: 12px;
    line-height: 1em;
}
.invert .list-items > li {
    background-color: #EBE8E7;
    border: 1px solid transparent;
}
.invert .list-items > li .title {
    padding: 14px 35px;
}
.invert .list-items .icon-plus,
.invert .list-items .icon-minus {
    margin-top: 3px;
}
.invert .list-items > li.open {
    border-color: #EBE8E7;
}
.invert .nav-tabs-ame > li.active a,
.invert .nav-tabs-ame > li.active a:hover,
.invert .nav-tabs-ame > li.active a:focus {
    background-color: #EBE8E7;
}
.invert .nav-tabs-ame li a {
    color: #86726C;
    background-color: #F9F8F7;
}

.list-items > li {
    display: block;
    background-color: rgba(255,255,255,.7);
    position: relative;
    margin-bottom: 3px;
    cursor: pointer;
    -webkit-transition: all .4s ease-out;
    -moz-transition: all .4s ease-out;
    -o-transition: all .4s ease-out;
    transition: all .4s ease-out;
}
.list-items > li [class^='icon-'] {
    font-size: 80%;
}
.list-items .icon-plus,
.list-items .icon-minus {
    position: absolute;
    right: 35px;
    margin-top: 8px;
}
.list-items .icon-minus {
    display: none;
}
.list-items .price,
.list-items .amenity-desc .price {
    font-weight: 700;
    border-bottom: 1px solid #F9F8F7;
    margin: 8px 0;
    padding: 5px 0;
    padding-bottom: 10px;
    line-height: 1.1em;
}
.list-items .price span {
    font-size: 85%;
    font-weight: 400;
}

.list-items > li:hover {
    background-color: rgba(255,255,255,.85);
}
.list-items > li .title {
    color: #524643;
    margin: 0;
    padding: 10px 35px;
    line-height: 1.1em;
}
.list-items > li.open {
    margin-left: -15px;
    margin-right: -15px;
    background-color: #fff;
}
.list-items > li.open .icon-plus {
    display: none;
}
.list-items > li.open .icon-minus {
    display: inline-block;
}
.list-items > li.open .title {
    color: #68B045;
}
.list-items .amenity-desc {
    padding: 15px 35px;
    display: none;
    max-width: 700px;
    padding-top: 0;
}
.list-items .amenity-desc p {
    margin: 7px 0;
    line-height: 1.3em;
}
.list-items > li ul {
}

.loginmodal-container input.error,
.loginmodal-container select.error {
	border-color: red;
}


.fc table {
	margin-bottom: 0;
}

.fc-toolbar h2 {
	font-size: 20px;
}

form[name="profileForm"] input[type="text"] {
	border-color: grey;
	border-width: 1px;
}

label.error {
    border-radius: 0.25em;
    color: #ffffff;
    display: inline;
    font-size: 75%;
    font-weight: bold;
    line-height: 1;
    padding: 0.2em 0.6em 0.3em;
    text-align: center;
    vertical-align: baseline;
    white-space: nowrap;
    background-color: #f0ad4e;
}

.sweet-alert {
    z-index: 70200;
}

.sweet-overlay {
    z-index: 70100;
}
	

</style>
<!-- end: Owl stylesheet -->