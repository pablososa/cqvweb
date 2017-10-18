(function($){
    $(document).ready(function(){
        $.fn.politeDatepicker = function() {
            $(this).each(function(){
                var $input = $(this);
                $input.hide();
                var new_input = $('<input type="text" />').addClass($input.attr('class')).attr('name','');
                var rude_arr = $input.val().split('-');
                if(rude_arr.length == 3){
                    new_input.val(rude_arr[2] + '/' + rude_arr[1] + '/' + rude_arr[0]);
                }
                $(new_input).datepicker({
                    yearRange:'c-70:c+10',
                    changeYear: true,
                    changeMonth: true,
                    dayNamesMin:['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNamesShort:['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    nextText:'Prox',
                    dateFormat: 'dd/mm/yy'
                });
                $(new_input).change(function(){
                    var polite_arr = $(this).val().split('/');
                    if(polite_arr.length == 3){
                        $input.val(polite_arr[2]+'-'+polite_arr[1]+'-'+polite_arr[0]);
                    }else{
                        $input.val('');
                    }
                    $input.change();
                });
                $input.before(new_input);
            });
            return this;
        };
        $('input.datepicker').politeDatepicker();
        $('.date_setter').click(function(){
            var arr=$(this).attr('rel').split('-');
            $(this).closest('div.date_setters').find('input.datepicker.principal').prev().val(arr[0]).change();
            $(this).closest('div.date_setters').find('input.datepicker.extra').prev().val(arr[1]).change();
            return false;
        });
    });
})(jQuery);
