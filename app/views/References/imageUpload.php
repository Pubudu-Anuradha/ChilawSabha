<?php define('PREVIEW_WIDTH','300px');?>
<form action="<?=URLROOT . '/References/imageUpload'?>" method="post" enctype="multipart/form-data">
    <input type="file" name="img[]" id="img-up" accept="image/*" multiple>
    <input type="submit" name="Upload" value="Upload">
</form>
<?php 
if(isset($data['uploads'])){
    echo '<div class="previews">';
    foreach ($data['uploads'] as $image) {
        if(!$image['error']):?>
            <div class="container upload">
                    <img class="preview upload" width="<?= PREVIEW_WIDTH ?>" src="<?=URLROOT . '/' . $image['path']?>" alt="img-preview" >
            </div>
        <?php endif;
    }
    echo '</div>';
    echo "<hr />";
} ?>
<div class="previews" >
<?php for($i=0;$i<20;++$i):?>
    <div class="container"><img class="preview" width="<?= PREVIEW_WIDTH ?>" alt="img-preview" > <span class="close"></span></div>
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
    :root{
        --preview-size:<?= PREVIEW_WIDTH ?>;
    }
    .previews{
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap:3rem;
        align-items:flex-start;
    }
    .container{
        position: relative;
        width: var(--preview-size);
        transition: 200ms ease-in-out;
    }
    .container .preview{
        align-self: flex-start;
        max-height: var(--preview-size);
        overflow-y: scroll;
        border-radius: 10px;
        border: 1px solid black;
    }
    .container:hover{
        transform: scale(1.1);
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
        transition: 200ms ease-in-out;
        z-index: 10;
    }
    .container span::before,.container span::after{
        position: absolute;
        height: 1.5rem;
        content:" ";
        border-left: 3px solid black;
    }
    .container span::before{
        transform: rotate(45deg);
    }
    .container span::after{
        transform: rotate(-45deg);
    }
    .container span:hover{
        transform: scale(1.2);
    }
</style>