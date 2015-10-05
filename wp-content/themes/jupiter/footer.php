<?php
global $mk_options;

$show_footer_old = $show_footer = '';
$post_id = global_get_post_id();
if($post_id) {
  $show_footer_old = get_post_meta($post_id, '_footer', true );
  $show_footer = get_post_meta($post_id, '_template', true );
}
?>

<?php if($mk_options['disable_footer'] == 'true' && ($show_footer_old != 'false' && $show_footer != 'no-footer' && $show_footer != 'no-header-footer' && $show_footer != 'no-header-title-footer' && $show_footer != 'no-footer-title')) { ?>
<div id="footer-holder">

<?php if($mk_options['disable_sub_footer'] == 'true' && ($show_footer_old != 'false' && $show_footer != 'no-footer' && $show_footer != 'no-header-footer' && $show_footer != 'no-header-title-footer' && $show_footer != 'no-footer-title')) { ?>

	<div class="megawide-nav">
		<div class="mk-grid">
			<?php wp_nav_menu(array(
				'menu' => 'Megamenu',
				'menu_class' => 'nav-menu',
			)); ?>

			<div class="clearboth"></div>
		</div>
	</div>

	<?php 
	// hide this on landing page / aka homepage/frontpage
	if( ! is_front_page()) {
	?>

	<div id="donate-goal-holder">
	<div id="donate-goal">
		<div class="inner">
			<div class="heading">our goal</div>
			<div class="progressbar">
				<div class="bar">
					<div id="progress" class="line" style="width: 0.5%"></div>
					<div class="target"><span class="sum">$1,000,000</span><br />by Labor Day</div>
				</div>
				<ul class="stats">
					<li>$<span id="cash_money_count"></span><small>donated</small></li>
					<li><span id="donor_count"></span><small>donors</small></li>
					<li><span id="days_left"></span><small>days left</small></li>
				</ul>
			</div>
			<a href="/donate" class="donate">donate</a>
			<div class="clearboth"></div>
		</div>
	</div>
	</div>
	<?php } ?>
<?php } ?>

	<footer id="footer">
		<div class="mk-grid">
			<div class="copyright">
				<p>
					© 2015 Lessig Equal Citizens<br />
					Exploratory Committee.<br />
					Some Rights Reserved
				</p>
				<p><a href="mailto:info@lessig2016.us">E-mail</a>&nbsp; | &nbsp;<a href="/privacy-policy">Privacy Policy</a>&nbsp; | &nbsp;<a href="/terms-of-service">Terms of Service</a> </p>
				<p><a href="https://creativecommons.org/licenses/by/2.0/" target="_blank"><img src="/wp-content/uploads/2015/07/cc-by.png" alt="CC BY" /></a></p>
			</div>

			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">LESSIG</a>

			<div class="sponsor">Paid for by Lessig Equal Citizens Exploratory Committee</div>

			<div class="clearfix"></div>
		</div>
	</footer>
</div>
<?php } ?>


