<form action="<?=URLROOT . '/Home/file'?>" method="post" enctype="multipart/form-data">
    <input type="file" name="img[]" id="img-up" accept="image/*" multiple>
    <input type="submit" name="Upload" value="Upload">
</form>
<?php 
if(isset($data['uploads'])){
    echo '<div class="previews">';
    foreach ($data['uploads'] as $image) {
        if(!$image['error']):?>
            <div class="container upload">
                    <img class="preview upload" width="150px" src="<?=URLROOT . '/' . $image['path']?>" alt="img-preview" >
            </div>
        <?php endif;
    }
    echo '</div>';
    echo "<hr />";
} ?>
<div class="previews" >
<?php for($i=0;$i<20;++$i):?>
    <div class="container"><img class="preview" width="150px" alt="img-preview" > <span class="close">&times;</span></div>
<?php endfor?>
</div>

<script>
    const file_input = document.getElementById("img-up");
    const preview_containers = document.querySelectorAll(".container:not(.upload)");
    const preview_images = document.querySelectorAll(".container > .preview:not(.upload)");

    const clear_previews = () => preview_containers.forEach(element => {
        element.style.display = "none";
        element.src = "";
    });

    const refresh_previews = (e) => preview_containers.forEach(element => {
        clear_previews();
        for(let i=0;i<e.target.files.length;++i){
            preview_containers[i].style.display = "block"
            preview_images[i].src = URL.createObjectURL(e.target.files[i]);
        }
    });

    const files_changed =  (e) =>{
        if(e.target.files.length > 20){
            clear_previews();
            alert("You cannot upload more than 20 images");
            file_input.files = new DataTransfer().files
        }else{
            refresh_previews(e);
            for(let i=0;i<e.target.files.length;++i){
                preview_containers[i].childNodes.forEach((child)=>{
                    if(child.className=="close") child.onclick = ()=>{
                        const dt = new DataTransfer();
                        for(let j=0;j<e.target.files.length;++j)
                            if(j!=i) dt.items.add(e.target.files[j]);
                        file_input.files = dt.files;
                        refresh_previews(e);
            }})}
        }
    }

    file_input.addEventListener('change',files_changed)
    clear_previews();
</script>
<style>
    .previews{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap:1rem;
        align-items:flex-start;
    }
    .container{
        position: relative;
        width: 150px;
    }
    .container .preview{
        align-self: flex-start;
        max-height: 150px;
        overflow-y: scroll;
        border-radius: 10px;
        border: 1px solid black;
    }
    .container span{
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        text-align: center;
        font-size: 2rem;
        font-weight: 1000;
        top: -.75rem;
        right:-.75rem;
        background-color: red;
        color: white;
        padding: 3px;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        border: 2px solid black;
        cursor: pointer;
    }
</style>