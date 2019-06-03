function yesnoCheck(that) {
    if (that.value === "EMI") {
        document.getElementById("emi_row").style.display = "block";
    } else {
        document.getElementById("emi_row").style.display = "none";
    }
}

$(document).ready(function(){
    
        $('[name="customer"]').click(function () {
            var customer = $('[name="customer"]').val();

            if(customer === 'Existing Customer'){
                $('full_name').attr('readonly', true);
                $('address_line').attr('readonly', true);
                $('city').attr('readonly', true);
                $('state').attr('readonly', true);
                $('country').attr('readonly', true);
                $('postcode').attr('readonly', true);
                $('mobileno1').attr('readonly', true);
                $('mobileno2').attr('readonly', true);
                $('dob').attr('readonly', true);
                $('aadharno').attr('readonly', true);
                $('panno').attr('readonly', true);
            }else if(customer === 'New Customer'){
                $('full_name').removeAttr('readonly');
                $('address_line').removeAttr('readonly');
                $('city').removeAttr('readonly');
                $('state').removeAttr('readonly');
                $('country').removeAttr('readonly');
                $('postcode').removeAttr('readonly');
                $('mobileno1').removeAttr('readonly');
                $('mobileno2').removeAttr('readonly');
                $('dob').removeAttr('readonly');
                $('aadharno').removeAttr('readonly');
                $('panno').removeAttr('readonly');
            }
            
        
    });
        
        $("#add-row").click(function(){
            var id = $('[name="id"]').val();
            var name = $('[name="name"]').val();
            var quantity = $('[name="quantity"]').val();
            var price = $('[name="price"]').val();
            var gst = $('[name="gst"]').val();
            var discount = $('[name="discount"]').val();
            
            var total = ((parseFloat(price)+parseFloat(gst))*parseFloat(quantity)) - parseFloat(discount);
            
            var rowCount = $('.detail tr').length+1;


            var markup = "<tr name='tr_"+rowCount+"'><td><input type='text' name='id_"+rowCount+"' style='display: none'>" + id + "</td>\n\
<td><input type='text' name='name_"+rowCount+"' style='display: none'>" + name + "</td>\n\
<td><input type='number' name='price_"+rowCount+"' style='display: none'>" + price + "</td>\n\
<td><input type='number' min='0' name='gst_"+rowCount+"' style='display: none'>" + gst + "</td>\n\
<td><input type='number' min='0' name='quantity_"+rowCount+"' style='display: none'>" + quantity + "</td>\n\
<td><input type='number' min='0' name='discount_"+rowCount+"' style='display: none'>" + discount + "</td>\n\
<td><input type='number' min='0' name='total_"+rowCount+"' style='display: none'>" + total + "</td>\n\
<td style='text-align:center;'><button type='button' style='margin:5px' class='btn btn-danger' onclick='delete_row("+rowCount+")' class='delete-row'>Delete</button></tr>";
            $("#myTable tbody").append(markup);
             return total();
            $('[name="id"]').val('');
            $('[name="name"]').val('');
            $('[name="quantity"]').val('');
            $('[name="price"]').val('');
            $('[name="gst"]').val('');
            $('[name="discount"]').val('');
            
        });
        
        // Find and remove selected table rows
        $('.delete-row').click(function(){
            $(this).parent().parent().remove();
            total();    
        });
    });    
    
function total()
{  
    var t=0;  
    var rowCount = $('.detail tr').length;
    for (var i = 0, max = rowCount; i < max; i++) {
       var amount = document.getElementsByName('total_'+i)[0].value;
       t = t + parseFloat(amount);        
    }
    document.getElementById('total_amount').innerHTML = t;
}      

function delete_row(no){
        document.getElementsByName('tr_'+no)[0].innerHTML = "";
}


    