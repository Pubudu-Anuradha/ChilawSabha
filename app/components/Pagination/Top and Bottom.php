<?php class Pagination{
  public static function top(
    $page, // Relative address of the page this is being called on
    $form_id='filter-form', // Id for the form.(incase there are more than one)
    $search_name='search', // name for the searchbar input
    // Dropdown selection filters. Use the following format exactly
    // id and name are equal for convenience
    $select_filters = ['name_and_id'=>[
      'Title for filter', [
        'value_1' => 'Displayed Name 1',
        'value_2' => 'Displayed Name 2',
        'value_3' => 'Displayed Name 3',
        'value_4' => 'Displayed Name 4',
        'value_5' => 'Displayed Name 5',
      ]
    ]]
  ){
    $replace = [' ','-'];
    $sender = str_replace($replace,'_',$form_id) . '_send';
    ?>

<script>
    const <?= $sender ?> = ()=>{
        document.getElementById('<?=$form_id?>').submit();
    }
</script>
<div class="filters">
    <form action="<?=URLROOT . $page ?>" method="get" id="<?=$form_id?>">
        <div class="filter">
            <label for="search">
                Search
            </label>
            <div class="searchbox">
              <input class="search" type="search"
                      name="<?= $search_name ?>" id="<? $search_name ?>"
                      value="<?= isset($_GET[$search_name]) ? $_GET[$search_name]:''?>"
                      placeholder="Type here to search...">
              <span onclick="<?= $sender ?>()"></span>
            </div>
        </div>
        <?php foreach($select_filters as $name => $details):?>
        <div class="filter">
            <label for="<?= $name ?>">
                <?= $details[0] ?>
            </label>
            <select onchange="<?= $sender ?>()" name="<?= $name ?>" id="<?= $name ?>">
                <?php foreach($details[1] as $val=>$d_val):?>
                    <option value="<?= $val ?>"
                        <?php if(isset($_GET[$name]) && $_GET[$name]==$val) {echo 'selected';} ?>
                    >
                        <?=$d_val?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endforeach;
        ?>
</div>
<?php }

  public static function bottom(
    $form_id,
    $page_data,
    $count,
    $page_no_name = 'page',
    $page_size_name = 'size',
    $page_sizes=[10,25,50,100]
  ){
      $replace = [' ','-'];
      $sender = str_replace($replace,'_',$form_id) . '_send';
      $size = $page_data[1];
      $page_count = ceil($count / $size);
      $current = $page_data[0] / $size;
  ?>
  <div class="page-nav">
      <?php if($page_count > 1):?>
      <div class="page-nos">
        <?php if($current!=0):?>
          <button id="<?=$page_no_name?>-first">First</button>
          <button id="<?=$page_no_name?>-prev">Previous</button>
          <?php endif; ?>
            <select name="<?=$page_no_name?>"
                    onchange="<?=$sender?>()"
                    id="<?= $page_no_name ?>-select">
            <?php for ($i = 0; $i * $size < $count; $i++) : ?>
                <option value="<?= $i ?>" <?= $i==$current?'selected' : ''?>>
                    <?= $i + 1 ?>
                </option>
            <?php endfor; ?>
          </select>
          <?php if($current<$page_count-1):?>
          <button id="<?=$page_no_name?>-next">Next</button>
          <button id="<?=$page_no_name?>-last">Last</button>
          <?php endif; ?>
          <script>
            <?php if($current!=0): ?>
            document.getElementById('<?=$page_no_name?>-first').addEventListener('click',(e)=>{
              const page_select = document.getElementById('<?= $page_no_name ?>-select');
              const page_select_len = page_select.childElementCount;
              const options = page_select.querySelectorAll('option');
              e.preventDefault();
              options[0].selected = true;
              for(let i=1;i<page_select_len;++i){
                options[i].selected = false;
              }
              <?= $sender ?>();
            })
            document.getElementById('<?=$page_no_name?>-prev').addEventListener('click',(e)=>{
              const page_select = document.getElementById('<?= $page_no_name ?>-select');
              const page_select_len = page_select.childElementCount;
              const options = page_select.querySelectorAll('option');
              e.preventDefault();
              for(let i=1;i<page_select_len;++i){
                if(options[i].selected){
                  options[i].selected = false;
                  options[i-1].selected = true;
                  break;
                }
              }
              <?= $sender ?>();
            })
            <?php endif; ?>
            <?php if($current<$page_count-1):?>
            document.getElementById('<?=$page_no_name?>-next').addEventListener('click',(e)=>{
              const page_select = document.getElementById('<?= $page_no_name ?>-select');
              const page_select_len = page_select.childElementCount;
              const options = page_select.querySelectorAll('option');
              e.preventDefault();
              for(let i=0;i<page_select_len-1;++i){
                if(options[i].selected){
                  options[i].selected = false;
                  options[i+1].selected = true;
                  break;
                }
              }
              <?= $sender ?>();
            })
            document.getElementById('<?=$page_no_name?>-last').addEventListener('click',(e)=>{
              const page_select = document.getElementById('<?= $page_no_name ?>-select');
              const page_select_len = page_select.childElementCount;
              const options = page_select.querySelectorAll('option');
              e.preventDefault();
              for(let i=0;i<page_select_len-1;++i){
                options[i].selected = false;
              }
              options[page_select_len-1].selected = true;
              <?= $sender ?>();
            })
            <?php endif; ?>
          </script>
      </div>
      <?php endif;?>
      <div class="page-size">
          <label for="<?= $page_size_name ?>-id">
              No.of Posts per page
          </label>
          <select name="<?= $page_size_name ?>"
                  onchange="<?= $sender ?>()"
                  id="<?= $page_size_name?>-id">
              <?php
              foreach ($page_sizes as $page_size) : ?>
                  <option value="<?= $page_size ?>" <?= $page_size == $size?'selected':''?>><?= $page_size ?></option>
              <?php endforeach; ?>
          </select>
      </div>
  </div>
  </form>
  <?php 
  }
}