
(function($) { 
    $('.item-quantity').on('change' , function(){
     
        $.ajax({
            url: "/Cart/"+$(this).data('id'),
            method:'put' ,
            data: {
              quantity: $(this).val() ,
             _token: $('#token').val()
            }
          });
    
    })
})(jQuery);
