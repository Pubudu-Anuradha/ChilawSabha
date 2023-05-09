<?php $model = $data['model']; ?>
<?php require_once 'app/models/AdminStatModel.php'; ?>
<?php $model = new AdminStatModel(); ?>
<div class="content">
  <h1>Welcome to the Admin Dashboard</h1>
  <hr>
  <div class="blocks">
    <form method="get" class="time-frame">
    <div class="block">
      <div class="sub-block shadow" style="width: 100%;">
        <h4>Most Viewed Pages(Non Posts)</h4>
          <div class="filters">
            <label for="page_limit">Top</label>
            <?php
            $selected_limit = $_GET['page_limit'] ?? 10;
            ?>
            <input
              type="number"
              style="width: 3rem;"
              name="page_limit"
              id="page_limit"
              value="<?= $selected_limit ?>"
            >
          <label for="page_date_st">From</label>
          <input type="date" name="page_date_st"
                      id="page_date_st" value="<?= $_GET['page_date_st'] ?? date('Y-m-d') ?>"
                      max="<?=date('Y-m-d') ?>">
          <label for="page_date_ed">To</label>
          <input type="date" name="page_date_ed" 
                      id="page_date_ed" value="<?= $_GET['page_date_ed'] ?? date('Y-m-d') ?>"
                      max="<?=date('Y-m-d') ?>">
          </div>
        <?php 
        $selected_start_date = $_GET['page_date_st'] ?? date('Y-m-d');
        $selected_end_date   = $_GET['page_date_ed'] ?? date('Y-m-d');
         ?>
        <?php $page_views = $model->getPageViews($selected_start_date,
                                    $selected_end_date,$selected_limit); ?>
        <div class="table">
          <table>
            <tr>
              <th>rank</th>
              <th>Page</th>
              <th>Views</th>
            </tr>
            <?php
            $view_table_empty = empty($page_views['result'] ?? []);
            if(!$view_table_empty):
            foreach($page_views['result'] ?? [] as [
              'rank' => $rank,
              'name' => $name,
              'views' => $views
            ]): ?>
            <tr>
              <td><?= $rank ?></td>
              <td><?= $name ?></td>
              <td><?= $views ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="3" style="text-align: center;">No page views found in time frame</td>
            </tr>
            <?php endif; ?>
          </table>
        </div>
      </div>
      <div class="sub-block shadow" style="width: 100%;">
        <div class="row">
        <h4>Post Views Distribution</h4>
          <div class="filters">
          <label for="dist_date_st">From</label>
          <input type="date" name="dist_date_st"
                      id="dist_date_st" value="<?= $_GET['dist_date_st'] ?? date('Y-m-d') ?>"
                      max="<?=date('Y-m-d') ?>">
          <label for="dist_date_ed">To</label>
          <input type="date" name="dist_date_ed" 
                      id="dist_date_ed" value="<?= $_GET['dist_date_ed'] ?? date('Y-m-d') ?>"
                      max="<?=date('Y-m-d') ?>">
          </div>
        </div>
        <?php 
        $selected_start_date = $_GET['dist_date_st'] ?? date('Y-m-d');
        $selected_end_date   = $_GET['dist_date_ed'] ?? date('Y-m-d');
        $views_per_type = $model->getTotalViewsPerType($selected_start_date,$selected_end_date);
        $no_views = empty($views_per_type['result'] ?? []);
        if(!$no_views): ?>
        <canvas id="pie"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const data = {
    labels: [<?= implode(',',array_map(function($a){
      return "'".$a['post_type']."'";
    },$views_per_type['result']??[])); ?>],
    datasets: [{
      label: 'Views',
      data: [<?= implode(',',array_map(function($a){
      return $a['views'];
    },$views_per_type['result']??[])); ?>],
      hoverOffset: 4
    }]
  };

  const config = {
    type: 'pie',
    data: data,
    options: {
      plugins: {
        datalabels: {
          formatter: (value) => value
        }
      }
    }
  };

  const myChart = new Chart(
    document.getElementById('pie'),
    config
  );
