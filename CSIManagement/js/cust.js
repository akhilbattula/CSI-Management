/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $('#search_staff').on('click', function(){
            $('#staff_popup').toggle();
            $('[name="btnselect"]').click(function(){
                var value = $(this).closest('tr').children('td:first').text();
                $('#staff_id').val(value);
                $('#staff_popup').hide();
            });
        });
});
