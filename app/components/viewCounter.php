<?php
class ViewCounter
{
    public static function count($page_name)
    { if(!(($_SESSION['role']??'Guest')=='Admin')):?>
<script>
    let page = '<?= $page_name ?>';
    setTimeout(()=>fetch('<?=URLROOT . '/Posts/ViewedPage/' ?>',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({page: page})
    })
            .then(res=>res.json())
            .then()
            .catch(console.log),2000);
</script>
<?php endif;
    }
}