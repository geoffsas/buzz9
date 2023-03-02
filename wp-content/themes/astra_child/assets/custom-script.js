jQuery(function ($) {
	$("#btzip").click(function(){ 
	   var that = $(this),
	   type = that.attr('method');
	   var zipcode = $('#zip_code').val();
		if(zipcode){
			window.location = '/form?business-zipcode=' + zipcode;
		}else{
			$( "div.failure" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
		}
// 	   $.ajax({
// 		  url: ajax_object.ajax_url,
// 		  type:"POST",
// 		  dataType:'type',
// 		  data: {
// 			 action:'sent_zipcode_form',
// 			 zipcode:zipcode,
// 		},   success: function(response){
// 			alert('00000');
// 			$(".success_msg").css("display","block");
// 		 }, error: function(data){
// 			 $(".error_msg").css("display","block");      }
// 	   });
  });
	
    $('#signature-pad').unwrap();
    $('.clear-button').unwrap();
//     $('.submit-form-check a').addClass('disabled-anchor');
    $(document.body).on('click', '#wpforms-form-851 button.wpforms-page-next', function () {

        var selectedval = $(".wpforms-form input[type='radio']:checked").val();

        if (selectedval == "No" || selectedval == "NO") {

            $('.wpforms-page-next').css('display', 'none');

        }

        if (selectedval == "Yes") {

            $("button.wpforms-page-next").addClass("show-next");

        }

    });
    $(document).on('input', '.company_names', function () {
        let search = $(this).find('input').val();
        console.log(search);
        $.ajax({

            url: ajax_object.ajax_url,

            type: 'POST',

            dataType: 'json',

            data: {

                'action': 'search_companies',

                'search': search,

            },

            success: function (data) {
                $('.companies_list ul').remove();
                if (data.type == 'success') {
                    let listItems = [];
                    var listParent = $('<ul></ul>')
                    $(data.response).each(function (i, li) {
                        listItems.push("<li>" + li + "</li>");
                    });
                    listParent.append(listItems);
                    $('.companies_list').append(listParent);
                    $('.companies_list').addClass('open');
                } else if (data.type == 'error') {
                    $('.companies_list').removeClass('open');
                }


            },

            error: function (errorThrown) {



            }

        });
    });
    $(document).on('click', '.companies_list ul li', function () {
        let list_value = $(this).text();
        $('.company_names input').val(list_value);
        $('.company_name_hidden input').val(list_value);
        $('.companies_list ul').remove();
        $('.companies_list').removeClass('open');
    });
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
        backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
    });
    var cancelButton = document.getElementById('clear-sign');
    cancelButton.addEventListener('click', function (event) {
        signaturePad.clear();
    });
    $(document).on('input','.business_postcode #wpforms-603-field_1', function() {
	
		let post_code = $(this).val();
		console.log(post_code);
//         if(is_ukPostCode(post_code)) {
//             $('.submit-form-check a').removeClass('disabled-anchor');
//         } else {
//             $('.submit-form-check a').addClass('disabled-anchor');
//         }
	
       
    });
	
});

function is_ukPostCode(str) {
    regexp = /^[A-Z]{1,2}[0-9RCHNQ][0-9A-Z]?\s?[0-9][ABD-HJLNP-UW-Z]{2}$|^[A-Z]{2}-?[0-9]{4}$/;
    if (regexp.test(str)) {
        return true;
    } else {
        return false;
    }
}