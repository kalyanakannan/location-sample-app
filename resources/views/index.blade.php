@extends('layouts.index')
@section('content')
@endsection

@section('custom_js')
<script type="text/javascript">
	  	if (navigator.geolocation) {
	  		var input = document.getElementById('search');
	        var searchBox = new google.maps.places.Autocomplete(input);
	        var geocoder = new google.maps.Geocoder();
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};

				var latlng = new google.maps.LatLng(pos.lat, pos.lng);
	            geocoder.geocode({'latLng': latlng}, function(results, status) {
	                if(status == google.maps.GeocoderStatus.OK) {
	                	$("#search").val(results[0]['formatted_address']);
	                	$("#location-details").text(results[0]['formatted_address']);
	                	$("#longitude").text("(longitude : "+pos.lng);
	          			$("#latitude").text("latitude : "+pos.lat+")");
	                	$.ajax({
							url: "/items",
							cache: false,
							success: function(items){
								$("#items").empty();
								$("#items").append(items);
							}
						});
	                };
	            });
	    	});
			searchBox.addListener('place_changed', function() {
	          var place = searchBox.getPlace();
	          console.log(place.geometry.viewport.b.b);
	          console.log(place.geometry.viewport.f.b);
	          $.ajax({
					url: "/items",
					cache: false,
					success: function(items){
						$("#items").empty();
						$("#items").append(items);
					}
				});
	          $("#location-details").text(place.formatted_address);
	          $("#longitude").text("(longitude : "+place.geometry.viewport.b.b);
	          $("#latitude").text("latitude : "+place.geometry.viewport.f.b+")");
	        });
	    }
	    $('body').on('click', '.cart-minus', function(event) {
	    	event.preventDefault();
	    	var product_id = $(this).attr('data-product-id');
	    	var cart_total = $("#cart_"+product_id).val();
	    	if(!$.isNumeric(cart_total))
	    	{
	    		cart_total = 0;
	    		$("#cart_"+product_id).val("0");
	    	}
	    	if(parseInt(cart_total)>0)
	    		$("#cart_"+product_id).val(parseInt(cart_total)-1);
	    });

	    $('body').on('click', '.cart-plus', function(event) {
	    	event.preventDefault();
	    	var product_id = $(this).attr('data-product-id');
	    	var cart_total = $("#cart_"+product_id).val();
	    	if(!$.isNumeric(cart_total))
	    	{
	    		cart_total = 0;
	    	}
	    	if(parseInt(cart_total)>=0)
	    		$("#cart_"+product_id).val(parseInt(cart_total)+1);
	    });

	   $("#locate-me").click(function(e){
	   		navigator.geolocation.getCurrentPosition(function(position) {
				var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};
				var latlng = new google.maps.LatLng(pos.lat, pos.lng);
	            geocoder.geocode({'latLng': latlng}, function(results, status) {
	                if(status == google.maps.GeocoderStatus.OK) {
	                	$("#search").val(results[0]['formatted_address']);
	                	$("#location-details").text(results[0]['formatted_address']);
	                	$("#longitude").text("(longitude : "+pos.lng);
	          			$("#latitude").text("latitude : "+pos.lat+")");
	                	$.ajax({
					url: "/items",
					cache: false,
					success: function(items){
						$("#items").empty();
						$("#items").append(items);
					}
				});

	                }
	            });
	    	});
	   });
  	</script>
@endsection