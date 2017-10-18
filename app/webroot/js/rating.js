(function ($) {
    $(document).ready(function(){
        $('.rating').each(function(){
            var $this = $(this);
            var $listeners = $this.find('.listener');
            var $mids = $this.find('.mid');
            var $input = $this.find('input');
            var $label = $this.find('.label');
            var is_editable = $this.hasClass('editable');
            if(is_editable) {
                $listeners.click(function(){
                    var listenervalue = $(this).data('value');
                    $mids.each(function(){
                        var midvalue = $(this).data('value');
                        if(midvalue <= listenervalue) {
                            $(this).addClass('selected');
                        } else {
                            $(this).removeClass('selected');
                        }
                    });
                    var val = $(this).data('value');
                    $input.val(val);
                    $input.change();
                });
                $listeners.mouseleave(function(){
                    $mids.removeClass('hover');
                });
            }
            $listeners.mouseenter(function(){
                var listenervalue = $(this).data('value');
                $mids.each(function(){
                    var $this = $(this);
                    var midvalue = $this.data('value');
                    if(midvalue <= listenervalue /*&& !$this.hasClass('selected')*/) {
                        $(this).addClass('hover');
                    }
                });
            });
            $input.change(function(){
                $label.html($input.val());
            });
            $input.change();
            if(!is_editable) {
                $listeners.unbind('mouseenter');
                $input.unbind('change');
            }
        });
    });
}(jQuery));