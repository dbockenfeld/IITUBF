<html lang="en">
	<head>
		<title>University Bible Fellowship at IIT</title>
		<link type="text/css" rel="stylesheet" href="<? echo $root;?>../iitubf.css"/>
		<link type="text/css" rel="stylesheet" href="styles/universal.css"/>
		<link type="text/css" rel="stylesheet" href="styles/home.css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
		<script src="js/nivo-slider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
		
		<script type="text/javascript">
		
		function theRotator() {
			//Set the opacity of all images to 0
			$('div#rotator ul li').css({opacity: 0.0});
			
			//Get the first image and display it (gets set to full opacity)
			$('div#rotator ul li:first').css({opacity: 1.0});
				
			//Call the rotator function to run the slideshow, 6000 = change to next image after 6 seconds
			setInterval('rotate()',10000);
			
		}
		
		function rotate() {	
			//Get the first image
			var current = ($('div#rotator ul li.show')?  $('div#rotator ul li.show') : $('div#rotator ul li:first'));
		
			//Get next image, when it reaches the end, rotate it back to the first image
			var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('div#rotator ul li:first') :current.next()) : $('div#rotator ul li:first'));	
			
			//Set the fade in effect for the next image, the show class has higher z-index
			next.css({opacity: 0.0})
			.addClass('show')
			.animate({opacity: 1.0}, 1000);
		
			//Hide the current image
			current.animate({opacity: 0.0}, 1000)
			.removeClass('show');
			
		};
		
		$(document).ready(function() {		
			//Load the slideshow
			theRotator();
		});
		
		</script>
		
		<script type="text/javascript">
		$(window).load(function() {
		    $('#slider').nivoSlider({
		        effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
		        animSpeed: 500, // Slide transition speed
		        pauseTime: 7000, // How long each slide will show
		        startSlide: 0, // Set starting Slide (0 index)
		        randomStart: true // Start on a random slide
		    });
		});
		</script>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
			var pageTracker = _gat._getTracker("UA-5732686-1");
			pageTracker._trackPageview();
		</script>
			
	</head>
	<body>
		<header>
			<h1>IIT UBF</h1>
			<nav>
<?
		include('menu.php');
?>				
			</nav>
		</header>