<div class="content">
    <?php foreach($data['links'] as $link):?>
        <a href="<?= URLROOT.'/References/'.$link?>"><?=$link?></a> <br />
    <?php endforeach; ?>
</div>