var openAnimation;
var pfx = ["webkit", "moz", "MS", "o", ""];
function prefixedEventListener(element, type, callback) {
	for (var p = 0; p < pfx.length; p++) {
		if (!pfx[p]) type = type.toLowerCase();
		element.addEventListener(pfx[p]+type, callback, false);
	}
}

(function($){

	"use strict";
	var o = Snap('#open-svg');
	var s = Snap('#home-svg');
	var group;
	var homeDescriptionStr;

	openAnimation = function(){
		drawOpending();
	};

	function drawOpending(){

		// $( "#open-svg" ).fadeOut(1000,function(){
		// 				$( "#home-svg" ).fadeIn(1000, function() {
		// 	    		 	drawDesign()
		// 	    		});
		// 			})

		showDescriptionCheee();

		var heart = o.path("M 380 160 h 10 L 397.5 167.5 L 405 160 h 10 L 425 170 v 10 L 397.5 210 L 370 180 v -10 Z").attr({fill:"#777779",strokeWidth:1,stroke:"#777779"})
		var processingBar = o.path("M 310 350 h 180 v10 h-180 Z").attr({fill:"none",strokeWidth:2,stroke:"#777779"})

		var processingBarFill = o.path("M 310 355 h 180").attr({fill:"none"})

		var processpLength = Snap.path.getTotalLength(processingBarFill)

		var processFill =  o.path({
		 	path: Snap.path.getSubpath(processingBarFill, 0, 0),
		 	stroke: "#777779",
		 	fill:"#777779",
		 	fillOpacity: 0,
		 	strokeWidth: 0
		});

		Snap.animate(0, processpLength,
	    function(step){ //step function
		    processFill.attr({
		        path: Snap.path.getSubpath(processingBarFill, 0, step),
		        strokeWidth: 10
		      });
		    },
		    2000,
		    mina.easeInOut, //easing
		    function(){
		    	processFill.animate({ opacity:0 },1000)
		    	heart.animate({transform:('t0,50'),fill:'#e9004b',stroke:"#e9004b"},1000)
		    	processingBar.animate({ opacity:0 },1000)
		    	setTimeout(function() { 	
		    		$( "#open-svg" ).fadeOut(1000,function(){
		    			heart.remove();
		    			processingBar.remove();
		    			processingBarFill.remove();
		    			processFill.remove();
						$( "#home-svg" ).fadeIn(1000, function() {
			    		 	drawHeart()
			    		});
					})
					showDescriptionBrand();
				}, 2000);
		    }
	  	);

	}

	function drawBrand(){

		var letterB = "M 305 350 L 325 350 L 340 365 v 20 h -35 Z M 310 365 h 23 L 323 355 h -13 Z M 310 380 h 25 v -10 h -25 Z"
		var letterR = "M 350 350 h 35 v 20 h -15 L 385 385 h -5 L 365 370 h -10 v 15 h -5 Z M 355 365 h 25 v -10 h -25 Z"
		var letterA = "M 395 350 h 35 v 35 h -5 v -15 h -25 v 15 h -5 Z M 400 365 h 25 v -10 h -25 Z"
		var letterN = "M 440 350 h 2.5 L 470 375.5 v -26 h 5 v 35 h -5 L 445 362.5 v 22.5 h -5 Z"
		var letterD = "M 485 350 h 35 v 20 L 505 385 h -20 Z M 490 380 h 14 L 514 369 v -14 h -24 Z"

		var loop = s.path(letterB + letterR + letterA + letterN + letterD ).attr({ fill: "none" })

		var loopLength = Snap.path.getTotalLength(loop)

		var brandOutline =  s.path({
		 	path: Snap.path.getSubpath(loop, 0, 0),
		 	stroke: "#e9004b",
		 	fill:"#e9004b",
		 	fillOpacity: 0,
		 	strokeWidth: 0,
		 	strokeDashArray: "200,200"
		});

		group.add(brandOutline);
		Snap.animate(0, loopLength,
	    function(step){ //step function
		    brandOutline.attr({
		        path: Snap.path.getSubpath(loop, 0, step),
		        strokeWidth: 1
		      });
		    },
		    3000,
		    mina.easeInOut, //easing
		    function(){
		    	loop.remove();
		    	brandOutline.animate({fillOpacity:"1"},1000,function(){
		    		group.animate({ transform: 't-500,0', opacity:0 }, 1000,function(){
		    			group.remove();
		    		});
		    		drawDesign();
		    		showDescriptionDesign();
		    	});
		    }
	  	);
	}

	function drawDigital(){

		var computer = "M 305 100 h 200 v 130 h -200 Z M 315 220 h 180 v -110 h -180 Z M 340 130 h 130 v 10 h -130 Z M 340 160 h 130 v 10 h -130 Z M 340 190 h 130 v 10 h -130 Z M 370 245 h 70 v 10 h -70 Z M 325 265 h 160 v 10 h -160 Z"
		var letterD = "M 295 350 h 35 v 20 L 315 385 h -20 Z M 300 380 h 13 L 324 369 v -14 h -24 Z"
		var letterI = "M 340 350 h 5 v 35 h -5 Z"
		var letterG = "M 355 350 h 35 v 5 h -30 v 25 h 25 v -10 h -10 v -5 h 15 v 20 h -35 Z"
		var letterII = "M 400 350 h 5 v 35 h -5 Z"
		var letterT = "M 415 350 h 35 v 5 h -15 v 30 h -5 v -30 h -15 Z"
		var letterA = "M 460 350 h 35 v 35 h -5 v-15 h -25 v 15 h -5 Z M 465 365 h 25 v -10 h -25 Z"
		var letterL = "M505 350 h 5 v 30 h 30 v 5 h -35 Z"

		var replayButtonLeft = s.path("M-30,285 a60,60,0,0,1,0-120 M -30,265 v -10 S -60 255 -60 225 h -10 S -70 265 -30 265 M -30 200 v -20 L -47 190 Z").attr({fill:"#e9004b"})
		var replayButtonRight = s.path("M830,285 a60,60,0,0,0,0-120 M 830 185 S 870 185 870 225 h -10 S 860 195 830 195 Z M 870 225 S 870 265 830 265 v -10 S 860 255 860 225 Z").attr({fill:"#e9004b"})

		var loop = s.path(computer + letterD + letterI + letterG + letterII + letterT + letterA + letterL).attr({ fill: "#e9004b", opacity:0 })

		loop.animate({opacity:1},2000,function(){
			setTimeout(function(){
				showDescriptionCheee()
				replayButtonLeft.animate({ transform: 't430,0'}, 700)
				replayButtonRight.animate({ transform: 't-430,0'}, 700,function(){
					var group = s.paper.g()
					group.add(replayButtonRight,replayButtonLeft)
					group.addClass('animation-replay')
					group.click(function(){
						drawHeart();
						showDescriptionBrand()
						group.remove()
					})
				})
				loop.animate({ transform: 't0,-500'}, 1000,function(){
					loop.remove()
				})
			},3000)
			// ending.animate({opacity:1},100,function(){
			// 	loop.animate({opacity:0},1000,function(){
			// 		loop.remove();
			// 		ending.animate({
			// 			x:350,
			// 			y:175,
			// 			rx: 100,
			// 			ry: 100,
			// 			width: 100,
			// 			height: 100,
			// 			strokeWidth: 6
			// 		},1000,function(){
			// 			var replay = s.path("M 382 200 L 426 225 L 382 250 Z").attr({fill:"#e9004b"});
			// 			var g = s.paper.g();
			// 			g.add(ending,replay);
			// 			g.addClass('animation-replay');
			// 			g.click(function(){
			// 				drawOpending();
			// 				g.remove();
			// 			});
			// 		})
			// 	})
			// })
		})
	}

	function drawDesign(){

		var pencil  = "M 280 185 L 370 95 h 135 v 180 h -135 Z M 310 170 v 30 L 370 260 v -150 Z M 380 105 v 35 h 105 v -35 Z M 380 150 v 30 h 105 v -30 Z M 380 190 v 30 h 105 v -30 Z M 380 230 v 35 h 105 v -35 Z"
		var letterD = "M 285 345 h 35 v 20 L 305 380 h -20 Z M 290 350 v 25 h 14 L 315 364 v -14 Z"
		var letterE = "M 330 345 h 35 v 5 h -30 v 10 h 30 v 5 h -30 v 10 h 30 v 5 h -35 Z"
		var letterS = "M 375 345 h 35 v 5 h -30 v 10 h 30 v 20 h -35 v -5 h 30 v -10 h -30 Z"
		var letterI = "M 420 345 h 5 v 35 h -5 Z"
		var letterG = "M 435 345 h 35 v 5 h -30 v 25 h 25 v -10 h -10 v -5 h 15 v 20 h -35 Z"
		var letterN = "M 480 345 h 3 L 510 372 v -27 h 5 v 35 h -5 L 485 355 v 25 h -5 Z"

		var loop = s.path(pencil + letterD + letterE + letterS + letterI + letterG + letterN).attr({ fill: "#e9004b", opacity:0 })

		// loop.attr({ mask: clip })

		loop.animate({transform: 't500,0'}, 100, function(){
			loop.animate({ transform: 't0,0', opacity:"1"},2200,mina.bounce,function(){
				setTimeout(function(){
					loop.animate({opacity:0},1000,function(){
						loop.remove();
					})
					drawDigital()
					showDescriptionDigital();
				},2000)
			});
		})
	}

	function drawHeart(){

		group = s.paper.g();

		var heart = s.path("M 415 130 L 445 100 L 485 100 L 525 140 v 40 L 415 290 L 300 180 v -40 L 340 100 h 40 Z").attr({ fill: "none", stroke: "#e9004b", opacity: "0"});
		var loopLength = Snap.path.getTotalLength(heart);

		var heartOutline =  s.path({
		 	path: Snap.path.getSubpath(heart, 0, 0),
		 	stroke: "#e9004b",
		 	fillOpacity: 0,
		 	fill: "#e9004b",
		 	strokeWidth: 0
		});

		group.add(heartOutline);

		Snap.animate(0, loopLength,
		    function(step){ //step function
		      heartOutline.attr({
		        path: Snap.path.getSubpath(heart, 0, step),
		        strokeWidth: 1
		      });
		    }, // end of step function
		    2000, //duration
		    mina.easeInOut, //easing
		    function(){ //callback
		    	heart.remove();
		    	heartOutline.animate({fillOpacity:"1"},1000,function(){
		    		drawBrand();
		    		$("#test-animation").attr('class','tower-viewpoint')
		    		var circle = document.querySelector("#test-animation")

		    		prefixedEventListener(circle,"AnimationStart",function(e){
						// get the elapsed time when animation starts, i.e. 0, log it in the console
						console.log("Start")
					});

					prefixedEventListener(circle,"AnimationIteration",function(e){
						// get the elapsed time when animation starts, i.e. 0, log it in the console
						var elapsedTime = e.elapsedTime;
						console.log(elapsedTime)
					});

					prefixedEventListener(circle,"AnimationEnd",function(e){
						// get the elapsed time when animation starts, i.e. 0, log it in the console
						console.log("End")
					});

		    		// heartOutline.animate({path:"M 280 185 L 370 95 h 135 v 180 h -135 Z M 310 170 v 30 L 370 260 v -150 Z M 380 105 v 35 h 105 v -35 Z M 380 150 v 30 h 105 v -30 Z M 380 190 v 30 h 105 v -30 Z M 380 230 v 35 h 105 v -35 Z"},1000)
		    	});
		    }//callback
	    );//Snap.animate 
	}


	function showDescriptionCheee(){
		homeDescriptionStr = '<h1>CHEEE</h1>';
		homeDescriptionStr += '<h2><strong>Cheee</strong> (n.) is the universal word that describes a beautiful should through love, happiness, creativity, and positive cheee energy. </h2><h2>Our philosophy is happiness, delivering happiness to people around us and spreading to the rest of the world. Our slogan is “saycheee”. When you say cheee, you are smiling. Smiling is a simply easy way to be happy. </h2>';
		homeDescriptionStr += '<h2>We value, profession, logic, communication, respect and happiness.</h2>';
		homeDescriptionStr += '<a href=" " title="our works">VIEW OUR WORKS</a >';
		$('#animation-desc').fadeOut(1000,function(){
			$(this).html(homeDescriptionStr).fadeIn(1000);
		});
	}

	function showDescriptionBrand(){
		homeDescriptionStr = '<h1>We Love Branding</h1>';
		homeDescriptionStr += '<h2>Brand, including the logo, name, colours, typography, patterns, iconography and all other identifying elements, are valuable company assets. The right brand design is able to sending a consistent and controlled message of who the company are. <span>It is essential to presenting a strong, unified image of company through brand.</span></h2>';
		homeDescriptionStr += '<h2>Our Branding approach is focusing on the concept and logic. <span>Please see the following portfolios for our brainstorm process and final brand design works.</span></h2>';
		homeDescriptionStr += '<a href="/portfolio#/brand" title="our works">VISIT OUR BRAND WORKS</a >';
		$('#animation-desc').fadeOut(1000,function(){
			$(this).html(homeDescriptionStr).fadeIn(1000);
		});
	}

	function showDescriptionDesign(){
		homeDescriptionStr = '<h1>Creativity make us passionate about DESIGN</h1>';
		homeDescriptionStr += '<h2>Our design approach is focusing on the logic and visual hierarchy. The visual hierarchy orders of the information hierarchy are depend on the information that clients provide us and reasoned by logic. Color hierarchy contains two colour systems, the primary logo colour system and the secondary brand colour system. Typographic hierarchy is another form of visual hierarchy, a sub-hierarchy per se in an overall design project. Those hierarchy creates contrast between design elements.</h2>';
		homeDescriptionStr += '<h2>Please see the following portfolios for our final design works.</h2>';
		homeDescriptionStr += '<a href="/portfolio#/design" title="our works">VISIT OUR DESIGN WORKS</a >';
		$('#animation-desc').fadeOut(1000,function(){
			$(this).html(homeDescriptionStr).fadeIn(1000);
		});
	}

	function showDescriptionDigital(){
		homeDescriptionStr = '<h1>We Value UX & UI</h1>';
		homeDescriptionStr += '<h2>Our design team is cheerful and sharp-eyed, delivering clear, structured and branding consistent website designs. Our development team is experienced highly skilled with back and front-end coding language, frameworks, database and responsive websites with a smooth user interface. We can provide customised CMS systems intergraded with any third party API to keep the system simple and easy to manage. We design and develop, all you have to do is smile. #saycheee</h2>';
		homeDescriptionStr += '<h2>please click the button below for our degital works</h2>';
		homeDescriptionStr += '<a href="/portfolio#/digital" title="our works">VISIT OUR DIGITAL WORKS</a >';
		$('#animation-desc').fadeOut(1000,function(){
			$(this).html(homeDescriptionStr).fadeIn(1000);
		});
	}

	function drawEnd(){

	}

})(jQuery)