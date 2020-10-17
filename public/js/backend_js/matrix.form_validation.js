
$(document).ready(function(){

	$("#current_pwd").keyup(function(){
        let current_pwd = $("#current_pwd").val();

        axios({
            method: 'get',
            url: '/admin/check-pwd',
            params:{
                current_pwd: current_pwd
            }
          }).then(res=>{

            if(res.data == false){
                $("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
            }
            else{
                $("#chkPwd").html("<font color='green'>Current Password is Correct</font>")
            }
        }).catch(error=>{
            console.log(error);
            alert(error);
        });
	});


	$('input[type=checkbox],input[type=radio]').uniform();

	$('select').select2();

	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Add Category Validation
    $("#add_category").validate({
		rules:{
			category_name:{
				required:true
			},
			description:{
				required:true,
			},
			url:{
				required:true,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Add Product Validation
    $("#add_product").validate({
		rules:{
			category_id:{
				required:true
			},
			product_name:{
				required:true
			},
			product_code:{
				required:true,
			},
			product_color:{
				required:true,
			},
			price:{
				required:true,
				number:true
            },
            care:{
				required:true,
			},

		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
    });

    $("#edit_product").validate({
		rules:{
			category_id:{
				required:true
			},
			product_name:{
				required:true
			},
			product_code:{
				required:true,
			},
			product_color:{
				required:true,
			},
			price:{
				required:true,
				number:true
            },
            care:{
				required:true,
			},

		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
    });

    $("#add_coupon").validate({
		rules:{
			coupon_code:{
				required:true
			},
			amount_type:{
				required:true
			},
			amount:{
				required:true,
			},
			expire_date:{
				required:true,
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
    });

    $("#add_banner").validate({
		rules:{
			title:{
				required:true
			},
			image:{
				required:true
			},
			link:{
				required:true,
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
    });





	// Edit Category Validation
    $("#edit_category").validate({
		rules:{
			category_name:{
				required:true
			},
			description:{
				required:true,
			},
			url:{
				required:true,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#password_validate").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});



    $('.deleteRecord').on('click',function(event){
        event.preventDefault();
        let recoredId = $(this).attr('rel');
        let recoredUrl = $(this).attr('rel1');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons:true
          }).then((result) => {
            if (result.isConfirmed) {

              axios.get(`/admin/${recoredUrl}/${recoredId}`).then(res=>{
                    Swal.fire(
                        'Deleted!',
                        res.data,
                        'success'
                    );
                    autometaTag();
              }).catch(err=>{
                      console.log(err);
                        Swal.fire(
                            'Error!',
                            'Some Error occured',
                            'error'
                    );
              });

            }else{
                Swal.fire(
                    'Cancelled',
                    'Your Recored is safe :)',
                    'success'
                );
            }
        })
    });

});


$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.attribute-wrapper'); //Input field wrapper
    var fieldHTML = ` <div class="input-group">
            <input style="width:100px;" type="text" name="sku[]" placeholder="sku" class="form-control" required>
            <input style="width:100px;" type="text" name="size[]" placeholder="size" class="form-control" required>
            <input style="width:100px;" type="text" name="stock[]" placeholder="stock" class="form-control" required>
            <input style="width:100px;" type="text" name="price[]" placeholder="price" class="form-control" required>
            <button  class="btn btn-danger btn-mini remove_button">remove</button>
       </div>`; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

function autometaTag(){
    let headTag = document.querySelector('head');
    let metaTag = document.createElement('meta');
    metaTag.setAttribute('http-equiv','refresh');
    metaTag.setAttribute('content',3);
    headTag.appendChild(metaTag);

}
