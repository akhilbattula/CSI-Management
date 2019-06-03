$(document).ready(function () {

    $("#customer_id").keydown(function(e){
            e.preventDefault();
    });
 
    $('#search_customer_needs').on('click', function(){
            $('#product_popup').hide();
            $('#customer_popup').toggle();
            $('[name="btnselect_customer"]').click(function(){
                var value = $(this).closest('tr').children('td:first').text();
                $('#customer_id').val(value);
                $('#customer_popup').hide();
            });
      });

    $('#search_product_needs').on('click', function(){
        $('#customer_popup').hide();
        $('#product_popup').toggle();
        $('[name="btnselect_product"]').click(function(){
            var value1 = $(this).closest('tr').children('td:first').text();
            var value2 = $(this).closest('tr').children('td:nth-child(2)').text();
            $('#product_id').val(value1);
            $('[name="product_name"]').val(value2);
            $('#product_popup').hide();
        });
    });
});