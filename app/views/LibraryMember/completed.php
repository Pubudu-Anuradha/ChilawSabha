<div class="content">
  <div class="head-area">
    <div class="sub-head-area">
      <h1>COMPLETED BOOKS</h1>
    </div>
    <hr>
    <div class="head-actions-area">
      <?php
        $categories = $data['categories']['result'] ?? [];
        $subcategories = $data['sub_categories']['result'] ?? [];
        $category_arr = ['All' => "All"];
        foreach ($categories as $category){
            $category_arr[$category['category_id']] = $category['category_name'];
        }
        $sub_category_arr = ['All' => "All"];
        foreach ($subcategories as $subcategory){
            $sub_category_arr[$subcategory['sub_category_id']] = $subcategory['sub_category_name'];
        }

        Pagination::top('/LibraryMember/completeds', 'member_complete_filter', select_filters:[
          'category_name' =>[
            'Choose by Category' ,$category_arr
        ],
        'sub_category_name' =>[
            'Choose by Sub Category' ,$sub_category_arr
        ]
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
            foreach ($table['result'] as $compbooks):
        ?>
              <tr>
                <td>
                  <?=$compbooks['accession_no']?>
                </td>
                <td>
                  <?=$compbooks['title']?>
                </td>
                <td>
                  <?=$compbooks['author']?>
                </td>
                <td>
                  <?=$compbooks['publisher']?>
                </td>
                <td style="text-align:center">
                  <?php
                    echo '<p class="status-'.$compbooks['status'].'">'.$compbooks['status'].'</p>';
                  ?>
                </td>
                <td>
                  <div class='btn-column'>
                    <a href="<?=URLROOT . '/LibraryMember/completeds/remove/' . $compbooks['accession_no']?>" class='btn bg-blue remove'><span>Remove</span></a>
                  </div>
                </td>
              </tr>
        <?php
            endforeach;else:
        ?>
            <tr>
              <td colspan="6" style="text-align:center">
                No Completed Books Available
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
    //   'Remove' => [[URLROOT . '/LibraryMember/completeds/remove/%s','accession_no'], 'bg-blue remove', ['#']],
    // ], empty:!(count($data['books']['result']) > 0), empty_msg:'No books available');
  ?>
  
  <?php Pagination::bottom('book-cat-pag', $data['books']['page'],$data['books']['count']);  ?>
</div>
