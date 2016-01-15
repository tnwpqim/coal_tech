<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<!-- jquery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){
	$("#reset_btn").click(function(){
        
		propagate_csrf_code();
   		jQuery.ajax({
            url: "/ct_reset",
            type: "POST",
            data: {   
//                "product_name":product_name,
 //               "quantity":quantity,
 //               "price":price
			},
            dataType : "json",
            beforeSend: function () {
            },               
            success: function( data ) {
                $('#results').html("");
            	$('#total').html("");
                // end headings row
//                console.log("file deleted");

            },
            error: function( xhr, status, errorThrown ) {
                console.log("Ajax error");
            }
        });  // end jquery ajax
		
    }); // end on dropdown change
	
	
	$("#update_btn").click(function(){
        var product_name = $("#product_name").val();
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var results;
        var total = 0;
               
		propagate_csrf_code();
   		jQuery.ajax({
            url: "/ct_form",
            type: "POST",
            data: {   
                "product_name":product_name,
                "quantity":quantity,
                "price":price
			},
            dataType : "json",
            beforeSend: function () {
//            console.log('AJAX sent');
            },               
            success: function( data ) {
//        	console.log(data);
                        
				results = start_row();
				results = results + start_column(1);             
                results = results + "";
                results = results + end_div();
				results = results + start_column(2);             
                results = results + "Product";
                results = results + end_div();
				results = results + start_column(1);
                results = results + "Quantity";
                results = results + end_div();
				results = results + start_column(1);
                results = results + "Price";
                results = results + end_div();
				results = results + start_column(3);
                results = results + "Date";
                results = results + end_div();
				results = results + start_column(3);
                results = results + "Time";
                results = results + end_div();
				results = results + start_column(1);
                results = results + "ID";
                results = results + end_div();
                results = results + end_div(); // end row
                // end headings row
                
                $.each( data, function( key, value ) {
  //               console.log(key);
  //               console.log(value);   
    				results = results + start_row();
    				results = results + start_column(1);             
                    results = results + "Item";
                    results = results + end_div();
    				results = results + start_column(2);             
                    results = results + value.product_name;
                    results = results + end_div();
    				results = results + start_column(1);
                    results = results + value.quantity;
                    results = results + end_div();
    				results = results + start_column(1);
                    results = results + value.price;
                    results = results + end_div();
    				results = results + start_column(3);
                    results = results + value.date_formatted;
                    results = results + end_div();
    				results = results + start_column(3);
                    results = results + value.time_formatted;
                    results = results + end_div();
    				results = results + start_column(1);
    				results = results + "<a href='/edit'" + value.id + ">";
                    results = results + value.id;
                    results = results + "</a>"
                    results = results + end_div();
                    results = results + end_div(); // end row
					total = total + (parseInt(value.quantity) * parseInt(value.price));
//					console.log("total = " + total);
                });  // end .each loop
            	$('#results').html(results);
				results = start_row();
				results = results + start_column(4);             
                results = results + "";
                results = results + end_div();
				results = results + start_column(2);             
                results = results + "Total equals ";
                results = results + end_div();
				results = results + start_column(6);             
                results = results + "$" + total + ".00";
                results = results + end_div();
                results = results + end_div(); // end row
            	$('#total').html(results);
                
//              	console.log($('#results').html());
              
             	$("#product_name").val("");
             	$("#quantity").val("");
             	$("#price").val("");

            },
            error: function( xhr, status, errorThrown ) {
                console.log("Ajax error");
            }
        });  // end jquery ajax
        
    }); // end on dropdown change


    function propagate_csrf_code()
    {
        var csrf_token = $("input[name=_token]").val();

// laravel imposes csrf protection - the ajax setup 
// sends the csrf token in the header to remove the 
// 500 internal service error 
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': csrf_token
			}
		});
    }     // end function propagate_csrf_code  

function start_row()
{
	return '<div class="row">';
}

function start_column(width)
{
	return '<div class="col-sm-' + width + '">';
}


function end_div()
{
//	console.log("function end_div invoked");
	return "</div>";
}
}); // end on doc ready


</script>

</head>
    <body>
<div class="container">

<div class="row">
<div class="col-sm-3"><br><br><br> </div>
<div class="col-sm-6"> 
<br>
    </div>
<div class="col-sm-3"> </div>
</div><!-- end row -->



<div class="row">
<div class="col-sm-3"><br><br> </div>
<div class="col-sm-6"> 
CT form - Doug Bittinger
    </div>
<div class="col-sm-3"> </div>
</div><!-- end row -->

	<form method="POST" action="/ct_form">
     
<div class="row">
<div class="col-sm-1"> <br><br></div>
<div class="col-sm-4"> 
   Product name            
    </div>
<div class="col-sm-4">
 <input type="text" name="product_name" id="product_name" value="">
   
</div>
    <div class="col-sm-2"> </div>
<div class="col-sm-1"> </div>
</div><!-- end row -->
  
       
<div class="row">
<div class="col-sm-1"> <br><br></div>
<div class="col-sm-4"> 
   Quantity in stock           
    </div>
<div class="col-sm-4">
 <input type="text" name="quantity" id="quantity" value="">
   
</div>
    <div class="col-sm-2"> </div>
<div class="col-sm-1"> </div>
</div><!-- end row -->
  
       
<div class="row">
<div class="col-sm-1"> <br><br><br></div>
<div class="col-sm-4"> 
   Price per item - please enter as integer, no dollar sign, no decimal, no cents value          
    </div>
<div class="col-sm-4">
 <input type="text" name="price" id="price" value="">
   
</div>
    <div class="col-sm-2"> </div>
<div class="col-sm-1"> </div>
</div><!-- end row -->
  
       
<div class="row">
<div class="col-sm-1"> <br></div>

<div class="col-sm-5">
 <input type="button" id="update_btn" value="update info">
   
</div>
    <div class="col-sm-5"> <input type="button" id="reset_btn" value="reset">
     </div>
<div class="col-sm-1"> </div>
</div><!-- end row -->
  
</form>
<div id="results_div">
<span id="results"></span>
</div>
<br>
<div id="total_div">
<span id="total"></span>
</div>
</div><!-- end container -->
    </body>
</html>
