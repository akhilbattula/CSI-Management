$(document).ready(function(){

    $('#billing_table').dataTable();
        $('#emi_row').hide();

    
    $('#proceed').on('click', function(){
        
        var rowCount = $('.detail tr').length;
        if(rowCount>0){
            $('form#billing_form').submit();
        }else{
            alert("Please Add any products");
        }
        
    });
    $('[name="search_product"]').on('click', function(){
        var values = $('[name="id"]').val();
        
        if(values!==""){        
            $.get("./getproduct.php?q="+values, function(responseText) {
                var myArray = jQuery.parseJSON(responseText);
                //alert(myArray.toString());
                $('[name="name"]').val(myArray["prod_name"]);
                $('[name="price"]').val(myArray["prod_price"]);
                $('[name="gst"]').val(myArray["gst"]);
                $('[name="model_no"]').val(myArray["model_no"]);
                $('[name="imei_nos"]').val(myArray["imei_nos"]);
            });
        }else{
            alert("Please enter Product ID");
        }
    });

    $('#search_customer').on('click', function(){

            $('#customer_popup').toggle();
            $('[name="btnselect_customer"]').click(function(){

      
                var value1 = $(this).closest('tr').children('td:nth-child(1)').text();
                var value2 = $(this).closest('tr').children('td:nth-child(2)').text();
                var value3 = $(this).closest('tr').children('td:nth-child(3)').text();
                var value4 = $(this).closest('tr').children('td:nth-child(4)').text();
                var value5 = $(this).closest('tr').children('td:nth-child(5)').text();
                var value6 = $(this).closest('tr').children('td:nth-child(6)').text();

                $('#cust_id').val(value1);
                $('#fullname').val(value2);
                $('#address').val(value3);
                $('#mobile_nos').val(value4);
                $('#aadharno').val(value5);
                $('#purchase_count').val(value6);

                $('#customer_popup').hide();

            });
      });

    $("#add-row").click(function(){
            var id = $('[name="id"]').val();
            var name = $('[name="name"]').val();
            var quantity = $('[name="quantity"]').val();
            var price = $('[name="price"]').val();
            var gst = $('[name="gst"]').val();
            var discount = $('[name="discount"]').val();
            var imei = $('[name="imei_nos"]').val();
            var model = $('[name="model_no"]').val();
            

        if(id==''||!id){
            alert("Please enter Product ID");
        }else if(name=='' || !name){
            alert("Please enter Product ID and search for product");    
        }else if(quantity==''||!quantity){
            alert("Please enter quantity");
        }else if(price==''||!price){
            alert("Please enter Product ID and search for product");
        }else if(gst==''||!gst){
            alert("Please enter Product ID and search for product");
        }else if(discount==''||!discount){
            alert("Please enter discount");
        }else if(price==''||!price){
            alert("Please enter Product ID and search for product");
        }else{        
            var rowCount = $('.detail tr').length+1;
            var total = ((parseFloat(price)+((parseFloat(price)/100)*parseFloat(gst)))*parseFloat(quantity)) - parseFloat(discount);

            var markup = "<tr id='tr_"+rowCount+"'><td><input value='"+id+"' type='text' name='id[]' style='display: none'>" + id + "</td>\n\
<td><input type='text' name='name[]' value='"+name+"' style='display: none'>" + name + "</td>\n\
<td><input type='number' name='price[]' value='"+price+"' style='display: none'>" + price + "</td>\n\
<td><input type='number' min='0' name='gst[]' value='"+gst+"' style='display: none'>" + gst + "</td>\n\
<td><input type='number' min='0' name='model[]' value='"+model+"' style='display: none'>" + model + "</td>\n\
<td><input type='number' min='0' name='imei[]' value='"+imei+"' style='display: none'>" + imei + "</td>\n\
<td><input type='number' min='0' name='quantity[]' value='"+quantity+"' style='display: none'>" + quantity + "</td>\n\
<td><input type='number' min='0' name='discount[]' value='"+discount+"' style='display: none'>" + discount + "</td>\n\
<td><input type='number' min='0' name='total[]' id='total"+rowCount+"'  value='"+total+"' id='total' style='display: none'>" + total + "</td>\n\
<td style='text-align:center;'><button type='button' style='margin:5px' class='btn btn-danger' onclick='return delete_row(this)' id='delete-row'>Delete</button></tr>";
            $("#myTable tbody").append(markup);
            $('[name="id"]').val('');
            $('[name="name"]').val('');
            $('[name="quantity"]').val('');
            $('[name="price"]').val('');
            $('[name="gst"]').val('');
            $('[name="model_no"]').val('');
            $('[name="imei_nos"]').val('');
            $('[name="discount"]').val('');
            total_amount();
        }
        });
        
});    

function printDiv() 
{

  var divToPrint=document.getElementById('container');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html>\n<head>\n <link rel=\"stylesheet\" type=\"text/css\"  href=\"../css/print.css\">\n</head><body onload="window.print()">\n'+divToPrint.innerHTML+'\n</body>\n</html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}

function delete_row(i) {

    var row = i.parentNode.parentNode;
    row.parentNode.removeChild(row);
    total_amount();
}

function yesnoCheck(that) {
    if (that.value === "EMI") {
        $('#emi_row').show();

        $('input[name="bill_no"]').val("");
        $('input[name="bill_no"]').prop('readonly',false);
    }else if (that.value === "Cash") {
        $('#emi_row').hide();
        var no = $('#invoice_no').val();
        $('input[name="bill_no"]').val(no);
        $('input[name="bill_no"]').prop('readonly',true);
    } else {
        $('#emi_row').hide();
        
        $('input[name="bill_no"]').val("");
        $('input[name="bill_no"]').prop('readonly',false);
    }
}

function total_amount()  {  
    
    var t=0;
    $('#total_amount').text(t);
    var rowCount = $('.detail tr').length;
    for(var i = 1; i<=rowCount;i++){
        var amount_val = $('#total'+i).val();        
        t = t + parseFloat(amount_val);
    }
    $('#total_amount').text(t);
    $('[name="total_amount_input"]').val(t);
    $('[name="no_of_products"]').val(rowCount);

}


