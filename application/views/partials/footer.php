</div><!-- /.container -->  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo site_url("/"); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo site_url("/"); ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo site_url("/"); ?>assets/js/bootstrap-datepicker.js"></script>  
    <script src="<?php echo site_url("/"); ?>assets/js/toastr.js"></script>  
    <script> 
      $(document).ready(function(){  

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $(".well input[type='checkbox']").on('change', function(){
            // this_value = $(this).val();
            this_id = $(this).prop('id');
            toastr.info( "Checked with ID: "+this_id );
            this_value = $(this).prop("checked");
            toastr.info( "Is Checked: "+this_value );
            if($(this).prop("checked")){
              this_value = 1;
            }
            if(!$(this).prop("checked")){
              this_value = 0; 
            }
            console.log(this_value+" : "+this_id); 

            $.ajax({
                 type: "POST",
                 url: "<?php echo site_url('/ajax/'); ?>", 
                 data: {id: this_id, value: this_value  },
                 dataType: "json",
                 error: 
                  function(req, err){ 
                    console.log(err); 
                 },
                 success: 
                  function(data){
                    console.info(data.id+" : "+data.value); 
                    if(data){
                      toastr.info( "AJAX request returned this data: "+JSON.stringify(data) );
                      var target=$("#"+data.id);
                      if(target.hasClass('done')){
                        target.removeClass("done"); 
                      }
                      else if(!target.hasClass('done')){
                        target.addClass("done"); 
                      }  
                    }
                  }
            });// you have missed this bracket
            // return false;

        });

        $(".table a.close-button").on('click', function(){

            this_date = $(this).attr("data-date");
            this_event_wrapper = $(this).closest("p.alert");

            $.ajax({
                 type: "POST",
                 url: "<?php echo site_url('calendar/remove/'); ?>",  
                 // url: "/calendar/remove/", 
                 data: {id: this_date  },
                 dataType: "text",  
                 cache:false,
                 beforeSend : function (){
                   this_event_wrapper.addClass('disabled').append('<span class="glyphicon glyphicon-asterisk"></span>');  
                 },
                 error: 
                  function(req, err){ 
                    console.log(err); 
                  },
                 success: 
                  function(data){
                    // alert(data);
                    if(data=='true'){
                        this_event_wrapper.fadeOut('fast', function(){
                          $(this).remove();
                        });
                    } 
                  }
            });// you have missed this bracket
            // // return false;
            return false;
        });
        
        $(".images-well a.remove-image-link").on('click', function(){
            
            // Make delete image 
            this_event_wrapper = $(this).closest(".image-holder");
            this_id = $(this).attr("data-id");
            
            // Make ajax request
            $.ajax({
                 type: "POST",
                 url: "<?php echo site_url('upload/delete_image/'); ?>",  
                 data: {id: this_id  },
                 dataType: "text",  
                 cache:false,
                 beforeSend : function (){
                   // this_event_wrapper.addClass('disabled').append('<span class="glyphicon glyphicon-asterisk"></span>');  
                 },
                 error: 
                  function(req, err){ 
                    console.log(err); 
                  },
                 success: 
                  function(data){ 
                    this_event_wrapper.fadeOut('fast', function(){
                      $(this).remove();
                    }); 
                  }
            });// you have missed this bracket
            // // return false;
            // return false;
            return false;
        });
        
        $('input.submit-on-change').change(function() { 
          // select the form and submit 
            $(this).closest('form').find('input[type="submit"]').click();
        });         


        // $('form input:first').focus();  
 
 

        // window.setTimeout(function() { $(".alert-info, .alert-success").fadeOut('fast'); }, 3000);         


      });
    </script> 
  </body>
</html>