<?php
	do_action( 'side_dashboard');

	if($mk_options['custom_js']) :

	?>
		<?php echo stripslashes($mk_options['custom_js']); ?>

	<?php

	endif;

	if($mk_options['analytics']){
		?>
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php echo stripslashes($mk_options['analytics']); ?>']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	<?php } ?>

</div>

	<?php 
		if ($mk_options['go_to_top'] != 'false') {
			echo '<a href="#" class="mk-go-top"><i class="mk-icon-chevron-up"></i></a>';
		}
	?>
	
	<?php
		do_action('quick_contact');
		do_action('full_screen_search_form');
	?>


	<!-- Apply custom styles before runing other javascripts as they 
	might be based on those styles as well -->
	<?php
		global $app_dynamic_styles;
		global $app_modules;

		$app_dynamic_styles_ids = array();
		$app_dynamic_styles_inject = '';

		$ken_styles_length = count($app_dynamic_styles);

		if ($ken_styles_length > 0) {
			foreach ($app_dynamic_styles as $key => $val) { 
				$app_dynamic_styles_ids[] = $val["id"]; 
				$app_dynamic_styles_inject .= $val["inject"];
			};
		}

		$modulesLength = count($app_modules);


		if ($modulesLength > 0) {
			foreach ($app_modules as $key => $val) { 
				$modules[] = $val["name"]; 
				$params[] = $val["params"];
			};
		}

	?>
	<script type="text/javascript">
		var dynamic_styles = '<?php echo mk_clean_init_styles($app_dynamic_styles_inject); ?>';
		var dynamic_styles_ids = (<?php echo json_encode($app_dynamic_styles_ids); ?> != null) ? <?php echo json_encode($app_dynamic_styles_ids); ?> : [];

		var styleTag = document.createElement('style'),
			head = document.getElementsByTagName('head')[0];

		styleTag.type = 'text/css';
		styleTag.setAttribute('data-ajax', '');
		styleTag.innerHTML = dynamic_styles;
		head.appendChild(styleTag);
	</script>
	<!-- Custom styles applied -->

	<?php wp_footer(); ?>

	<!-- Apply ajax styles and run JSON triggered js modules -->
	<script type="text/javascript">
		window.$ = jQuery

		$('.mk-dynamic-styles').each(function() {
			$(this).remove();
		});

		function ajaxStylesInjector() {
			$('.mk-dynamic-styles').each(function() {
				var $this = $(this),
					id = $this.attr('id'),
					commentedStyles = $this.html();
					styles = commentedStyles
							 .replace('<!--', '')
							 .replace('-->', '');


				if(dynamic_styles_ids.indexOf(id) === -1) {
					$('style[data-ajax]').append(styles);
					$this.remove();
				}

				dynamic_styles_ids.push(id);
			});
		};

		<?php 
			if ($modulesLength > 0) {
				for ($i = 0; $i < $modulesLength; $i++) {
					echo "abb.modules." . $modules[$i] . ".init({";
						foreach ($params[$i] as $key => $val) {
							echo $key . ": '$val',";
						}
					echo "}); \n";
				} 

				echo "abb.init();";
			}
		?>
		
	</script>

<script src="/wp-content/uploads/2015/08/jquery.vmap_.packed.js"></script>
<script src="/wp-content/uploads/2015/08/jquery.vmap_.usa_.js"></script>
<script src="/wp-includes/js/jquery/jquery.timeago.js"></script>
<script>
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).ready(function(){
    var GOAL = 1000000;

    jQuery.getJSON('//pledge.lessig2016.us/r/total', function(data) {
      var totalRaised = Math.round(data.totalCents/100);
      $('#cash_money_count').text(numberWithCommas(totalRaised));
      if (totalRaised > 5000) {
      	$("#progress").width('' + Math.min(100, Math.floor(totalRaised * 100 / GOAL)) + '%');
      }
    });

    jQuery.getJSON('//pledge.lessig2016.us/r/num_pledges', function(data) {
      $('#donor_count').text(numberWithCommas(data.count));
    });

    $('#days_left').text(Math.round(Math.abs(((new Date()).getTime() - (new Date(new Date().getFullYear(),8,7)).getTime()) / (24*60*60*1000))) + 1);


    $(window).scroll(onScroll).resize(onResize);

    onResize();
    function onResize() {
        if($(window).width() <= 1060) {
		$('body').addClass('ed-responsive');
        } else {
		$('body').removeClass('ed-responsive');
	}
    }

    onScroll();
    function onScroll() {

        // sticky header
        if($(window).scrollTop() > 1) {
    		$('body:not(.sticky-header)').addClass('sticky-header');
	    } else {
    		$('body.sticky-header').removeClass('sticky-header');
	    }

        // sticky donation goal
        var $donat_goal_holder = $('#donate-goal-holder');
        if($donat_goal_holder.length) {
        	var $donat_goal = $('#donate-goal');
	        var donat_position = $donat_goal_holder.offset();
	        var donat_height = 114;

			if($(window).scrollTop() <= Math.floor((donat_position.top + donat_height) - $(window).height())) {
				$donat_goal.removeClass('absolute');
				$donat_goal.addClass('fly');
			} else {
				$donat_goal.addClass('absolute');
				$donat_goal.removeClass('fly');
			}
		}
    }

// THANK YOU page, vector map
/*
if($('#vmap').length) {
$('#vmap').vectorMap({
    map: 'usa_en',
    backgroundColor: '#ffffff',
    color: '#3d55e7',
    hoverColor: '#1831cb',
    selectedColor: '#ff4e4e',
    enableZoom: false,
    showTooltip: true,
    onRegionClick: function(element, code, region)
    {
	var region_url = 'https://lessig2016.us/region/' + region;
	document.location.href = region_url;
    }
});
}
*/

	// THANK YOU page, close modal
	$('.do-close-askagain').on('click', function(e){
		e.preventDefault();

		$('#ask-again-popup, #ask-again-overlay').fadeOut(250,function(){
			$('#ask-again-popup').remove();
			$('#ask-again-overlay').remove();
		});
	});

	// Show megamenu
	$('.do-open-megamenu').on('click', function(e){
		e.preventDefault();

		if($('body').hasClass('ed-responsive')) {
			$('#header-hamburger').removeClass('active');
			$('#header-nav').hide();
			$('#header .menu-header-menu-container').slideUp(100, function(){
                		$('html, body').animate({
                        		scrollTop: $("#footer-holder").position().top - 75
               			}, 500);
			});
		} else {
			$('#header-nav').slideToggle(250);
		}
	});

	// Hide megamenu
	$('.do-hide-megamenu').on('click', function(e){
		e.preventDefault();

		$('#header-nav').slideUp(250);
	});

	// Header hamburger
	$('#header-hamburger').on('click', function(e){
		e.preventDefault();

		$(this).toggleClass('active');
		$('#header .menu-header-menu-container').slideToggle(250);
	});

// LANDING page, smooth scroll to section
$('.ld-section-box').find('a').on('click', function(e){
	e.preventDefault();

	var target = $(this).attr('href');
	var target_offset = ($('body').hasClass('admin-bar') ? 98 : 66); // 66 = header height, 98 = header+adminbar height
	var target_position = $(target).offset().top - target_offset;
	
	$('html,body').animate({
		scrollTop: target_position
	}, 600);
});
});
</script>

