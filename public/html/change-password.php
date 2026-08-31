<!doctype html>
<html lang="en">

<head>
  <title>
    Salonegoo
  </title>
  <!--== META TAGS ==-->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="theme-color" content="#76cef1" />
  <meta property="og:image" content="" />
  <meta name="description" content="">
  <meta name="keyword" content="">
  <!--== FAV ICON(BROWSER TAB ICON) ==-->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!--== GOOGLE FONTS ==-->
  <link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">
  <!--== WEB ICON FONTS ==-->
  <link rel="preload" as="font" href="css/icon.woff2" type="font/woff2" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--== CSS FILES ==-->
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/theme-color.php">
  <link rel="stylesheet" href="css/awesome.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="css/performance.css">
 <link rel="stylesheet" type="text/css" href="css/profile.css"> 
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">

  <!--  <link rel="stylesheet" href="css/fonts.css"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
  <!--    Google Analytics Code Starts-->
  <!-- Global site tag (gtag.js) - Google Analytics -->

  <style type="text/css">
    .full-bot-book {
      display: none;
    }
    .v3-list-ql {

    }
  </style>


  <style>

  </style>




</head>

<body>
  <!--    Google Ad Sense Code Starts-->
  <!--    Google Ad Sense Code Ends-->
  <!-- Preloader -->
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
  <?php include('includes/header.php'); ?>
  <!-- START -->



 <div class="m-container">
     <div class="container">
        <div class="row">
          <div class="col-sm-4">
             <?php include('includes/profile-nav.php');?>
          </div><!-- sm4 -->
          <div class="col-sm-8 pl-3">
               <div class="panel-group">
                 <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pds">
                          <h3>Change Password </h3>
                          <!-- <label>Saved</label> -->
                        </div>
                    </div>
                    <div class="panel-body">
                        
                        <form>
                          <div class="p-forme">
                            <fieldset>
                              <div class="pf-divs">
                                <legend>New Password</legend>
                                </div>
                                <input type="password" class="form-control">
                           </fieldset>
                         </div>
                         <div class="p-forme">
                            <fieldset>
                              <div class="pf-divs">
                                <legend>Re-type new password</legend> 
                                </div>
                                <input type="text" class="form-control">
                           </fieldset>
                         </div>
                        
                             

                               <div class="p-forme">
                                <button type="submit" class="sal-save">Change</button>
                               </div>
                        </form>
                            <div class="text-center"><a href="#" style="color: green;font-weight: 600;font-size: 13px;">Forgot Password</a></div>
                    </div><!-- panl-body -->
             </div>

            </div>
               
          </div><!-- sm8 -->
        </div>
     </div>


  


 




 

 


  


</div>


  <?php include('includes/footer.php'); ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/select-opt.js"></script>
  <script type="text/javascript">
    var webpage_full_link = '';
  </script>
  <script type="text/javascript">
    var login_url = 'login?src=jobs/';
  </script>
  <script src="js/slick.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/custom_validation.js"></script>


  

  <script type="text/javascript">
    $('.toc-list a').on('click',function(){
        datasText = $(this).attr('data-name');
        // console.log(datasText);
        $("html, body").animate({ scrollTop: $('#'+datasText).offset().top - 100}, 1000);
    });
  </script>
 

  <!-- MDB -->
</body>

</html>