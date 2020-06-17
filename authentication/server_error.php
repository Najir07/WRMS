<div class="alert alert-danger m-5">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="alert-heading"><strong>Error Occured!!</strong></h4>
    <hr>
    <?php
    if (count($server_errors) > 0) {
       foreach ($server_errors as $key => $value) {
         echo "<p>".$value."</p><br>";
       }
     } 
     ?>
</div>