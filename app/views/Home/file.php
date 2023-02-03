<form action="<?=URLROOT . '/Home/file'?>" method="post" enctype="multipart/form-data">
    <input type="file" name="img[]" id="img-up" accept="image/*" multiple>
    <input type="submit" name="Upload" value="Upload">
</form>
<div class="previews" style="display: flex;gap:1rem;align-items:flex-start;">
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-1"> <span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-2"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-3"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-4"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-5"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-6"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-7"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-8"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-9"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-10"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-11"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-12"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-13"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-14"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-15"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-16"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-17"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-18"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-19"><span>&times;</span></div>
    <div class="container"><img class="preview" src="" width="150px" alt="" id="pre-20"><span>&times;</span></div>
</div>
<script>
    const file_input = document.getElementById("img-up");
    const preview_containers = document.querySelectorAll(".container");
    const preview_images = document.querySelectorAll(".preview");

    const clear_previews = () => preview_containers.forEach(element => {
        element.style.display = "none";
        element.src = "";
    });

    file_input.addEventListener('change', (e)=>{
        clear_previews();
        for(let i=0;i<e.target.files.length;++i){
            // console.log(URL.createObjectURL(e.target.files[0]));
            preview_containers[i].style.display = "block"
            preview_images[i].src = URL.createObjectURL(e.target.files[i]);
        }
    });
    clear_previews();
    // TODO: remove file when X clicked
</script>
<style>
    .container{
        position: relative;
        width: 150px;
    }
    .container span{
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        text-align: center;
        font-size: 2rem;
        font-weight: bolder;
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