
/*scroll to top*/
$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});








$(document).ready(function(){
    $('#size').on('change',function(event){
        const productId    = this.dataset.productid;
        const attributeId  = this.value;
        axios.get(`/get-product-price/${productId}/${attributeId}`).then(res=>{
             document.querySelector('#getPrice').innerHTML = `TK ${res.data.price}`;
             if(res.data.stock > 0 ){
                 $("#stock").text('In Stock');
                 $('#addToCart').show();
             }
             else{
                 $("#stock").text('Out Of Stock');
                 $('#addToCart').hide();
             }
        }).catch(err=>{
               console.log(err);
        });
     });





     $(".changeImage").on('click',function(event){
           let src = $(this).attr('src');
           $('#mainImage').attr('src',src);
     })

     //easyzoom plugin
     // Instantiate EasyZoom instances
		var $easyzoom = $('.easyzoom').easyZoom();

		// Setup thumbnails example
		var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

		$('.thumbnails').on('click', 'a', function(e) {
			var $this = $(this);
			e.preventDefault();

			// Use EasyZoom's `swap` method
			api1.swap($this.data('standard'), $this.attr('href'));
		});
});
