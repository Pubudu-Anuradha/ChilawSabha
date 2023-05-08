<div class="content">
  <div class="head-area">
    <div class="sub-head-area">
      <h1>FAVORITE BOOKS</h1>
    </div>
    <hr>
    <div class="head-actions-area">
      <?php
        $categories_assoc = []; 
        foreach ($data['categories']['result'] ?? [] as $category){
          if($category['category_code'] !== 'All'){
            $categories_assoc[$category['category_id']] = $category['category_code'] . " - " . $category['category_name'];
          }
        }

        $sub_categories_assoc = [];
        foreach ($data['sub_categories']['result'] ?? [] as $sub_category){
          if($sub_category['sub_category_code'] !== 'All'){
            $sub_categories_assoc[$sub_category['sub_category_id']] = $sub_category['sub_category_code'] . " - " . $sub_category['sub_category_name'];
          }
        }

        Pagination::top('/LibraryMember/favourite', 'member_category_filter', select_filters:[
          'category' => [
            'Filter by category',
            array_merge(['0' => 'All'], $categories_assoc)
          ],
          'sub_category' => [
            'Filter by sub category',
            array_merge(['0' => 'All'], $sub_categories_assoc)
          ],
        ]);
        $table = $data['books'];
      ?>
    </div>
  </div>
  <div class='content-table'>
    <table>
      <thead>
        <tr>
          <th>Accession No</th>
          <th>Title</th>
          <th>Author</th>
          <th>Publisher</th>
          <th style="text-align:center">Status</th>
          <th style="text-align:center">Action</th>
        </tr>
      </thead>

      <tbody>
        <?php 
          if (!$table['nodata'] && !$table['error']):
            foreach ($table['result'] as $favbooks):
        ?>
              <tr>
                <td>
                  <?=$favbooks['accession_no']?>
                </td>
                <td>
                  <?=$favbooks['title']?>
                </td>
                <td>
                  <?=$favbooks['author']?>
                </td>
                <td>
                  <?=$favbooks['publisher']?>
                </td>
                <td style="text-align:center">
                  <?php
                    echo '<p class="status-'.$favbooks['status'].'">'.$favbooks['status'].'</p>';
                  ?>
                </td>
                <td>
                  <div class='btn-column'>
                    <a href="<?=URLROOT . '/LibraryMember/favourites/remove/' . $favbooks['accession_no']?>" class="btn bg-blue remove"><span>Remove</span></a>
                    <?php 
                      if(in_array($favbooks['accession_no'],array_column($data['ptr']['result'],'accession_no'))):
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/favourites/nplanToRead/' . $favbooks['accession_no']?>" class="btn bg-blue nptr"><span>Remove Plan to Read</span></a>
                    <?php
                      else:
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/favourites/planToRead/' . $favbooks['accession_no']?>" class="btn bg-blue ptr"><span>Plan to Read</span></a>
                    <?php
                      endif;
                      if(in_array($favbooks['accession_no'],array_column($data['comp']['result'],'accession_no'))):
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/favourites/incomplete/' . $favbooks['accession_no']?>" class="btn bg-blue incomplete"><span>Remove Completed</span></a>
                    <?php
                      else:
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/favourites/completed/' . $favbooks['accession_no']?>" class="btn bg-blue complete"><span>Completed</span></a>
                    <?php
                      endif;
                    ?>
                  </div>
                </td>
              </tr>
              <?php 
          endforeach;else: 
        ?>
              <tr>
                <td colspan="6" style="text-align:center">
                  No Favorite Books Available
                </td>
              </tr>
        <?php 
          endif;
        ?>      
      </tbody>
    </table>
  </div>
  <?php
    // Table::Table(['accession_no' => 'Accession No', 'title' => 'Title', 'author' => 'Author', 'publisher' => 'Publisher'], $data['books']['result'] ?? [], 'book-catalogue-id', actions:[
    //   'Remove' => [[URLROOT . '/LibraryMember/favourites/remove/%s','accession_no'], 'bg-blue fav', ['#']],
    //   'Plan to Read' => [[URLROOT . '/LibraryMember/favourites/planToRead/%s','accession_no'], 'bg-blue ptr', ['#']],
    //   'Completed' => [[URLROOT . '/LibraryMember/favourites/completed/%s','accession_no'], 'bg-blue complete', ['#']],
    // ], empty:!(count($data['books']['result']) > 0), empty_msg:'No books available');
  ?>
  
  <?php Pagination::bottom('filter-form', $data['books']['page'],$data['books']['count']);  ?>
</div>
