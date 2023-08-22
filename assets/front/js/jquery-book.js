/*
 * jQuery Book - A multi-step form
 * https://github.com/phaelax/jQuery.Book
 *
 * Copyright 2020, Dustin Zimnox
 * http://zimnox.com
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

(function($){
	$.fn.book = function(options){
		console.log(options)
		var defaults = {
			onPageChange: function(){},
			speed: 400
		};
		
		var settings = $.extend(defaults, options);
		
		
		if (this.length > 1){
			this.each(function(){ $(this).book(options) });
			return this;
		}
		
		var pageIndex = 0;
		
		var $this = $(this);
		
		// The sections need to match the parent (<form>) container's size for animation to look correct
		var pages = $this.children('section').css({width:'100%',height:'100%',position:'relative'}); 
			//console.log(pages);
		
		
		// The form will expand to fit the container it's in (unless overridden).
		//this.css({width:'100%', display:'flex', margin:'auto', overflow:'hidden'});  
		
		
		
		// Hide all but the first page
		// Add events to next and previous buttons found in the form
		this.initialize = function(){
			pages.hide();
			pages.first('section').show();
			pages.find('.page-next').on('click', this.nextPage);
			pages.find('.page-prev').on('click', this.prevPage);
			return this;
		}
		
		
		// Get current page number
		this.getPageIndex = function(){
			return pageIndex;
		}
		
		
		// Returns number of pages in this book
		this.getPageCount = function(){
			return pages.length;
		}
		
	
		// Set to a specific page
		this.setPage = function(i){
			
			return changePage(i);
		}
		
		
		
		
		function changePage(index){
			
			if (index >= 0 && index < pages.length && index != pageIndex){
				

				// Only check validation if moving forward. Exit early if validation fails.
				if ((index > pageIndex) && (typeof $this.valid === 'function')){
					if (!$this.valid()){
						return this;
					}
				}
				oldPageIndex = pageIndex;            // retain for callback info
				$currentPage = pages.eq(pageIndex);  // Get currently display page to slide off screen
				$newPage     = pages.eq(index);      // Get target page to slide onto screen
				pageIndex    = index;                // update pageIndex
				pageName     = ($newPage[0].hasAttribute("name")) ? $newPage.attr('name') : null;  // used in callback
				
				//console.log($newPage);
				
				

				
				if (typeof settings.onPageChange == 'function'){
					settings.onPageChange.call(this, oldPageIndex, pageIndex, pages.length, pageName );
				}
				
				
				
				if (index > oldPageIndex){ // move forward
						
					$currentPage.hide("slide", {direction:"left"}, settings.speed, function(){
						$newPage.show("slide", {direction:"right"}, settings.speed);
					});
				
				}else{ // move back  
				
					$currentPage.hide("slide", {direction:"right"}, settings.speed, function(){
						$newPage.show("slide", {direction:"left"}, settings.speed);
					});
					
				}
				
			}
			return this;
			/* $('html, body').animate({
				scrollTop: $(".row").offset().top
			}, 2000); */
		};
		
		
		
		// Moves forward to the next page, if one is available
		this.nextPage = function(){
			let nextpagestatus = true;
			let count = 1;
			$(".field_error").remove();
			var data = $(document).find('.myBook section').eq(pageIndex).find('select,input').each(function(){
				    $(this).parent().find("span .field_error").remove();
					var value = "";
					var type = $(this).attr('type');
					var key = $(this).attr('name');
					var is_required = $(this).attr('is_required');
					if(type == 'checkbox'){
						value = $('input[name="'+key+'"]:checked').val();
						//$(this).closest('.main_label').find(".label").attr('sd','wsdewe');
						if(typeof value != 'undefined'){
						  // alert('yes')
					     }else{
							 if(value == "" || is_required == '1'){
								$(this).parents('section').find(".main_label_parent").append("<p class='field_error'>This field is required.</p>");;
								// $$(this).parent().attr('id'));
								/* $(this).closest('.main_label').find(".label").attr('sd','wsdewe');
							   var error_html = '<span class="error">This field is rquired.</span>';
								$(document).find('input[name="'+key+'"]').parent().append(error_html);
								$(document).find('select[name="'+key+'"]').parent().append(error_html); */
								nextpagestatus = false;
								return false;
							 }
						 }
						// alert(value) 
					}
					if(type == 'radio'){
						value = $('input[name="'+key+'"]:checked').val();
						//$(this).closest('.main_label').find(".label").attr('sd','wsdewe');
						if(typeof value != 'undefined'){
						  // alert('yes')
					     }else{
							 if(value == "" || is_required == '1'){
							   $(this).parents('section').find(".main_label_parent").append("<p class='field_error'>This field is required.</p>");;
								// $$(this).parent().attr('id'));
								/* $(this).closest('.main_label').find(".label").attr('sd','wsdewe');
							   var error_html = '<span class="error">This field is rquired.</span>';
								$(document).find('input[name="'+key+'"]').parent().append(error_html);
								$(document).find('select[name="'+key+'"]').parent().append(error_html); */
								nextpagestatus = false;
								return false;
							 }
						 }
						// alert(value) 
					}
					else if($(this).hasClass('first_name')){
						value = $(this).val();
						//var desired = stringToReplace.replace(/[^\w\s]/gi, '')
						if(containsSpecialChars(value) && is_required == '1'){
							let newvalue = value.replace(/[^\w\s]/gi, '');
							$(this).val(newvalue);
						    var error_html = '<span class="field_error" style="font-size:12px;">No Special characters Allowed.</span>';
							$(document).find('input[name="'+key+'"]').parent().append(error_html);
							$(document).find('select[name="'+key+'"]').parent().append(error_html);
					        nextpagestatus = false;
					     }
						else if(value == "" && is_required == '1'){
						    var error_html = '<span class="field_error">This field is rquired.</span>';
							$(document).find('input[name="'+key+'"]').parent().append(error_html);
							$(document).find('select[name="'+key+'"]').parent().append(error_html);
					        nextpagestatus = false;
					     }
					}
					else if($(this).hasClass('last_name')){
						value = $(this).val();
						let first_name = $(this).parents('section').find('.first_name').val();
						//var desired = stringToReplace.replace(/[^\w\s]/gi, '')
						if(containsSpecialChars(value) && is_required == '1'){
							let newvalue = value.replace(/[^\w\s]/gi, '');
							$(this).val(newvalue);
						    var error_html = '<span class="field_error" style="font-size:12px;">No Special characters Allowed.</span>';
							$(document).find('input[name="'+key+'"]').parent().append(error_html);
							$(document).find('select[name="'+key+'"]').parent().append(error_html);
					        nextpagestatus = false;
					     }
						else if(value == "" && is_required == '1'){
						    var error_html = '<span class="field_error">This field is rquired.</span>';
							$(document).find('input[name="'+key+'"]').parent().append(error_html);
							$(document).find('select[name="'+key+'"]').parent().append(error_html);
					        nextpagestatus = false;
					     }
						 else if(first_name == value){
						    var error_html = '<span class="field_error">First and last name cannot be same.</span>';
							$(document).find('input[name="'+key+'"]').parent().append(error_html);
							$(document).find('select[name="'+key+'"]').parent().append(error_html);
					        nextpagestatus = false;
					     }
					}
					else if($(this).hasClass('phone_number')){
						value = $(this).val();
						//var phone = document.forms["myForm"]["phone"].value;
						var phoneNum = value.replace(/[^\d]/g, '');
						if(phoneNum.length < 11){  
						        var error_html = '<span class="field_error">Please enter at least 11 characters.</span>';
								$(document).find('input[name="'+key+'"]').parent().append(error_html);
								$(document).find('select[name="'+key+'"]').parent().append(error_html);
								nextpagestatus = false;
						}
						else if(phoneNum.length > 11) {  
						        var error_html = '<span class="field_error">Only 11 characters are allowed.</span>';
								$(document).find('input[name="'+key+'"]').parent().append(error_html);
								$(document).find('select[name="'+key+'"]').parent().append(error_html);
								nextpagestatus = false;
						}
						
						/* if(value == "" && is_required == '1'){
						    var error_html = '<span class="error">This field is rquired.</span>';
							$(document).find('input[name="'+key+'"]').parent().append(error_html);
							$(document).find('select[name="'+key+'"]').parent().append(error_html);
					        nextpagestatus = false;
					     } */
					}
					else{
						value = $(this).val();
						if(value == "" && is_required == '1'){
						    var error_html = '<span class="field_error">This field is rquired.</span>';
							$(document).find('input[name="'+key+'"]').parent().append(error_html);
							$(document).find('select[name="'+key+'"]').parent().append(error_html);
					        nextpagestatus = false;
					     }
					}
					
					//alert($('input[name='+name+']:checked'));
					
				})
		  if(nextpagestatus == true){
			  
			 if (pageIndex >= pages.length-1) return this;
			return changePage(pageIndex+1); 
			
		  }
		};
		
		// Moves back to the previous page. If on first page already, does nothing
		this.prevPage = function(){
			if (pageIndex == 0) return this;
			return changePage(pageIndex-1);
		};
		return this.initialize();
	};
	function containsSpecialChars(str) {
			  const specialChars =
				'[`!@#$%^&*()_+-=[]{};\':"\\|,.<>/?~]/';
			  return specialChars
				.split('')
				.some((specialChar) => str.includes(specialChar));
			}
	$(document).on("keyup", ".first_name", function (){
		$(this).parent('.form-group').find(".field_error").remove();
		var is_required = $(this).attr('is_required');
		var value = $(this).val();
		if(containsSpecialChars(value)){
			let newvalue = value.replace(/[^\w\s]/gi, '');
			$(this).val(newvalue);
			var error_html = '<span class="field_error" style="font-size:12px;">No Special characters Allowed.</span>';
			$(this).parent().append(error_html);
		 }
	}); 
	$(document).on("keyup", ".last_name", function (){
		$(this).parent('.form-group').find(".field_error").remove();
		var is_required = $(this).attr('is_required');
		var value = $(this).val();
		if(containsSpecialChars(value)){
			let newvalue = value.replace(/[^\w\s]/gi, '');
			$(this).val(newvalue);
			var error_html = '<span class="field_error" style="font-size:12px;">No Special characters Allowed.</span>';
			$(this).parent().append(error_html);
		 }
		 value = $(this).val();
		let first_name = $(this).parents('section').find('.first_name').val();
		if(first_name == value){
			var error_html = '<span class="field_error" style="font-size:12px;">First and last name cannot be same.</span>';
			$(this).parent().append(error_html);
		}
		//alert(first_name)
	}); 
	$(document).on("keyup", ".name_valid_2", function (){
		var value = $(this).val();
		alert(value)
	}); 
	$(document).on("change", "input", function (){
	  
	    let key = $(this).attr('type');
		if(key != 'radio'){
		   $(this).parent().find("span").remove();
		}
	}); 
	/* $(document).on("click", ".btn", function (){
		
	});  */
	$(document).on("focus", "select", function (){
	   
	   let key = $(this).attr('type');
		if(key != 'radio'){
		   $(this).next("span").remove();
		}
	}); 
	
}(jQuery));
