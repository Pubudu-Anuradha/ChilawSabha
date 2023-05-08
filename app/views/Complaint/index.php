<p>Number of working complaints: <?php echo implode( $data['complaintCount'][0] ?? []); ?></p>
<!-- <?php 
var_dump($data['complaintCount']['result']);
if (isset($data['complaintCount'])) {
    echo $data['complaintCount']['result']['working_count'] ?? '0';
} else {
    echo '0';
}?> -->

<div class="content">
  <div class="complaint-dashboard">
    <h2 class="analytics-topic">Dashboard</h2>
    <div class="upper-content complaint-upper">
      <div class="complaint-count">
        <div class="new-complaint-count">
          <h1> New Complaints </h1>
          <span>08</span>
        </div>
        <div class="resolved-complaint-count">
          <h1> My Resolved Complaints </h1>
          <span>15</span>
        </div>
        <div class="working-complaint-count">
          <h1> My Working Complaints </h1>
          <span>05</span>

        </div>
      </div>
      <!-- <div class="pie-outer-content">
        <h3>Most Complaint Categories</h3>
        <div class="most-complaint-category">
          <canvas id="most-complaint-categories"></canvas>
        </div>
      </div>-->

    </div>
    <!-- <div class="lower-content complaint-lower">
      <h3>Complaints In Each Month</h3>
      <canvas id="complaint-in-month"></canvas>
    </div> -->
  </div>
</div>

