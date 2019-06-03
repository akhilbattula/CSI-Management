$(document).ready(function(){
        $('#input_readonly').show();        
        $('#input_text').hide();        
        $('#input_number').hide();        
        $('#input_date').hide();        

$('[name="go_button"]').click(function(){

        var values = $('[name="table_name"]').val();
        if(values!==""){
            $("#table tbody").children('tr').remove();
            $('#column_names').children('option').remove();
            $('[name="column_name"]').children('option:not(:first)').remove();
            $.get("./getDesc.php?q="+values, function(responseText) {
                var myArray = jQuery.parseJSON(responseText);
                $.each(myArray, function(i, value) {
                    $('[name="column_names[]"]').append($('<option>').text(capitalizeFirstLetter(value[0].split('_').join(' '))).attr('value', value[0]));
                });
                
                $.each(myArray, function(i, value) {
                    if(value[1].indexOf("timestamp") === -1){
                        $('[name="column_name"]').append($('<option>').text(capitalizeFirstLetter(value[0].split('_').join(' '))).attr('value', value[0]))
                        .append('<input class="form-control" type="text" value="'+value[1]+'" id="'+value[0]+'_datatype" name="'+value[0]+'_datatype" hidden>');
                    }
                });                
                $('#reports_div_2').show();
            });
        }else{
            alert("Please select any section");
        }
});

$("#add-row").click(function(){
        var column_name = $('[name="column_name"]').val();
        var operator = $('[name="operator"]').val();
        var operator_text = $("#operator option:selected").html();
        var value = $('[name="value"]:visible').val();

        var rowCount = $('.detail tr').length+1;

        var markup = "<tr id='tr_"+rowCount+"'><td><input type='text' value='"+column_name+"' name='name[]' style='display: none'>" + column_name + "</td>\n\
<td><input type='text' name='operator[]' value='"+operator+"' style='display: none'>" + operator_text + "</td>\n\
<td><input type='text' name='value[]' value='"+value+"' style='display: none'>" + value + "</td>\n\
<td style='text-align:center;'><button type='button' style='margin:5px' class='btn btn-danger' onclick='return delete_row("+rowCount+")' id='delete-row'>Delete</button></tr>";
        $(".detail").append(markup);

        $('[name="column_name"]').val('');
        $('[name="operator"]').val('');
        $('[name="value"]').val('');

    });
});    

function delete_row(that) {
    document.getElementById("tr_"+that).innerHTML = "";
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function inputtypecheck(that) {
    
    var type = $('[name="'+that.value+'_datatype'+'"]').val();
    if(type.toLowerCase().includes("int")||type.toLowerCase().includes("double")){
        $('#input_readonly').hide();        
        $('#input_text').hide();        
        $('#input_number').show();        
        $('#input_date').hide();        

    }else if(type.toLowerCase().includes("varchar")){
        $('#input_readonly').hide();        
        $('#input_text').show();        
        $('#input_number').hide();        
        $('#input_date').hide();        
        
    }else if(type.toLowerCase().includes("date")){
        $('#input_readonly').hide();        
        $('#input_text').hide();        
        $('#input_number').hide();        
        $('#input_date').show();        
        
    }else{
        $('#input_readonly').show();        
        $('#input_text').hide();        
        $('#input_number').hide();        
        $('#input_date').hide();                
    }
}
