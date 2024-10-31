<?php namespace seo_aiowt_namespace; ?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php include 'includes/Recipe.php'; ?> <!-- Recipe.php file contains all the SEO method classes -->

<?php require 'includes/NEXstats.php'; ?> <!-- NEXstats.php file contains all the SEO method classes -->

<?php include 'includes/RateProvider.php'; ?> <!-- Rates -->
<html>
<head>
<style>
.large-header {
	position: relative;
	width: 100%;
	background: #333;
	overflow: hidden;
	background-size: cover;
	background-position: center center;
	min-height:250px;
	
}

#large-header {
	background-image: url('http://www.metricbuzz.com/img/embed/space.jpg');
}
.main-title {
	position: absolute;
	margin: 0;
	padding: 0;
	color: #f9f1e9;
	text-align: center;
	top:30%;
	left: 50%;
	-webkit-transform: translate3d(-50%,-50%,0);
	transform: translate3d(-50%,-50%,0);
}

.demo-1 .main-title {
	text-transform: uppercase;
	font-size: 4.2em;
	letter-spacing: 0.1em;
}

.main-title .thin {
	font-weight: 200;
}

@media only screen and (max-width : 768px) {
	.demo-1 .main-title {
		font-size: 3em;
	}
}
.btn-success {
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
    background-color: #02752e;
    background-image: -moz-linear-gradient(top,#02752e,#02752e);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#02752e),to(#02752e));
    background-image: -webkit-linear-gradient(top,#02752e,#02752e);
    background-image: -o-linear-gradient(top,#02752e,#02752e);
    background-image: linear-gradient(to bottom,#02752e,#02752e);
    background-repeat: repeat-x;
    border-color: #02752e #02752e #02752e;
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
}
.jumbotron {
   
    text-align: center;
}
#submit:hover {
	background: #000;
}

</style>

<script src="<?php echo plugins_url('js/TweenMax.min.js', __FILE__ ) ?>"></script>
</head>
<body>
<div class="wrap">

<!-- Start of Canva Animation line -->
<div id="large-header" class="large-header">

<canvas id="demo-canvas" ></canvas>
<div id="SEO-embed" class="main-title" >
<div class="jumbotron"  >
<img src="<?php echo plugins_url('img/emoji-pink-face.gif', __FILE__ ) ?>" style="position:relative; top:10px;" width="48" height="48" alt="emoji pink face">
	<form  id="website-form"  method="POST" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>"  >
	
	<div class="input-append control-group">
		<input class="website-input" type="text" name="domain" placeholder="Enter domain to investigate..." style="width:210px;height:45px;">
		<?php wp_nonce_field( 'seo_aiowt_admin' ); ?>
		<input type="submit" name="submit" id="submit" value="Get Report" onclick="waitanimation2()" class="btn-success" style="font-size:18px;width:105px;height:45px;position:relative; top:1px;left:-5px;">
	<img src="<?php echo plugins_url('img/LoadingAnimation.gif', __FILE__ ) ?>" id="loading_wait_image" style="display:none;position:relative; left:230px; width:70px; height:50px;">
	</div>
	</form>
	
</div>
</div>
</div>
<script>
function waitanimation2() {
	
	document.getElementById("loading_wait_image").style.display="block";
}

</script>
	<?php 


		function check($advice){
			if($advice=="success"){
				?>
				<img style="float:left; margin-right:10px; margin-top:10px;" src="<?php echo plugins_url('img/success.png', __FILE__ ) ?>" />
				
				<?php
				
			} else if($advice=="error"){
			
			?>
			<img style="float:left; margin-right:10px;margin-top:10px;" src="<?php echo plugins_url('img/error.png', __FILE__ ) ?>" />
			<?php
			}else{ ?>
			<img style="float:left; margin-right:10px;margin-top:10px;" src="<?php echo plugins_url('img/warning.png', __FILE__ ) ?>" />
			<?php 
			
		}}
		
			function check_advice($advice){
			if($advice=="success"){
				
				$file="Success!";
				echo "<td style='border:1px solid #02752e;width:50%;color:#02752e;font-weight:bold;'>".$file."</td>";
			} else if($advice=="error"){
				$file="Check the author site for advice!";
				echo "<td style='border:1px solid #02752e;width:50%;color:red;font-weight:bold;'><a href='http://goo.gl/Jz0HPD'>".$file."</a></td>";
			} else {
				$file="Check the author site for advice!";echo "<td style='border:1px solid #e68a00;width:50%;color:#02752e;font-weight:bold;'><a href='http://goo.gl/Jz0HPD'>".$file."</a></td>";
			}
		}
		if(isset($_POST["domain"]))
		{
?> <style> #large-header{height: 200px !important;} </style>  <?php
			check_admin_referer( 'seo_aiowt_admin');
			
			$url = $_POST["domain"];
			$url = 'http://'.preg_replace('!^https?://!i', '', $url);
			$url = parse_url( $url,PHP_URL_HOST);

			if ( preg_match('/\s/',$url) )
				die("<b> The domain must not contain whitespaces</b>");
			if (strlen($url) <3) 
				die("<b> Please enter a domain name</b>");

			$rateprovider = new RateProvider();

			echo "<b>You investigated <i>". $url."</i></b></br>";

	//////////////DOCUMENT /////////////////////
	?>
	<br><br>
			<img style="float:left; margin-right:10px;" src="<?php echo plugins_url('img/document-design.png', __FILE__ ) ?>" width='64' height='64'/><h1><b> DOCUMENT </b></h1>
			
			
				<img id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="seo report Document tooltips" data-bd-imgshare-binded="1" title="
					Use most current version HTML5 code when design your website pages">
			</br></br><hr>
			
			<table style="width:100%;border:1px solid #02752e;">
			<!--<tr style='border:1px solid #02752e;width:50%;'>-->
			
	
				<?php
			//////////////Doctype /////////////////////
			
			// $advice = $rateprovider -> addCompare('doctype', $document['doctype']);
			// echo "<td style='border:1px solid #02752e;width:50%;'>";
			// check($advice);
			// echo "<h3 style='float:left;'>Doctype</h3></td>";
			// check_advice($advice);
			// echo "</tr>";
	
			//////////////robots.txt /////////////////////
			?>
		
	<!--		<tr  style='border:1px solid #02752e;width:50%;'><td  style='border:1px solid #02752e;width:50%;'><img style="float:left;margin-top:15px;margin-right:10px;" id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="robots.txt tooltips" data-bd-imgshare-binded="1" title=" 
					The robots.txt file is very important to tell search engines certain rules and allow them to understand your site behaviors immediately.
					You can set up your own rules to tell search engines to inder your site completely or block certain files.
					You can find the robots.txt file in this file path yoursite.com/robots.txt, 
					If you can't find the file on your site or see the message of Error 404 - Not Found, then you need to create one by using the robots file generator tool here.
				">
				<?php
			echo "<h4 style='float:left;'> Robots.txt </h4></td>";
			$url_aux = "http://".$url;
			$robots_txt = @file_get_contents("$url_aux/robots.txt");
			if($robots_txt != ""){
				$robot_file = "Yes, robots.txt file found at ";
				$robot = "$url/robots.txt";

			}else{
				$robot_file = "No, robots.txt file not found";
				$robot = "";                
			} 
			echo "<td  style='border:1px solid #02752e;width:50%;'>".$robot_file." ".$robot."</td></tr>";
			?>
	-->	
				<tr  style='border:1px solid #02752e;width:50%;'><td  style='border:1px solid #02752e;width:50%;'>
				<img style="float:left;margin-top:15px;margin-right:10px;"  id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="robots.txt tooltips" data-bd-imgshare-binded="1" title=" 
					The sitemap.xml file allows search engines to understand your site full page structure in turn of faster indexing all your page urls.
					</br></br>
					You can find the sitemap.xml file in this file path yoursite.com/sitemap.xml, 
					If you can\'t find the sitemap.xml file on your site, then you need to create one by using the sitemap file generator tool here.
					 ">
				<?php
			//////////////Sitemap /////////////////////
			echo "<h4> Sitemap file?</h4></td> ";
			$url_aux = "http://".$url;
			$_headers  =  @get_headers("$url_aux/sitemap.xml", 1);
			if (preg_match('/^HTTP\/\d\.\d\s+(200|301|302)/', $_headers[0])){
			   $sitemap_xml = "YES, sitemap file found."; 
			}else{
				$sitemap_xml = "NO, sitemap file not found!";
			} 
			echo "<td  style='border:1px solid #02752e;width:50%;'>" .$sitemap_xml."</td></tr>" ;  
				?>
				<tr>
			
<?php
			
			
			//////////////Encoding /////////////////////
			
			$advice = $rateprovider -> addCompare('charset', $document['charset']);
			echo "<tr  style='border:1px solid #02752e;width:50%;'><td  style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo "<h3 style='float:left;'>Encoding</h3></td>";
			check_advice($advice);
			echo "</tr>";

			//////////////W3c Validity /////////////////////
			
			$advice = $rateprovider -> addCompare('w3c', $w3c['valid']);
			echo "<tr  style='border:1px solid #02752e;width:50%;'><td  style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo "<h3 style='float:left;'>W3c Validity</h3></td>";
			check_advice($advice);
			echo "</tr>";
			

			//////////////Email Privacy /////////////////////
		
			$advice = $rateprovider -> addCompare('noEmail', !$isseter['email']);
			
			echo "<tr  style='border:1px solid #02752e;width:50%;'><td  style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo "<h3 style='float:left;'> Email Privacy</h3></td>";
			check_advice($advice);
			echo "</tr>";
			//////////////Deprecated HTML /////////////////////
		
			$advice = $rateprovider -> addCompare('noDeprecated', empty($content['deprecated']));
			
			echo "<tr  style='border:1px solid #02752e;width:50%;'><td  style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo "<h3 style='float:left;'> Deprecated HTML</h3></td>";
			check_advice($advice);
			echo "</tr>";

			//////////////Speed Tips /////////////////////
			
				?>
		</table>


			<h3 style="float:left;">Speed tips</h3>
				<img style="float:left; margin-top:10px;" id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="seo report Speed Tips tooltips" data-bd-imgshare-binded="1" title="
				Your webpages loading speed is critical to your search engines ranking, Google will consider your page speed when come to rank your site for higher position.
				You should not install too much third party scripts that cause your webpages loading too slow, and you should not have too much in line CSS code, or Javascript files in a single page that cause the page loading speed too slow.
				We have layout the 4 sections in the right area when you should fix your page speed suggestions for better website performance and search engines ranking.
				   ">
				  
				   <table style="border:1px solid #02752e; width:100%;">
				<?php
				
			$advice = $rateprovider -> addCompare('noDeprecated', empty($content['deprecated']));
	
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo " Nested Tables Advice</td>";
			check_advice($advice);
			echo "</tr>";
			
			$advice = $rateprovider -> addCompare('noInlineCSS', !$isseter['inlinecss']);
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo " Inline CSS advice</td>";
			check_advice($advice);
			echo "</tr>";
		
			$advice = $rateprovider -> addCompareArray('cssCount', $document['css']);
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo "CSS count advice</td>";
			check_advice($advice);
			echo "</tr>";
		
			$advice = $rateprovider -> addCompareArray('jsCount', $document['js']);
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'>";
			check($advice);
			echo " JS count advice</td>";
			check_advice($advice);
			echo "</tr>";

	//////////////Marketing /////////////////////		
			?>
		</table>
		
			<hr>
				<img style="float:left; margin-right:10px;" src="<?php echo plugins_url('img/SEO-marketing.png', __FILE__ ) ?>" width='64' height='64'/><h1><b> MARKETING </b></h1>
			
			
				<img id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="seo report SEO marketing tooltips" data-bd-imgshare-binded="1" title="
				Share with you different effective marketing techniques &amp; Tools, bring targeted traffic to your site, increase more social media like signals, rank higher on your Google page search results, boost your site Alexa ranking.

				   ">
			</br></br><hr>
				
				
				  
	<table style="border:1px solid #02752e; width:100%;">
			<?php
			
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> Facebook Shares </td><td style='border:1px solid #02752e;'>". Recipe::getFacebookShareCount($url)."</td></tr>";
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> Twitter Shares </td><td style='border:1px solid #02752e;'>". Recipe::getTwitterShareCount($url)."</td></tr>";
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> GooglePlus Shares </td><td style='border:1px solid #02752e;'>". Recipe::getGooglePlusShareCount($url)."</td></tr>";
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> Pinterest Shares </td><td style='border:1px solid #02752e;'>". Recipe::getPinterestShareCount($url)."</td></tr>";
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> Linkedin Shares </td><td style='border:1px solid #02752e;'>". Recipe::getLinkedInShareCount($url)."</td></tr>";
			$NexStats = new NEXStats($url);
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> StumbleUpon Shares </td><td style='border:1px solid #02752e;'> ". $NexStats->getStumbleUponShares()."</td></tr>";
			unset($NexStats);
			?>
	</table>
<?php
	//////////////Site Ranking /////////////////////
			//echo "</br></br><b> SITE RANKING </b>";
?>			
	
				<hr>
				<img style="float:left; margin-right:10px;" src="<?php echo plugins_url('img/website-ranking.png', __FILE__ ) ?>" width='64' height='64'/><h1><b> SITE RANKING </b></h1>
			
			
				<img id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="seo report website ranking tooltips" data-bd-imgshare-binded="1" title="
				Check your site Google PageRank, Alexa ranking, and other famous site ranking reports, advices for you.
				 ">
			</br></br><hr>
			
				 <table style="border:1px solid #02752e; width:100%;">
				<?php

			$NexStats = new NEXStats($url);
			echo "<tr style='border:1px solid #02752e;'><td style='width:50%; border:1px solid #02752e;'> Google PageRank </td><td style='width:50%; border:1px solid #02752e;'>". $NexStats->getGooglePR();
			unset($NexStats);
			?>
				<img id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="Google Page rank advice" data-bd-imgshare-binded="1" title="
				Conduct a major keywords search related to your business on Google, find similar sites with higher Pagerank and decent traffic, 
				Then find a way to build backlinks around those sites, the more you build backlinks with, the higher Google Pagerank you will achieve. 
				For smaller sites, if you can climb up to 3 points Pagerank from Google, your business will be much more successful in public eyes.
				 ">
				 </td></tr>
				 
			<?php
			$NexStats = new NEXStats($url);
			echo "<tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'> Alexa Backlinks </td><td style='width:50%;border:1px solid #02752e;'>". $NexStats->getAlexaBacklinks()."</td></tr>";
			unset($NexStats);

			$NexStats = new NEXStats($url);
			echo "<tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'> Alexa Ranking </td><td style='width:50%;border:1px solid #02752e;'>". $NexStats->getAlexaRank()."</td></tr></table>";
			unset($NexStats);

			$accessID = "mozscape-2d37d2426f";
			$secretKey = "1676024762c840873b92709a4d6c1c22";
			$NexStats = new NEXStats($url);
			echo " <br><br><table style='border:1px solid #02752e; width:100%;'><tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'> Check Domain Authority</td><td style='width:50%;border:1px solid #02752e;'>" . $NexStats->domainAuthority($accessID,$secretKey)."</td></tr>";
			unset($NexStats);

			$NexStats = new NEXStats($url);
			$alexaRank = $NexStats->getAlexaRank();
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> Daily Unique Visitor</td><td style='width:50%;border:1px solid #02752e;'> ".  $NexStats->dailyUniqueVisitors($alexaRank)."</td></tr>";
			unset($NexStats);

			$NexStats = new NEXStats($url);
			$googlePagerank = $NexStats->getGooglePagerank();
			$alexaRank = $NexStats->getAlexaRank();
			$dailyUniqueVisitors = $NexStats->dailyUniqueVisitors($alexaRank);
			echo "<tr style='border:1px solid #02752e;'><td style='border:1px solid #02752e;width:50%;'> Daily Page Views </td><td style='width:50%;border:1px solid #02752e;'>". $NexStats->dailyPageViews($googlePagerank,$dailyUniqueVisitors)."</td></tr></table>";
			unset($NexStats);

			echo "<br><Br><table style='border:1px solid #02752e; width:100%;'><tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'>  Google Page Speed Score Is </td><td style='width:50%;border:1px solid #02752e;'>";
			$NexStats = new NEXStats($url);
			echo $NexStats->getSpeedScore();
			echo "</td></tr>";
			unset($NexStats);

			$NexStats = new NEXStats($url);
			echo "<tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'>  Google Indexed Pages Are </td><td style='width:50%;border:1px solid #02752e;'>". $NexStats->getGoogleCount()."</td></tr>";
			//echo "<tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'> Bing Indexed Pages Are </td><td style='width:50%;border:1px solid #02752e;'>".$NexStats->getBingCount()."</td></tr>";
			echo "<tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'> Yahoo Indexed Pages Are </td><td style='width:50%;border:1px solid #02752e;'>".$NexStats->getYahooCount()."</td></tr></table>";
			unset($NexStats);


	//////////////Site Security/////////////////////
			//echo "</br></br><b> SITE SECURITY </b>";
?>
<br>
<hr>
				<img style="float:left; margin-right:10px;" src="<?php echo plugins_url('img/site-security.png', __FILE__ ) ?>" width='64' height='64'/><h1><b> SITE SECURITY </b></h1>
			
			
			
			</br></br><hr>
<?php
			$NexStats = new NEXStats($url);
			echo "<br><table style='border:1px solid #02752e; width:100%;'><tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'> Check Google Safe Browsing </td><td style='width:50%;border:1px solid #02752e;'> ". (($NexStats->getGoogleSafeBrowsingCheck()) ? "Safe":"Not Safe")."</td></tr>";
			echo "<tr style='border:1px solid #02752e;'><td style='width:50%;border:1px solid #02752e;'> Check spamhaus.org Blocklist </td><td style='width:50%;border:1px solid #02752e;'>  ". (($NexStats->getSpamhausCheck()) ? "Safe":"Blocked");
				?>
					<img id="question-mark" src="<?php echo plugins_url( 'img/tooltips-16.png', __FILE__ )?>" rel="tooltip" alt="site security spamhaus advice" data-bd-imgshare-binded="1" title="
					Spamhaus tracks the Internet's worst Spammers, known Spam Gangs and Spam Support Services, 
					and works with ISPs and Law Enforcement Agencies to identify and remove persistent spammers from the Internet.
					">
					</td></tr></table>
				<?php
			unset($NexStats);


		}
	?>
</div>

<!-- Start of Canva Animation line JS code -->
<script>
(function() {

    var width, height, largeHeader, canvas, ctx, points, target, animateHeader = true;

    // Main
    initHeader();
    initAnimation();
    addListeners();

    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: width/2, y: height/2};

        largeHeader = document.getElementById('large-header');
        largeHeader.style.height = height+'px';

        canvas = document.getElementById('demo-canvas');
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext('2d');

        // create points
        points = [];
        for(var x = 0; x < width; x = x + width/20) {
            for(var y = 0; y < height; y = y + height/20) {
                var px = x + Math.random()*width/20;
                var py = y + Math.random()*height/20;
                var p = {x: px, originX: px, y: py, originY: py };
                points.push(p);
            }
        }

        // for each point find the 5 closest points
        for(var i = 0; i < points.length; i++) {
            var closest = [];
            var p1 = points[i];
            for(var j = 0; j < points.length; j++) {
                var p2 = points[j]
                if(!(p1 == p2)) {
                    var placed = false;
                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }

                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in points) {
            var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
            points[i].circle = c;
        }
    }

    // Event handling
    function addListeners() {
        if(!('ontouchstart' in window)) {
            window.addEventListener('mousemove', mouseMove);
        }
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    }

    function mouseMove(e) {
        var posx = posy = 0;
        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        }
        else if (e.clientX || e.clientY)    {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        target.x = posx;
        target.y = posy;
    }

    function scrollCheck() {
        if(document.body.scrollTop > height) animateHeader = false;
        else animateHeader = true;
    }

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        largeHeader.style.height = height+'px';
        canvas.width = width;
        canvas.height = height;
    }

    // animation
    function initAnimation() {
        animate();
        for(var i in points) {
            shiftPoint(points[i]);
        }
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in points) {
                // detect points in range
                if(Math.abs(getDistance(target, points[i])) < 4000) {
                    points[i].active = 0.3;
                    points[i].circle.active = 0.6;
                } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                    points[i].active = 0.1;
                    points[i].circle.active = 0.3;
                } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                    points[i].active = 0.02;
                    points[i].circle.active = 0.1;
                } else {
                    points[i].active = 0;
                    points[i].circle.active = 0;
                }

                drawLines(points[i]);
                points[i].circle.draw();
            }
        }
        requestAnimationFrame(animate);
    }

    function shiftPoint(p) {
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
            onComplete: function() {
                shiftPoint(p);
            }});
    }

    // Canvas manipulation
    function drawLines(p) {
        if(!p.active) return;
        for(var i in p.closest) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(p.closest[i].x, p.closest[i].y);
            ctx.strokeStyle = 'rgba(156,217,249,'+ p.active+')';
            ctx.stroke();
        }
    }

    function Circle(pos,rad,color) {
        var _this = this;

        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.draw = function() {
            if(!_this.active) return;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(156,217,249,'+ _this.active+')';
            ctx.fill();
        };
    }

    // Util
    function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
    }
    
})();
</script>

<!-- END of Canva Animation JS code -->



