<?php

// this is mostly static, it only queries the database
// for the slideshow interval.
header ('content-type: application/x-javascript');
if(!defined('DB_NAME')) {
    require_once('../../../wp-config.php');
}
$options = get_option('widget_piclens_options');
if ($options) {
    $timer = $options['slideshowTimer'];
} else {
    $timer = '2000';
}

?>

/*****
Image Cross Fade Redux
Version 1.0
Last revision: 02.15.2006
steve@slayeroffice.com
Please leave this notice intact. 
Rewrite of old code found here: http://slayeroffice.com/code/imageCrossFade/index.html
*****/

window.addEventListener?window.addEventListener("load",so_init,false):window.attachEvent("onload",so_init);

var d=document, imgs = new Array(), zInterval = null, current=0, pause=false;
var myDivWidth, myDivHeight;

function toggleStartStop() {
	mydiv = d.getElementById("rotator");
	if (mydiv) {
		imgs = mydiv.getElementsByTagName("img");
		if (imgs[0]) {
			if (pause == true) {
				pause = false;
				setTimeout(so_xfade,50);
			} else {
				pause = true;
				setTimeout(checkIfPiclensIsRunning,1000);
			}
		}
	}
}

function checkIfPiclensIsRunning() {
	if (PicLensLite.piclensIsRunning_ == true) {
		setTimeout(checkIfPiclensIsRunning,1000);
	} else {
		toggleStartStop();
	}
}

function so_init() {
	if(!d.getElementById || !d.createElement)return;

	mydiv = d.getElementById("rotator");

	if (mydiv) {
		imgs = mydiv.getElementsByTagName("img");

    	// set the 4:3 height
    	myDivWidth = mydiv.offsetWidth;
    	myDivHeight = Math.round(myDivWidth * 0.75);
    	mydiv.style.height = myDivHeight + 'px';
    
    	myNoImgDiv = d.getElementById("noImages");
    	if (myNoImgDiv) {
    		myNoImgDivW = myNoImgDiv.offsetWidth;
    		myNoImgDivH = Math.round(myNoImgDivW * 0.75);
    		myNoImgDiv.style.height = myNoImgDivH + 'px';
    	}
    
        if (imgs[0]) {
        	for(i=0;i<imgs.length;i++) {
        		imgs[i].xOpacity = 0;
        
        		// get the image w&h
        		iImageWidth = imgs[i].width;
        		iImageHeight = imgs[i].height;
        
        		if (iImageWidth > 1000) {
        			fudgeFactor = 0.01;
        		} else {
        			fudgeFactor = 0.1;
        		}
        
        		// find the w&h multiplier, round down.
        		var widthMultiplier = (myDivWidth-2) / iImageWidth;
        		var heightMultiplier = (myDivHeight-2) / iImageHeight;
        		var wMulti = widthMultiplier.toFixed(2) - fudgeFactor;
        		var hMulti = heightMultiplier.toFixed(2);
        
        		// pick the lesser of the two.
        		if (wMulti > hMulti) {
        			var multiplier = hMulti;
        			var nShift = 2;
        		} else {
        			var multiplier = wMulti;
        			var nShift = 2;
        		}
        
        		imgs[i].width = Math.floor(iImageWidth * multiplier);
        		imgs[i].height = Math.floor(iImageHeight * multiplier);
        
        		wWhiteSpace = myDivWidth - imgs[i].width;
        		hWhiteSpace = myDivHeight - imgs[i].height;
        
        		topSpace = Math.round(hWhiteSpace/2)+2;
        		leftSpace = Math.round(wWhiteSpace/2)-5;
        
        		imgs[i].style.display = "none";
        		imgs[i].style.position = "absolute";
        		imgs[i].style.top = topSpace + "px";
        		imgs[i].style.left = leftSpace + "px";
        		
        	}
        	imgs[0].style.display = "block";
        	imgs[0].xOpacity = .99;
    
    		setTimeout(so_xfade,<?php echo "$timer"; ?>);
        }
	}
}

function so_xfade() {
	var cOpacity = imgs[current].xOpacity;
	var nIndex = imgs[current+1]?current+1:0;
	var nOpacity = imgs[nIndex].xOpacity;
	
	if (pause) {
		return;
	}
	
	cOpacity-=.05; 
	nOpacity+=.05;
	
	imgs[nIndex].style.display = "block";
	imgs[current].xOpacity = cOpacity;
	imgs[nIndex].xOpacity = nOpacity;
	
	setOpacity(imgs[current]); 
	setOpacity(imgs[nIndex]);
	
	if(cOpacity<=0) {
		imgs[current].style.display = "none";
		current = nIndex;
		setTimeout(so_xfade,<?php echo "$timer"; ?>);
	} else {
		setTimeout(so_xfade,50);
	}
	
	function setOpacity(obj) {
		if(obj.xOpacity>.99) {
			obj.xOpacity = .99;
			return;
		}
		obj.style.opacity = obj.xOpacity;
		obj.style.MozOpacity = obj.xOpacity;
		obj.style.filter = "alpha(opacity=" + (obj.xOpacity*100) + ")";
	}
	
}
