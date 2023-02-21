<?php
Table::Table(['id' => 'ID', 'name' => 'Name', 'address' => 'Address', 'age' => 'Age'], $data['tt']['result'], actions:[]);?>

<button id="add-table">Add</button>

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
  document.getElementById("add-table").addEventListener('click',(e) => {

  })
</script>
