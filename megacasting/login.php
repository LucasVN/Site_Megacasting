<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Megacasting | Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/megacasting.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript">
    //Login form
    $(document).ready(function() {
        // Login form
        $("#connection_login").click(function() { 
            var proceed = true;
            $("#login input[required=true]").each(function(){
                $(this).css('border-color',''); 
                if(!$.trim($(this).val())){
                    $(this).css('border-color','red');
                    proceed = false;
                }
            });
            if(proceed){
                post_data = {
                    'login'   : $('input[name=login]').val(), 
                    'password'  : $('input[name=password]').val(), 
                };
                    
                //Ajax post data to server
                $.post('ajax_login.php', post_data, function(response){  
                    if(response.type == 'error'){ 
                        output = '<div class="error">'+response.text+'</div>';
                    }else{
                        output = '<div class="success">'+response.text+'</div>';
                        //reset values in all input fields
                        $("#login  input[required=true]").val('');
                        setTimeout("window.location.href='index.php' ", 2000);
                    }
                    $("#login_results").hide().html(output).slideDown();
                }, 'json');
            }
        });
            
        $("#login  input[required=true]").keyup(function() { 
            $(this).css('border-color',''); 
            $("#result").slideUp();
        });
    });
</script>
</head><!--/head-->
<body>

    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-4">
                        <div class="top-number"><p><i class="fa fa-phone-square"></i>  +0123 456 70 90</p></div>
                    </div>
                    <div class="col-sm-6 col-xs-8">
                        <div class="social">
                            <?php
                                require('auth.php');
                                if(Auth::islog()){
                                    echo '<a href="private.php">Mon compte</a>';
                                }else{
                                    echo '<a href="login.php">Se connecter</a>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><images src="images/logo.png" alt="logo"></a>
                </div>
                
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Accueil</a></li>
                        <li><a href="services.php">Déposer offre</a></li>
                        <li><a href="contact-us.php">Contact</a></li>                        
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
        
    </header><!--/header-->

    <div id="login" class="spacer form-style">
        <div class="container contactform center" id="contact_body">
            <h2 class="text-center wowload fadeInUp title_b">Se connecter</h2>
            <div id="login_body" class="row wowload fadeInLeftBig">      
              <div class="col-sm-6 col-sm-offset-3 col-xs-12">  
                <input class="login_body" type="text" required="true" placeholder="Identifiant" id="login" name="login">
                <input class="login_body" type="password" required="true" placeholder="Password" id="password" name="password">
                <a href="register.php">Vous n'êtes pas encore inscrit ?</a><br/>
                <a href="wrong.php">Vous avez oubliez votre mot de passe ?</a><br/>
                <button id="connection_login" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Se connecter</button>
              </div>
            </div>
        </div>
      <br/>
      <div id="login_results"></div>
    </div>
<!--Contact Ends-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2015 <a target="_blank" href="#" title="Megacasting, votre réussite, notre plus belle aventure">MegaCasting</a>. All Rights Reserved.
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="contact-us.php">Contactez nous</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/wow.min.js"></script>
</body>
</html>