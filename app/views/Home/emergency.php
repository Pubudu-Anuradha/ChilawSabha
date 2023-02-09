<div class="head-area">
  <h1>Emergency Details</h1>
  <hr>
</div>

<div class="emergency-details">
  <?php
    $emergency_details = !$data['emergency_details']['error'] && !$data['emergency_details']['nodata'] ? $data['emergency_details']['result']:false;
    $prev_detail=null;
    if($emergency_details):
      foreach($emergency_details as $emergency_detail): 
        if($prev_detail==null or $emergency_detail['category_name']!=$prev_detail['category_name']):
          echo '<h2>' . $emergency_detail['category_name'] . '</h2>';
        endif;

        echo '<h3>' . $emergency_detail['place_name'] . '</h3>';
        echo '<p>Telephone: 0' . $emergency_detail['tel'] . '</p>';
        echo '<p>Address: ' . $emergency_detail['place_address'] . '</p>';
        $prev_detail = $emergency_detail;
      endforeach;
    endif;
  ?>
</div>