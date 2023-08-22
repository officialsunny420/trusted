<!DOCTYPE html>


<html>



<head>



	<title>Trusted Trades</title>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="facebook-domain-verification" content="ihfz2dggjkls9xyjj3n0k8gud7aqfb" />
    <meta name="description" content="Get Quotes from Trusted Trades People In Your Area Today. Builders, Landscapers, Gardeners, Cleaners, Electricians, Plumbers and more.">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/front'); ?>/css/style.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/front'); ?>/css/jquery-book.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/front'); ?>/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('/assets/common/fav') ?>/apple-touch-icon.png">

	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('/assets/common/fav') ?>/favicon-32x32.png">

	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('/assets/common/fav') ?>/favicon-16x16.png">

	<link rel="manifest" href="<?php echo base_url('/assets/common/fav') ?>/site.webmanifest">
		<link rel="canonical" href="https://www.mytrustedtrades.com/">

	<style>
		.error {

			color: red !important;

		}

	</style>
	

	<!-- Meta Pixel Code -->
	<script>
		! function(f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function() {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement(e);
			t.async = !0;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1241526856697690');
		fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1241526856697690&ev=PageView&noscript=1" /></noscript>
	<!-- End Meta Pixel Code -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RXFG4B515M"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-RXFG4B515M');
    </script>
    <!-- Hotjar Tracking Code for Trusted Trades -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:3388447,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>



<body>
<!--start header--->

	<header class="header-new">

		<div class="container-fluid">

			<div class="row">

				<div class="col-lg-12 col-md-12">

			
					<nav class="navbar navbar-expand-md navbar-dark">
						  <!-- Brand -->
						  <a class="navbar-brand" href="#"><img src="<?php echo base_url('/assets/front/images/logo.svg') ?>" style="width: 180px;"></a>

						  <!-- Toggler/collapsibe Button -->
						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
						    <span class="navbar-toggler-icon"></span>
						  </button>

						  <!-- Navbar links -->
						  	<div class="collapse navbar-collapse" id="collapsibleNavbar">
							    <ul class="navbar-nav">
							      	<li class="nav-item " id="about">
							      	  <a class="nav-link" href="#">About</a>
							     	</li>
							      	<li class="nav-item" id="how_it_work">
							       	 <a class="nav-link" href="#">How it works</a>
							     	</li>
							     	<li class="nav-item" id="contact_us">
							       	 <a class="nav-link" href="#">Contact us</a>
							     	</li>
							    </ul>
						  	</div>
					</nav>
				</div>

			</div>

		</div>

	</header>
<!--end of header--->

	<section class="form-section main-section">
 <input type="hidden" name="page" id="page" value="<?php if(isset($_GET['page']) && !empty($_GET['page'])): echo $_GET['page']; endif; ?>">

 
		<div class="container-fluid">



			<div class="row">



				<div class="col-lg-7">



					<h1 class="text-left middle-section">Find Trusted and Reliable</br> Tradespeople In Just a Few Clicks.</h1>
					<p>Whether it’s an extension you’re after or perhaps</br>
						your boiler needs a service. Whatever the job</br>
						we’ll get you 3 quotes from local professionals. </p>

					<div class="step-from">



						<form name="demo" id="demo" class="myBook" method="POST" enctype="multipart/form-data">

							<section id="section_first">


								<div class="row">

									<div class="col-lg-12">

										<div class="form-group">

											<label class="required_star" for="fname">What tradesperson do you need?</label><br>

											<select class="form-control" name="category_id" is_required="1" id="category_id">

												<option selected="true" value="">Please select</option>

												<?= $categories ?>

											</select>

										</div>

									</div>

									<div class="col-lg-12">

										<div class="form-group">

											<label class="required_star" for="fname">What type of job do you need doing?</label><br>

											<select class="form-control" name="sub_categories" is_required="1" id="sub_categories">

												<option>Please select</option>

											</select>

										</div>

									</div>

								</div>
                                 
								<div class="buttons">

									<button type="button" class="page-next btn btn-primary">Next</button>

								</div>

							</section>
                              
						   

							<input type="hidden" name="form_id" id="form_id" value="">

						</form>

					</div>

			</div>



		</div>

	</div>

	</section>
	<div id="last_section">

		<section class="page remove_section" style="display:none;">



			<h6>Nearly done...</h6>

		<!--	<label for="fname">Before we show your job to tradespeople, it's important you read this info.</label>-->

			<div class="row">



				<div class="col-lg-12">



				<!--	<div class="form-group hiring_checklist">

						<ul style="list-style-type:disc;">

							<li>Before hiring, read reviews, as for references, and check qualifications.</li>

							<li>It's your decision to choose a tradesperson, and we're not liable for their work.</li>

							<li>We verify Gas Safe registration but don't check other qualifications.</li>

						</ul>

						<p style="font-size: 12px; font-weight: 400; line-height: 16px; color: #636065; margin: 0">

							Rated People Ltd. is not liable for the work, actions or omissions of tradesmen.

							By submitting your job you agree to our <a target="_blank" href="#"> User Agreement</a> (particularly <a target="_blank" rel="" href="#">Use of Service</a>',

							'<a target="_blank" rel="" href="#">Indemnity</a>',

							and '<a target="_blank" rel="" href="#">Limitation of Liability</a>) and <a style="color: #ee153a; font-weight: bold" target="_blank" rel="" href="#">Privacy Policy</a>.</p>



					</div>-->

					<label class="check_newsletter">

						<input type="checkbox" checked="">
						<p class="">To authorise newsletter and <a style="color: #ee153a; font-weight: bold" target="_blank" rel="" href="https://www.mytrustedtrades.com/privacy-policy">Privacy Policy</a>.</p>
					</label>

				</div>

			</div>

			<input type="hidden" name="s" value="okk">

			<div class="buttons">

				<div class="message_box d-none alert alert-success" role="alert">

					This is a secondary alert—check it out!

				</div>

				<button type="button" class="page-prev btn btn-danger">Prev</button>



				<button type="button" id="submit" class="page-next btn btn-primary">Submit</button>



			</div>



		</section>

	</div>
	<section class="three-icon">
      
		<div class="container">

			<div class="row">
				<div class="col-lg-12">
					  <h2>It’s as easy as one, two, three!</h2>
				</div>
				<div class="col-lg-4 col-md-6">

					<div class="works-col">

						<div class="icon-img">
							<img src="<?php echo base_url('/assets/front/images/new-hammer.png') ?>">
						</div>
						<div class="icon-desp">
							<h4>The job</h4>
							<p>Tell us a little about the job you need help with</p>
						</div>
					</div>

				</div>

				<div class="col-lg-4 col-md-6">

					<div class="works-col">

						<div class="icon-img">
							<img src="<?php echo base_url('/assets/front/images/new-mouse.png') ?>">
						</div>
						<div class="icon-desp">
							<h4>Submit</h4>
							<p>Submit your information and we will get you 3 no obligation quotes from locally trusted traders.</p>
						</div>

					</div>

				</div>

				<div class="col-lg-4 col-md-6 mx-auto">

						<div class="works-col last-icon">

						<div class="icon-img">
							<img src="<?php echo base_url('/assets/front/images/new-review.png') ?>">
						</div>
						<div class="icon-desp">
							<h4>Review</h4>
							<p>Review the quotes and if you wish to proceed you can contact the tradesperson in your own time.</p>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
	<section class="popular-trends">

		<div class="container">

			<div class="row">
				<div class="col-lg-12">
					  <h2>Just some of our popular trades</h2>
				</div>
				<div class="col-md-12">

					<div class="popular-icon">
						<img src="<?php echo base_url('/assets/front/images/paint.png') ?>">
						<h4>Decorator</h4>
					</div>
					<div class="popular-icon">
						<img src="<?php echo base_url('/assets/front/images/arrow.png') ?>">
						<h4>Brick Layer</h4>
					</div>
					<div class="popular-icon">
						<img src="<?php echo base_url('/assets/front/images/cog.png') ?>">
						<h4>Joiner</h4>
					</div>
					<div class="popular-icon">
						<img src="<?php echo base_url('/assets/front/images/ari.png') ?>">
						<h4>Tree Surgeon</h4>
					</div>
					<div class="popular-icon">
						<img src="<?php echo base_url('/assets/front/images/tap.png') ?>">
						<h4>Plumber</h4>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="customer-say">

		<div class="container">

			<div class="row">
				<div class="col-lg-12">
					  <h2>What our customers say about us</h2>
				</div>
				<div class="col-lg-4">
					<div class="testimonial">
						<div class="review-star">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
						</div>
						<div class="desp">
							<p>I decided to get 3 quotes to decorate my back room. I chose the guy I liked and he did a great job. Highly Recommended.</p>
						</div>
						<div class="author-desp">
							<div class="author-img">
								<img src="<?php echo base_url('/assets/front/images/helen.png') ?>">
							</div>
							<div class="author-name">
								<h4>Helen - Manchester</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="testimonial">
						<div class="review-star">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
						</div>
						<div class="desp">
							<p>It was dead easy to do. Got 3 quotes for some outside wiring for a new light we wanted. Picked the cheapest guy and he did it. Really helpful.</p>
						</div>
						<div class="author-desp">
							<div class="author-img">
								<img src="<?php echo base_url('/assets/front/images/mark.png') ?>">
							</div>
							<div class="author-name">
								<h4>Mark - Durham</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="testimonial">
						<div class="review-star">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
						</div>
						<div class="desp">
							<p>Having just moved to the area, I didn’t know any tradespeople. So I used Trusted Traders and it was brill. Such a handy website.</p>
						</div>
						<div class="author-desp">
							<div class="author-img">
								<img src="<?php echo base_url('/assets/front/images/sarah.png') ?>">
							</div>
							<div class="author-name">
								<h4>Sarah - Brighton</h4>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
	<section class="guaranty">

		<div class="container">

			<div class="row">
				<div class="col-lg-3">
					<div class="logo-img">
						<img src="<?php echo base_url('/assets/front/images/logo.svg') ?>">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="guaranty-txt">
						<h4>Guaranteed. Three no obligation quotes from local trusted tradespeople</h4>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="next-btn" id="next_btn">
						<a href="#">Next</a>
					</div>
				</div>
			</div>

		</div>
	</section>
	<section class="trade-img-sec">

		<div class="container">

			<div class="row">
				<div class="col-lg-4">
					<img src="<?php echo base_url('/assets/front/images/repairman-in-uniform-holds-screwdriver-technician-2021-08-26-16-26-43-utc.jpg') ?>">
				</div>
				<div class="col-lg-4">
					<img src="<?php echo base_url('/assets/front/images/concentrated-man-in-safety-gear-building-a-house-2021-09-03-21-02-56-utc.jpg') ?>">
				</div>
				<div class="col-lg-4">
					<img src="<?php echo base_url('/assets/front/images/shutterstock_1946663746.jpg') ?>">
				</div>
			</div>

		</div>
	</section>		

	<section class="about text-center">

		<div class="container">

			<div class="row">
				
				<div class="col-lg-12">

					<h2>About us</h2>

					<p>Trusted Trades was created to make your life easier. We understand how busy people’s lives are and like you we also understand how hard it is to find reliable and trusted tradespeople. But fear not, as Trusted Trades is here to make things simple in just a few clicks!</p>

				</div>

			</div>

		</div>

	</section>
	<section class="contact-sec">

		<div class="container">

			<div class="row">

				<div class="col-lg-6 contact-form">
					<h5>Want to learn more about Trusted Traders? Stay in touch by registering</h5>
						<div class="message_box_contact d-none alert alert-success" role="alert">
                            This is a secondary alert—check it out!
				       </div>
					<form id="contact_us_form"  method="post" >
						<div class="form-group">
					   
					   		 <input type="text" class="form-control" name="name" placeholder="Name" id="name" required>
					  	</div>
					  	<div class="form-group">
					    
					   		 <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
					  	</div>
					  	<div class="form-group">
					   
					   		 <input type="number" class="form-control" placeholder="Tel." id="number" name="number" required>
					  	</div>
					  	<input type="hidden" name="s" value="okk">
					  	<button type="submit" class="btn btn-primary" id="contact_submit">Submit</button>
					</form>
				</div>
				<div class="col-lg-6">
					<div class="contact-img">
						<img src="<?php echo base_url('/assets/front/images/Untitled design (12).png') ?>">
					</div>
				</div>
			</div>

		</div>

	</section>
	
	

	<footer>

		<div class="footer-top">

			<div class="container">

				<div class="row">

					<div class="col-lg-12 text-center">

						<ul class="social-icons">

							<li class="d-inline-block"><a href="https://www.facebook.com/enquiries.blueprint" target="_blank"><i class="fab fa-facebook-f"></i></a></li>


						</ul>



						<ul class="footer-menu">



							<!--<li class="d-inline-block"><a href="#">About us</a></li>-->



							<li class="d-inline-block"><a href="https://www.mytrustedtrades.com/privacy-policy" target="_blank">Privacy policy</a></li>



							<li class="d-inline-block"><a href="https://www.mytrustedtrades.com/terms-and-conditions" target="_blank">Terms & conditions</a></li>



						</ul>



					</div>



				</div>



			</div>



		</div>

        <?php 
          $count = 0;
       // if(isset($all_categories)):
         //  foreach($all_categories as $category):
             
           //    echo '<p>'.$count.' .'.$category['title'].'</p>';
               
            //   $all_categories_sub = $modal->GetTableRows(CATEGORIES_TABLE//,array('parent_id'=> $category['id']),array('title','asc'));
            //   if(isset($all_categories_sub)):
            //    foreach($all_categories_sub as $sub_category):
            //        echo '<p class="sub_category" style="padding-left: 35px;"//>'.$sub_category['title'].'</p>';
            //     endforeach;
            //     endif;
            //     $count++;
        //   endforeach;
            
        
       // endif; 
        ?>

		<div class="footer-bottom">



			<p class="text-center">©<?php echo date('Y'); ?> My Trusted Trades. All Rights Reserved.<br>

				<span class="">Website by <a href="https://www.nexustechies.com/" target="_blank"> Nexus Techies</a></span>



			</p>





		</div>



	</footer>
<style>
.fixed {
    position: fixed;
    z-index: 9;
    background: #fff;
    width: 100%;
}
</style>
	<script type="text/javascript" src="<?= base_url('assets/front'); ?>/js/jquery.js"></script>
<script src="https://cdn.getaddress.io/scripts/jquery.getAddress-4.0.0.min.js"></script>
<script>
function postcode_lookup(){
$('#postcode_lookup').getAddress(
    {
    api_key: 'PTA96qI4wEuDNlVt8fbZWQ39311',  
    output_fields:{
        line_1: '#line1',
        line_2: '#line2',
        line_3: '#line3',
        post_town: '#town',
        county: '#county',
        postcode: '#postcode'
    }
});

}
	var elementTop, elementBottom, viewportTop, viewportBottom;
    function isScrolledIntoView(elem) {
      elementTop = $(elem).offset().top;
      elementBottom = elementTop + $(elem).outerHeight();
      viewportTop = $(window).scrollTop();
      viewportBottom = viewportTop + $(window).height();
      return (elementBottom > viewportTop && elementTop < viewportBottom);
    }
	 $(window).scroll(function () { // video to play when is on viewport 
		$('.middle-section').each(function(){
		  if (isScrolledIntoView(this) == true) {
			   //$(".nav-item ").removeClass('active');
	           $(".header-new").removeClass('fixed');
		  } else {
			  	$(".header-new").addClass('fixed');
		  }
		});
	  }); 
		  
		$(document).on("change", "#sub_categories", function() {

			let category_id = $("#category_id").val();
            
			let sub_category_id = $(this).val();
			
			//for get form section with categories id

			$('#demo .remove_section').remove();
			

			$.ajax({

				type: "GET",

				url: "<?php echo base_url('/get-form-data') ?>",

				data: "sub_category_id=" + sub_category_id,

				dataType: "json",

				success: function(result) {

					if (result.status == "success")

					{

						let last_section_html = $('#last_section').html();

						let section_first = $('#section_first').html();

						$("#form_id").val(result.form_id);
						$('#demo').append(result.html + last_section_html);



					} else

					{


					}

				}

			});

			setTimeout(function() {

				$thing = $('#demo').book({

						onPageChange: updateProgress,

						speed: 200
					}

				).validate();

				/* IE doesn't have a trunc function */

				if (!Math.trunc) {

					Math.trunc = function(v) {

						return v < 0 ? Math.ceil(v) : Math.floor(v);

					};

				}

				/* Update progress bar whenever the page changes */

				function updateProgress(prevPageIndex, currentPageIndex, pageCount, pageName) {

					t = (currentPageIndex / (pageCount - 1)) * 100;

					$('.progress-bar').attr('aria-valuenow', t);

					$('.progress-bar').css('width', t + '%');

					//$('.progress span').text('Completed: '+Math.trunc(t)+'%');

					$('.progress-value').text(Math.trunc(t) + '%');

				}
               postcode_lookup();
			}, 1000);



		});

		/* On select of category_id */

		$(document).on("change", "#category_id", function() {

			$('#demo .remove_section').remove();
			var parent_id = $(this).val();

			if (parent_id != "")

			{

				$.ajax({

					type: "POST",

					url: "<?php echo base_url('/get-subcategories') ?>",

					data: "parent_id=" + parent_id,

					dataType: "json",

					success: function(result) {

						if (result.status == "success")

						{

							$('#sub_categories').html(result.html);

						} else

						{

							$('#sub_categories').html(result.html);

						}

					}

				});

			} else {

				$('#sub_categories').html('<option value="">Please select</option>');

			}

			setTimeout(function() {

				$thing = $('#demo').book({

						onPageChange: updateProgress,

						speed: 200
					}

				).validate();

				/* IE doesn't have a trunc function */

				if (!Math.trunc) {

					Math.trunc = function(v) {

						return v < 0 ? Math.ceil(v) : Math.floor(v);

					};

				}

				/* Update progress bar whenever the page changes */

				function updateProgress(prevPageIndex, currentPageIndex, pageCount, pageName) {

					t = (currentPageIndex / (pageCount - 1)) * 100;

					$('.progress-bar').attr('aria-valuenow', t);

					$('.progress-bar').css('width', t + '%');

					//$('.progress span').text('Completed: '+Math.trunc(t)+'%');

					$('.progress-value').text(Math.trunc(t) + '%');

				}

			}, 1000);

		});


	$(document).on("submit", "#contact_us_form", function() {
	    event.preventDefault();
	    var data = $("#contact_us_form").serialize();
	    		$.ajax({
				type: "POST",
				url: "<?php echo base_url('/add-contact-form-data') ?>",
				data: data,
				dataType: 'json',
				success: function(result) {

					if (result.status == "success") {
                       	$('.message_box_contact').removeClass('d-none');
						$('.message_box_contact').removeClass('alert alert-danger');

						$('.message_box_contact').addClass('alert alert-success');
						$(".message_box_contact").html('<strong>Success! </strong>' + result.message + '.');
						setTimeout(function() {
                         $('.message_box_contact').addClass('d-none');
                       }, 8000);
				    	$("#contact_us_form")[0].reset();

					

					

					} else

					{

						$('.message_box_contact').removeClass('alert alert-success');

						$('.message_box_contact').addClass('alert alert-danger');

						$('.message_box_contact').removeClass('d-none');

						$(".message_box_contact").html(result.message);
                        setTimeout(function() {
                          $('.message_box_contact').addClass('d-none');
                       }, 8000);
						//$('#sub_categories').html(result.html);

					}

				}

			});
	});  
		$(document).on("click", "#submit", function() {

			var file_data = new FormData($('#demo')[0]);

			$.ajax({

				type: "POST",

				url: "<?php echo base_url('/add-form-data') ?>",

				data: file_data,

				dataType: 'json',

				processData: false,

				contentType: false,

				success: function(result) {

					if (result.status == "success") {

						$('.message_box').removeClass('alert alert-danger');

						$('.message_box').addClass('alert alert-success');

						$('.message_box').removeClass('d-none');

						$(".message_box").html('<strong>Success! </strong>' + result.message + '.');

						let redirect_url = "<?php echo base_url('/success') ?>";

						setTimeout(function() {

							window.location.href = redirect_url + '?last_id=' + result.last_id;

						}, 4000);

					} else

					{

						$('.message_box').removeClass('alert alert-success');

						$('.message_box').addClass('alert alert-danger');

						$('.message_box').removeClass('d-none');

						$(".message_box").html(result.message);

						//$('#sub_categories').html(result.html);

					}

				}

			});



			/* else{

				$('#sub_categories').html('<option value="">Please select</option>');

			} */



		});
	$(document).ready(function() {
	    let page = $("#page").val();
	    if(page != ''){
	        $("#"+page).click();
	    }
           
        });
    $(document).on('keyup', ".contact-main-section #getaddress_input", function (e) {
		 $(".contact-main-section #getaddress_button").click();
    });
	$(document).on('change', ".radio-fields input[type='radio']", function (e) {
		$(this).parents('.contact-main-section').find('.radio-fields').removeClass('active');
		$(this).parent('.radio-fields').addClass('active');
    });
$(document).on('click', "#next_btn", function (ev) {

		ev.preventDefault();
        $('html, body').animate({
				scrollTop: $('.form-section').find("#demo").offset().top - 350
			}, 1000);
    });
    
$(document).on('click', "#contact_us", function (ev) {
		ev.preventDefault();
		$(".nav-item ").removeClass('active');
	    $(this).addClass('active');
        $('html, body').animate({
				scrollTop: $('.contact-sec').offset().top - 80
			}, 2000);
    });
    $(document).on('click', "#about", function (ev) {
		ev.preventDefault();
		$(".nav-item ").removeClass('active');
	    $(this).addClass('active');
        $('html, body').animate({
				scrollTop: $('.about').offset().top - 160
			}, 2000);
	         	
    });
     $(document).on('click', "#how_it_work", function (ev) {
		ev.preventDefault();
		$(".nav-item ").removeClass('active');
	    $(this).addClass('active');
        $('html, body').animate({
				scrollTop: $('.three-icon').offset().top - 80
			}, 2000);
    });
		$(document).on("change", "input:file", function() {

			var self = $(this);

			var key = $(this).attr('name');;

			var data = new FormData();

			jQuery.each(jQuery($(this))[0].files, function(i, file) {

				data.append(i++, file);

			});

			//var file_data = new FormData($('#demo')[0]);

			$.ajax({

				type: "POST",

				url: "<?php echo base_url('/file-upload') ?>",

				data: data,

				dataType: 'json',

				processData: false,

				contentType: false,

				success: function(result) {

					if (result.status == "success")

					{

						self.next().val(result.media_id);

					} else

					{



					}

				}

			});



		});
	</script>





	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>



	<script type="text/javascript" src="<?= base_url('assets/front/'); ?>/js/bootstrap.min.js"></script>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>



	<script type="text/javascript" src="<?= base_url('assets/front/'); ?>/js/jquery-book.js"></script>



	<script type="text/javascript" src="<?= base_url('assets/front/'); ?>/js/script.js"></script>



</body>



</html>



<style>
	.step-from .required_star::after {

		content: "*";

		color: red;

		font-size: 16px;

		font-weight: 500;

	}



	.page .required_input::after {

		content: "*";

		color: red;

		font-size: 20px;

		font-weight: 500;

	}
	span.field_error {
        color: red !important;
    }
    p.field_error {
        color: red !important;
    }
	.works h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 15px 0 30px;
    }
    
    
    .work-icon {
        margin: 10px auto;
        font-size: 25px;
        font-weight: 600;
        padding: 10px 0 0;
    }
</style>