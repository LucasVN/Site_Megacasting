<?php session_start(); 

?>
<?php require_once 'connexion.php'; 
 if(isset($_SESSION['Auth']['level_information'])){
    $level_information = $_SESSION['Auth']['level_information'];
}else{
    $level_information = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Megacasting | Votre aventure commence ici</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/megacasting.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
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
        $(document).ready(function() {
            //Login form
            $("#search_index").click(function() {                  
                if($("#search_index").val() == null){
                    proceed = false;
                }
                if(proceed){
                    post_data = {
                        'recherche'   : $('input[name=search]').val(), 
                    };
                        
                    //Ajax post data to server
                    $.post('ajax_search.php', post_data, function(response){  
                    if(response.type == 'error'){ 
                      output = '<div class="error">'+response.text+'</div>';
                    }else{
                        output = '<div class="success">'+response.text+'</div>';
                        setTimeout("window.location.href='index.php' ", 4000);
                      //reset values in all input fields
                      $("#registers  input[required=true], #registers textarea[required=true]").val(''); 
                    }
                    $("#results").hide().html(output).slideDown();}, 'json');
                }
            });
                
            $("#registers input[required=true], #registers textarea[required=true]").keyup(function() { 
                $(this).css('border-color',''); 
                $("#results").slideUp();
            });
        });
    </script>
</head><!--/head-->

<body class="homepage" onLoad="trier('1')">
    <!-- MASQUE -->
    <div id="mask"></div>
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
                            <div class="search">
                                <input type="text" name="search" class="search-form" id="search" autocomplete="off" placeholder="Search" required="true" onchange="search(this.value)">
                                <i class="fa fa-search"></i>
                           </div>
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

    <section id="feature" >
        <div class="container">
           <div class="center wow fadeInDown">
                <h2>Megacasting</h2>
                <p class="lead">MegaCasting vous accompagne et vous apporte un soutien en administration, en diffusion, vous met à disposition du matériel et des outils de travail, vous accompagne sur les dates de tournées, gère vos diffusions et vos communications. MegaCasting est devenu un véritable partenaire pour ces compagnies et ces artistes.</p>
            </div>

            <div class="row">
                <div class="features">
                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-bullhorn"></i>
                            <h2>Annonce en temps réel</h2>
                            <h3>Des offres pourront vous correspondre</h3>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-comments"></i>
                            <h2>Discutez avec des professionels</h2>
                            <h3>Toutes offres sont vérifiés et validés</h3>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-cogs"></i>
                            <h2>Services personnalisés</h2>
                            <h3>Profitez d'une expérience intuitive</h3>
                        </div>
                    </div><!--/.col-md-4-->
                </div><!--/.services-->
            </div><!--/.row-->    
        </div><!--/.container-->
        <div class="row wowload fadeInLeftBig" style="text-align: center;">
            <?php if ($level_information == 2) { ?>
                <a href="download.php?id=1">
                    <input type="button" id="download_xml" class="btn btn-primary" value="Récupérer toutes les offres en XML">
                 </a>
            <?php } ?>   
        </div>
    </section><!--/#feature-->
    
    <section id="post">      
        <div class="container_post">
        	</br>
            <label for="tri">Trier les castings par : </label>
            <select id="tri" name="tri" onChange="trier(this.value)">
                <option value="1">Tout</option>
                <option value="2">Musique</option>
                <option value="3">Cinéma</option>
                <option value="4">Théâtre</option>
                <option value="5">Dance</option>
                <option value="6">Spectacle</option>
            </select>
            </p>

            <div id="resultat_annonce"></div>

        </div>
    </section><!--/#middle-->

    </br>
    <section id="conatcat-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="media contact-info wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="pull-left">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="media-body">
                            <h2>Vous avez des questions ou besoin d'aide ?</h2>
                            <p>Nous pouvons surement vous aidez et sommes à votre disposition, contactez nous via le formulaire de contact ou au +0123 456 70 80</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->    
    </section><!--/#conatcat-info-->

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
    <script type="text/javascript">
    function trier(par){
        var xhr;
        if(window.XMLHttpRequest){
            xhr=new XMLHttpRequest();
        }else{
            xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
         
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                document.getElementById("resultat_annonce").innerHTML = xhr.responseText;
            }
        }
         
        par = encodeURIComponent(par);
        xhr.open("GET","ajax_tri.php?tri="+par,true);
        xhr.send();
    }
    function search(par){
        var xhr;
        if(window.XMLHttpRequest){
            xhr=new XMLHttpRequest();
        }else{
            xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
         
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                document.getElementById("resultat_annonce").innerHTML = xhr.responseText;
            }
        }
         
        par = encodeURIComponent(par);
        xhr.open("GET","ajax_search.php?search="+par,true);
        xhr.send();
    }
    </script>
</body>
</html>