var pfx = ["webkit", "moz", "MS", "o", ""]
function prefixedEventListener(element, type, callback) {
	for (var p = 0; p < pfx.length; p++) {
		if (!pfx[p]) type = type.toLowerCase()
		element.addEventListener(pfx[p]+type, callback, false)
	}
}

function prefixedEventListenerRemove(element, type, callback) {
	for (var p = 0; p < pfx.length; p++) {
		if (!pfx[p]) type = type.toLowerCase()
		element.removeEventListener(pfx[p]+type, callback, false)
	}
}

function showTime(){
  setInterval(function() {
  function r(el, deg) {
    el.setAttribute('transform', 'rotate('+ deg +' 426.17 124.39)')
  }
  var d = new Date()
  r(sec, 6*d.getSeconds())  
  r(min, 6*d.getMinutes())
  r(hour, 30*(d.getHours()%12) + d.getMinutes()/2)
}, 1000)
}

(function($){

	"use strict"
	var homeDescriptionStr = ''
	showDescriptionCheee()

	var clockHands = document.querySelector('#clock-hands')
	prefixedEventListener(clockHands,"AnimationEnd",function(e){
			showTime()
	})

	var calenderBase = document.querySelector('#calender-base')
	prefixedEventListener(calenderBase,"AnimationEnd",function(e){
			$("#calender-base").attr("class","")
	})

	var calenderWordLeft = document.querySelector('#calender-word-left')
	prefixedEventListener(calenderWordLeft,"AnimationEnd",function(e){
			$("#calender-word-left").attr("class","")
	})

	var calenderWordRight = document.querySelector('#calender-word-right')
	prefixedEventListener(calenderWordRight,"AnimationEnd",function(e){
			$("#calender-word-right").attr("class","")
	})

	var clipPath = document.querySelector('#cp-text'),
		fillElement = document.querySelector('#fill-rect'),
		iconClone,
		textClone

	var computer = document.querySelector("#computer-svg")
	prefixedEventListener(computer,"AnimationEnd",function(e){
			$("#drawing-area").fadeIn(500,function(){
				computerStartAnimation()
			})
	})

	var cup = document.querySelector('#cup')

	prefixedEventListener(cup,"AnimationEnd",function(e){
		    $("#cup").attr("class","")
	})

	function computerStartAnimation(){
			
		$("#computer-start-group").show()

		var processBar = $("#process-bar")
		var processBarClone = $("#process-bar").clone()
		$("#cp-content").append(processBarClone)
		$("#fill-rect").attr("class", "anim-processing-bar")

		prefixedEventListener(fillElement,"AnimationEnd",afterFillInOpening)

	}

	function afterFillInOpening(){
		$("#start-heart").attr("fill","#e9004b")
		$("#start-heart").attr("class", "anim-heart-beating")
		$("#process-bar").attr("fill","#777779")
		$("#process-bar").attr("class","animated zoomOut")
		$("#cp-content").empty()
		prefixedEventListenerRemove(fillElement,"AnimationEnd",afterFillInOpening)

	}

	prefixedEventListener($("#start-heart")[0],"AnimationEnd",function(e){
		$("#computer-start-group").hide()
		$("#process-bar").attr('class','').attr('fill','none')
		$("#start-heart").attr('class','').attr('fill','#777779')
		$('#computer-screen').attr('fill','#fff')
		$('#fill-rect').attr('class','')
		$('.computer-bg').fadeOut(500)
		$('.svg-back-points').fadeIn(500)
		brandStart()
	})

	function brandStart(){

		showDescriptionBrand()

		$("#brand-animation").show()
		iconClone = $("#heart").clone()
		textClone = $("#text-brand").clone()
		$('#heart').attr('class','heart-animation')


		prefixedEventListener($("#heart")[0],"AnimationEnd",drawTextBrand)
	
	}

	function drawTextBrand(){

		$("#text-brand").attr("class","text-brand-animation")

		prefixedEventListener($("#text-brand")[0],"AnimationEnd",fillInBrand)

		prefixedEventListenerRemove($("#heart")[0],"AnimationEnd",drawTextBrand)
	}

	function fillInBrand(){

		$("#cp-content").append(iconClone,textClone)
		$("#fill-rect").attr("class", "anim-shape-left-right")

		prefixedEventListenerRemove($("#text-brand")[0],"AnimationEnd",fillInBrand)
		prefixedEventListener(fillElement,"AnimationEnd",brandEnd)
	}


	function brandEnd(){

		$('#fill-rect').attr('class','')
		$("#brand-animation").find("path").attr("fill","#e9004b")
		$("#cp-content").empty()

		$("#brand-animation").attr('class','animated bounceOut')

		prefixedEventListener($("#brand-animation")[0],"AnimationEnd",afterBrandEnd)

		prefixedEventListenerRemove(fillElement,"AnimationEnd",brandEnd)

	
	}

	function afterBrandEnd(){
		$("#brand-animation").find("path").attr("fill","none")
		$("#brand-animation").hide().attr('class','')
		$("#heart").attr('class','')
		$("#text-brand").attr('class','')
		$("#brand-animation").find("path").attr("fill","none")

		prefixedEventListenerRemove($("#brand-animation")[0],"AnimationEnd",afterBrandEnd)
		designStart()
	}

	function designStart(){

		showDescriptionDesign()

		$("#design-animation").show()
		$("#pencil").attr('class','pencil-animation')

		prefixedEventListener($("#pencil")[0],"AnimationEnd",drawTextDesign)
	}

	function drawTextDesign(){
		$("#text-design").attr("class","text-design-animation")
		prefixedEventListener($("#text-design")[0],"AnimationEnd",fillInDesign)
		prefixedEventListenerRemove($("#pencil")[0],"AnimationEnd",drawTextDesign)
	}

	

	function fillInDesign(){
		iconClone = $("#pencil").clone()
		textClone = $("#text-design").clone()
		$("#cp-content").append(iconClone,textClone)

		$("#fill-rect").attr("class", "anim-shape-from-central")

		prefixedEventListener(fillElement,"AnimationEnd",designEnd)

		prefixedEventListenerRemove($("#text-design")[0],"AnimationEnd",fillInDesign)
	}

	function designEnd(){

		$('#fill-rect').attr('class','')
		$("#design-animation").find("path").attr("fill","#e9004b")
		$("#cp-content").empty()

		$("#design-animation").attr('class','animated zoomOut')

		prefixedEventListener($('#design-animation')[0],"AnimationEnd",afterDesignEnd)

		prefixedEventListenerRemove(fillElement,"AnimationEnd",designEnd)

	}


	function afterDesignEnd(){
		$("#design-animation").hide().attr('class','')
		$("#pencil").attr('class','')
		$("#text-design").attr('class','')
		$("#design-animation").find("path").attr("fill","none")

		prefixedEventListenerRemove($('#design-animation')[0],"AnimationEnd",afterDesignEnd)
		digitalStart()
	}

	function digitalStart(){

		showDescriptionDigital()

		$("#digital-animation").show()
		$("#computer").attr('class','computer-animation')

		prefixedEventListener($("#computer")[0],"AnimationEnd",drawTextDigital)


	}

	function drawTextDigital(){
		$("#text-digital").attr("class","text-digital-animation")

		prefixedEventListenerRemove($("#computer")[0],"AnimationEnd",drawTextDigital)
		prefixedEventListener($("#text-digital")[0],"AnimationEnd",fillInDigital)

	}

	function fillInDigital(){
		iconClone = $("#computer").clone()
		textClone = $("#text-digital").clone()
		$("#cp-content").append(iconClone,textClone)

		$("#fill-rect").attr("class", "anim-shape-from-central")

		prefixedEventListener(fillElement,"AnimationEnd",digitalEnd)
	}

	function digitalEnd(){

		$('#fill-rect').attr('class','')
		$("#digital-animation").find("path").attr("fill","#e9004b")
		$("#cp-content").empty()

		$("#digital-animation").attr('class','animated fadeOutDown')
		drawingArea[0].removeEventListener('click', learnMore, false)

		prefixedEventListener($('#digital-animation')[0],"AnimationEnd",afterDigitalEnd)
		prefixedEventListenerRemove(fillElement,"AnimationEnd",digitalEnd)

	}

	function afterDigitalEnd(){
		showDescriptionCheee()
		$("#digital-animation").hide().attr('class','')
		$("#computer").attr('class','')
		$("#text-digital").attr('class','')
		$("#digital-animation").find("path").attr("fill","none")
		$('.svg-back-points').fadeOut(500)
		$('.computer-bg').fadeIn(500, function(){
			$("#replay-animation").attr("class", "animated bounceIn")
			$("#replay-animation").show()
		})
		prefixedEventListenerRemove($('#digital-animation')[0],"AnimationEnd",afterDigitalEnd)
		
	}

	$("#replay-animation").click(function(){
		$("#replay-animation").hide().attr("class", "")
		$('.svg-back-points').fadeIn(500)
		$('.computer-bg').fadeOut(500, function(){
			drawingArea[0].addEventListener('click', learnMore, false)
			brandStart()
		})
		
	})

	function transformText(text){
		var $text = text
		console.log($text)
		var $this = $('#animation-desc').find('h1')
		var substitution,
			shuffle_timer,
			shuffle_timer_delay

		var shuffle = function(){
			$this.text(substitution)
			if ($text.length == substitution.length) {
				clearInterval(shuffle_timer)
			}
		}

		var shuffle_delay = function() {
          if (substitution.length < $text.length) {
            substitution = $text.substr(0, substitution.length + 1)
          } else {
            clearInterval(shuffle_timer_delay)
          }
        }

        var start = function(){
        	substitution = ""
          	clearInterval(shuffle_timer)
          	clearInterval(shuffle_timer_delay)

          	shuffle_timer = setInterval(function() {
            	shuffle.call($this[0])
          	}, 80)

          	shuffle_timer_delay = setInterval(function() {
	            shuffle_delay.call(this)
	        }, 160)       
        }

        start()
	}

	function showDescriptionCheee(){
		homeDescriptionStr = '<h1></h1>'
		homeDescriptionStr += '<a href="/portfolio" title="our works">VIEW OUR WORKS</a >'
		$('#animation-desc').fadeOut(500,function(){
			$(this).html(homeDescriptionStr).fadeIn(500,function(){
				transformText('CHEEE')
			})
		})
	}

	function showDescriptionBrand(){
		homeDescriptionStr = '<h1></h1>'
		homeDescriptionStr += '<a href="/portfolio#/brand" title="our works">VISIT OUR BRAND WORKS</a >'
		$('#animation-desc').fadeOut(500,function(){
			$(this).html(homeDescriptionStr).fadeIn(500,function(){
				transformText('We Love Branding')
			})
		})
	}

	function showDescriptionDesign(){
		homeDescriptionStr = '<h1></h1>'
		homeDescriptionStr += '<a href="/portfolio#/design" title="our works">VISIT OUR DESIGN WORKS</a >'
		$('#animation-desc').fadeOut(500,function(){
			$(this).html(homeDescriptionStr).fadeIn(500,function(){
				transformText('Creativity makes us passionate about DESIGN')
			})
		})
	}

	function showDescriptionDigital(){
		homeDescriptionStr = '<h1></h1>'
		homeDescriptionStr += '<a href="/portfolio#/digital" title="our works">VISIT OUR DIGITAL WORKS</a >'
		$('#animation-desc').fadeOut(500,function(){
			$(this).html(homeDescriptionStr).fadeIn(500,function(){
				transformText('We Value UX & UI')
			})
		})
	}

	var drawingArea = $('#drawing-area'),
		playState = '-webkit-animation-play-state',
		learnMoreBtn = $('#learn-more-btn');

	function learnMore(){
		drawingArea.find("path").css(playState, function(i, v) {
	        return v === 'paused' ? 'running' : 'paused';        
	    }); 
	    drawingArea.find("rect").css(playState, function(i, v) {
	        return v === 'paused' ? 'running' : 'paused';        
	    });

	    if($("#pause-screen").attr('show-status') == '0'){
			$("#pause-screen").stop().fadeIn(500,'linear')
			$("#pause-screen").attr('show-status',"1")
			$("#pause-screen-back").stop().fadeIn(500, 'linear')
			$("#pause-screen-back").attr('show-status',"1")
			
	    }else{
	    	$("#pause-screen").stop().fadeOut(500,'linear')
	    	$("#pause-screen").attr('show-status',"0")
			$("#pause-screen-back").stop().fadeOut(500,'linear')
			$("#pause-screen-back").attr('show-status',"0")
			
	    }
	}

	drawingArea[0].addEventListener('click', learnMore, false)

})(jQuery)