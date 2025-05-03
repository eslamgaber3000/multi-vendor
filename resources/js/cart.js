
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
(function($) { 
    $('.remove-item').on('click' , function(){
      let id=$(this).data('id');
        $.ajax({
            url: "/Cart/"+id,
            method:'delete' ,
            data: {
             _token: $('#token').val()
            } , success : function (){

              $('#'+id).remove();     
              
            }
          })
    
    })
})(jQuery);


(function($) { 
  $('.add-item').on('click' , function(){
    
   let product_id=$('#product_id').val();
   let product_quantity=$('#product_quantity').val();
    console.log($('#token').val())
    $.ajax({
      url: "/Cart",
      method:'post' ,
      data: {
       _token: $('#token').val() ,
       product_id :product_id ,
       quantity :product_quantity
      } , success : function (){

      window.alert('Item add!') 
        
      }
    })
   

  })
})(jQuery);

