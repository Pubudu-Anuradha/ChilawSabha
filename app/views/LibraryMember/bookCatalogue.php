<div class="content">
  <div class="head-area">
    <div class="sub-head-area">
      <h1>BOOK CATALOGUE</h1>
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

        Pagination::top('/LibraryMember/bookCatalog', 'member_catalogue_filter', select_filters:[
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
            foreach ($table['result'] as $books):
        ?>
              <tr>
                <td>
                  <?=$books['accession_no']?>
                </td>
                <td>
                  <?=$books['title']?>
                </td>
                <td>
                  <?=$books['author']?>
                </td>
                <td>
                  <?=$books['publisher']?>
                </td>
                <td style="text-align:center">
                  <?php
                    echo '<p class="status-'.$books['status'].'">'.$books['status'].'</p>';
                  ?>
                </td>
                <td>
                  <div class='btn-column'>
                    <?php 
                      if(in_array($books['accession_no'],array_column($data['fav']['result'],'accession_no'))):
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/bookCatalog/unfav/' . $books['accession_no']?>" class="btn bg-blue unfav"><span>Remove Favorite</span></a>
                    <?php
                      else:
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/bookCatalog/favourite/' . $books['accession_no']?>" class="btn bg-blue fav"><span>Favorite</span></a>
                    <?php 
                      endif;
                      if(in_array($books['accession_no'],array_column($data['ptr']['result'],'accession_no'))):
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/bookCatalog/nplanToRead/' . $books['accession_no']?>" class="btn bg-blue nptr"><span>Remove Plan to Read</span></a>
                    <?php
                      else:
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/bookCatalog/planToRead/' . $books['accession_no']?>" class="btn bg-blue ptr"><span>Plan to Read</span></a>
                    <?php
                      endif;
                      if(in_array($books['accession_no'],array_column($data['comp']['result'],'accession_no'))):
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/bookCatalog/incomplete/' . $books['accession_no']?>" class="btn bg-blue incomplete"><span>Remove Completed</span></a>
                    <?php
                      else:
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/bookCatalog/completed/' . $books['accession_no']?>" class="btn bg-blue complete"><span>Completed</span></a>
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
                  No books available
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
    //   'Favorite' => [[URLROOT . '/LibraryMember/bookCatalog/favourite/%s','accession_no'], 'bg-blue fav', ['#']],
    //   'Plan to Read' => [[URLROOT . '/LibraryMember/bookCatalog/planToRead/%s','accession_no'], 'bg-blue ptr', ['#']],
    //   'Completed' => [[URLROOT . '/LibraryMember/bookCatalog/completed/%s','accession_no'], 'bg-blue complete', ['#']],
    // ], empty:!(count($data['books']['result']) > 0), empty_msg:'No books available');
  ?>
  
  <?php Pagination::bottom('filter-form', $data['books']['page'],$data['books']['count']);  ?>
</div>
