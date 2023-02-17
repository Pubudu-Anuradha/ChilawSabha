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
            <input class="search" type="search" name="<?= $search_name ?>" id="<? $search_name ?>" value="<?= isset($_GET[$search_name]) ? $_GET[$search_name]:''?>">
            <span onclick="<?= $sender ?>()"></span>
        </div>
        <?php foreach($select_filters as $name => $details):?>
        <div class="filter">
            <label for="<?$name?>">
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
        </div>
        <?php endforeach;
        ?>
</div>
<?php }
}