<script>
// Facebook 
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '945663505477225',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
	
</body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65924640-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Google Code for All Visitors - Last 540 Days -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 961150407;
var google_conversion_label = "pG4yCOLe714Qx_unygM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/961150407/?value=1.00&amp;currency_code=USD&amp;label=pG4yCOLe714Qx_unygM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<script type="text/javascript">
  var _kmq = _kmq || [];
  var _kmk = _kmk || '4f23210cd28379cf965ea2351de1550b13999b93';
  function _kms(u){
    setTimeout(function(){
      var d = document, f = d.getElementsByTagName('script')[0],
      s = d.createElement('script');
      s.type = 'text/javascript'; s.async = true; s.src = u;
      f.parentNode.insertBefore(s, f);
    }, 1);
  }
  _kms('//i.kissmetrics.com/i.js');
  _kms('//scripts.kissmetrics.com/' + _kmk + '.2.js');
</script>
<?php 
$url_check = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
if( strpos($url_check, '/thank-you/') !== FALSE  || strpos( $url_check, '/thank-you-test/') !== FALSE ){ ?>
<script type="text/javascript" src="/js/thank-you.js"></script>
<script type="text/javascript" src="/js/donate.js"></script>
<script type="text/javascript" src="/js/state_groups.js"></script>
<script type="text/javascript" src="/js/volunteer-action.js"></script>

<?php }?>

</html>
