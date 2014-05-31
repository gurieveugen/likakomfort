jQuery( document ).ready(function() 
{
	if(jQuery("#map-canvas").length)
	{
		google.maps.event.addDomListener(window, 'load', initialize);
	}	
	if(jQuery('#mycarousel').length)
	{
		jQuery('#mycarousel').jcarousel({
			wrap: 'circular',
			scroll: 1,
			buttonNextHTML: null,
	        buttonPrevHTML: null
		});	
	}

	// jQuery('.jcarousel').jcarousel({
 //    	items: '.jcarousel-item'
	// });

	console.log(jQuery('.jcarousel').html());
	
	jQuery(".fancybox").fancybox({
			openEffect	: 'none',
			closeEffect	: 'none'
		});

	check_input_checked();
	
	jQuery('.product input[type="checkbox"]').change(function(event){
		check_input_checked();
	});

	if(typeof(cats) !== 'undefined')
	{
		// console.log(cats);current-menu-item
		for(var cat in cats)
		{
			jQuery('#menu-leftmenu').find('a').each(function(){
				if(jQuery(this).html() == cats[cat])
				{
					jQuery(this).parent().addClass('current-menu-item')
				}
			});			
		}
	}

	jQuery('#search-by-price').submit(function(e){		
		var start_price = jQuery("[name=start_price]").val();
		var end_price   = jQuery("[name=end_price]").val();

		jQuery.ajax({ 
			url: "/wp-admin/admin-ajax.php?action=search_by_price",
			type: "POST",
			dataType: 'json',
			data: { search_by_price: "true",
					start_price: start_price,
					end_price: end_price
			},		
			success: function(data)
			{	
				return true;		
			},
			error: function()
			{
				return false;
			}
		});
	});
	
});

function check_input_checked()
{
	var products = new Array();
	if(jQuery( "input:checked" ).length >= 2) 
	{
		jQuery('.product input[type="checkbox"]:checked').each(function(index){
			products[index] = jQuery(this).data('id');
		});
		jQuery('.product input[type="checkbox"]:not(:checked)').each(function(){			
			jQuery(this).attr('disabled','disabled');
		});
		jQuery('#modal_compare').modal();
	}
	else
	{
		jQuery('.product input[type="checkbox"]').each(function(){
			jQuery(this).removeAttr('disabled');
		});
	}

	jQuery('#compare-button').attr('onclick', 'window.open(\'/compare/?c1='+products[0] + '&c2='+products[1]+'&p='+window.location.pathname+'\');');
}

/**
 * Buy Product
 * @param  {integer} id 
 */
function buy(id)
{	
	if( id != "" )
	{
		jQuery.ajax({ 			
			url: "/wp-admin/admin-ajax.php?action=buy",
			type: "POST",
			dataType: 'json',
			data: { buy: "BUY", id: id }		
		})
		.done(function( data ) {
			if(data.status == "OK")
			{
				jQuery("#modal_add_product").modal();
			}
			jQuery(".total-sum").html(data.sum);
		});
	}
}
/**
 * Remove product from cart
 * @param  {integer} id 
 */
function buy_cancel(id)
{
	if(id != "")
	{
		jQuery.ajax({ 
			url: "/wp-admin/admin-ajax.php?action=buy_cancel",
			type: "POST",
			dataType: 'json',
			data: { BUY_CANCEL: "BUY_CANCEL", id: id },		
			success: function(data)
			{	
				jQuery(".cart-table").html(data.table);
				jQuery(".total-sum").html(data.sum);
			}
		});
	}
}

/**
 * Remove all products
 */
function cancel_all_buys()
{
	jQuery.ajax({ 
		url: "/wp-admin/admin-ajax.php?action=cancel_all_buys",
		type: "POST",
		dataType: 'json',
		data: { CANCEL_ALL_BUYS: "CANCEL_ALL_BUYS" },		
		success: function(data)
		{	
			jQuery(".cart-table").html(data.table);
			jQuery(".total-sum").html(data.sum);
		}
	});
	
}

/**
 * Send order to admin email
 */
function send_order()
{
	var fullname = jQuery('[name=fullname]').val(); 
	var email    = jQuery('[name=email]').val(); 
	var contacts = jQuery('[name=contacts]').val()

	console.log(fullname);
	console.log(email);
	console.log(contacts);

	jQuery.ajax({ 
		url: "/wp-admin/admin-ajax.php?action=send_order",
		type: "POST",
		dataType: 'json',
		data: { send_order: "send_order",
				fullname: fullname,
				email: email,
				contacts: contacts
		 		},		
		success: function(data)
		{	
			jQuery(".cart-table").html(data.table);
			jQuery(".total-sum").html(data.sum);
			jQuery(".form-order").html(data.msg);
		}
	});
}

function set_numeric_sort()
{
	jQuery.ajax({ 
		url: "/wp-admin/admin-ajax.php?action=numeric_sort",
		type: "POST",
		dataType: 'json',
		data: { numeric_sort: "true" }
	});
}

function unset_numeric_sort()
{
	jQuery.ajax({ 
		url: "/wp-admin/admin-ajax.php?action=unset_numeric_sort",
		type: "POST",
		dataType: 'json',
		data: { unset_numeric_sort: "true" }
	});
}

function search_by_price()
{
	var start_price = jQuery("[name=start_price]").val();
	var end_price   = jQuery("[name=end_price]").val();

	jQuery.ajax({ 
		url: "/wp-admin/admin-ajax.php?action=search_by_price",
		type: "POST",
		dataType: 'json',
		data: { search_by_price: "true",
				start_price: start_price,
				end_price: end_price
		},		
		success: function(data)
		{	
			jQuery('#search-by-price').trigger('submit');
		}
	});
}