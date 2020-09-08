(function($){

    $(document).ready(function(){
      $(document).on('submit','[data-js-form=filter]', function(e){
        e.preventDefault();

        var data = $(this).serialize();
 console.log(data);
        $.ajax({
          url: wpAjax.ajaxUrl,
          data: data,
          type: 'post',
          success: function(result) {
            console.log(result);
            $('[data-js-filter=target]').html(result);
          },
          error: function(result) {
            console.warn(result);
          }
        });

      });
    });
}(jQuery));