<?php
Table::Table(['id' => 'ID', 'name' => 'Name', 'address' => 'Address', 'age' => 'Age'], $data['tt']['result'], actions:[]);?>
<form id="add-form" action="<?= URLROOT . '/Exp/Api/add'?>">
  <input type="text" name="name" maxlength="100">
  <input type="text" name="address" maxlength="100">
  <input type="number" name="age" min="4" max="120">
  <input type="submit" value="add" id="add-table"/>
</form>

<script>
  fetch('<?=URLROOT . '/Exp/Api/test'?>',{
    method:"POST",
    headers:{
      "Content-type":"application/json"
    },
    body: JSON.stringify({
      test:"HELLO IS THIS ON"
    })
  }).then(Response=>Response.json()).then(Response=>{
    console.log(Response);
  }).catch(err => console.log(err));
  document.getElementById("add-form").addEventListener('submit',(event) => {
    event.preventDefault();
    let form = {}
    new FormData(event.target).forEach((val,key)=>{
      form[key] = val;
    });
    fetch("<?= URLROOT . '/Exp/Api/add' ?>",{
      method:"POST",
      headers:{
        "Content-type":"application/json"
      },
      body: JSON.stringify(form)
      }).then(result => result.json()).then(response =>{
        if(response.success == true){
          window.location.reload();
        }
      }).catch(e => console.log(e))
  })
</script>
