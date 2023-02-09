<div class="head-area">
  <h1>Emergency Details</h1>
  <hr>
</div>

<div class="emergency-details">
  <?php
    if (isset($data['emergency_details'])) {
        while ($emergency_detail = $data['emergency_details']->fetch_assoc()) {
            echo '<h2>' . $emergency_detail['category_name'] . '</h2>';

            echo '<h3>' . $emergency_detail['place_name'] . '</h3>';
            echo '<p>Telephone: 0' . $emergency_detail['tel'] . '</p>';
            echo '<p>Address: ' . $emergency_detail['place_address'] . '</p>';
        }
    }
  ?>
</div>