</script>
      <?php else: ?>
      <p>No views found in time frame</p>
      <?php endif; ?>
      </div>
      <?php $post_counts = $model->getPostCounts()['result'] ?? [];
      foreach($post_counts as [
        'post_type_id' => $post_type_id,
        'post_type' => $post_type,
        'post_count' => $post_count
      ]): ?>
      <div class="sub-block shadow">
        <h3><?= $post_type ?></h3>
        <p>Number of <?= $post_type ?>: <?= $post_count ?></p>
        <a href="<?= URLROOT . '/Admin/' . $post_type ?>" class="btn bg-blue">Manage <?= $post_type ?></a>
        <h4>Most Viewed <?= $post_type ?></h4>
          <div class="filters">
            <label for="<?= $post_type ?>_limit">Top</label>
            <?php
            $selected_limit = $_GET[$post_type . '_limit'] ?? 10;
            ?>
            <input
              type="number"
              style="width: 3rem;"
              name="<?= $post_type ?>_limit"
              id="<?= $post_type ?>_limit"
              value="<?= $selected_limit ?>"
            >
          <label for="<?= $post_type ?>_date_st">From</label>
          <input type="date" name="<?= $post_type ?>_date_st"
                      id="<?= $post_type ?>_date_st" value="<?= $_GET[$post_type.'_date_st'] ?? date('Y-m-d') ?>"
                      max="<?=date('Y-m-d') ?>">
          <label for="page_date_ed">To</label>
          <input type="date" name="<?= $post_type ?>_date_ed"
                      id="<?= $post_type ?>_date_ed" value="<?= $_GET[$post_type.'_date_ed'] ?? date('Y-m-d') ?>"
                      max="<?=date('Y-m-d') ?>">
          </div>
        </script>
        <div class="table">
        <?php
        $selected_start_date = $_GET[$post_type.'_date_st'] ?? date('Y-m-d');
        $selected_end_date   = $_GET[$post_type.'_date_ed'] ?? date('Y-m-d');
        $selected_limit      = $_GET[$post_type.'_limit'] ?? 10;
        $top10 = $model->getTop10(
          $post_type_id,$selected_start_date,$selected_end_date,$selected_limit
        );
        $top10 = array_filter($top10['result']??[],fn($row) => $row['post_id'] != null);
        if(count($top10) > 0):?>
        <table>
          <tr>
            <th>rank</th>
            <th>Title</th>
            <th>Views</th>
          </tr>
        <?php
        foreach($top10 as [
            'rank' => $rank,
            'post_id' => $post_id,
            'title' => $title,
            'views' => $views
          ]): ?>
          <tr>
            <td><?= $rank ?></td>
            <td><?= $title ?></td>
            <td><?= $views ?></td>
          </tr>
        <?php endforeach; ?>
        </table>
        <?php else: ?>
          <p>No posts viewed in this time frame</p>
        <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
  <script>
  const starts_and_ends = [
    'page',
    'dist',
    'Announcements',
    'Events',
    'Projects',
    'Services',
  ];

  starts_and_ends.forEach((post_type) => {
    const start_date_input = document.getElementById(`${post_type}_date_st`);
    const end_date_input = document.getElementById(`${post_type}_date_ed`);
    end_date_input.min = start_date_input.value;
    start_date_input.addEventListener('change', (e) => {
      end_date_input.min = start_date_input.value;
      if (start_date_input.value > end_date_input.value) {
        end_date_input.value = start_date_input.value;
      }
    });
  });

  const form = document.querySelector('form.time-frame');
  document.querySelectorAll('input').forEach(input => {
    input.addEventListener('change', (e) => {
      form.submit();
    });
  });
  </script>
    </div>
    </form>
  </div>
</div>

<script>
</script>