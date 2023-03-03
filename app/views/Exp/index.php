<?php
Table::Table(['id' => 'ID', 'name' => 'Name', 'address' => 'Address', 'age' => 'Age'], $data['tt']['result'], actions:[
  '' => [
    [URLROOT . '/Exp/Api/update/%s','id'],'edit bg-blue'
  ]
]);?>
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
        consol.log(JSON.stringify(response));
        // if(response.success == true){
        //   window.location.reload();
        // }
      }).catch(e => console.log(e))
  })

  const rows = document.querySelectorAll('tr');
  rows.forEach((row) => {
    const btn = row.querySelector('a.btn');
    if(btn){
      btn.addEventListener('click',(e)=>{
        e.preventDefault();

        if(!btn.classList.contains('edit') && btn.classList.contains('enable')){
          let values = {};
          let changed = false;
          row.querySelectorAll('td > input').forEach(input=>{
            changed = changed || (input.value != input.getAttribute('oldValue'))
            values[input.name] = input.value;
          })
          if(changed){
            row.querySelectorAll('td > input').forEach(input=>input.disabled = true)
            btn.classList.remove('enable');
            btn.classList.add('waiting');
            fetch(btn.href,{
              method:"POST",
              headers:{
                "Content-type":"application/json"
              },
              body: JSON.stringify(values)
              }).then(result => result.json()).then(response =>{
                if(response.success){
                  console.log(response);
                  const cells = row.querySelectorAll('td');
                  cells[1].innerHTML = response.new.name;
                  cells[2].innerHTML = response.new.address;
                  cells[3].innerHTML = response.new.age;
                  btn.classList.remove('waiting')
                  btn.classList.add('edit')
                }else{
                  row.querySelectorAll('td > input').forEach(input=>input.disabled = false)
                }
              }).catch(e => console.log('ERROR',e))
          }
          console.log(JSON.stringify(values));

        } else  if(btn.classList.contains('edit')){
          btn.classList.remove('edit')
          btn.classList.add('enable')
          const cols = row.querySelectorAll('td');
          const name = cols[1];
          const nameEdit = document.createElement('input');
          nameEdit.setAttribute('type','text');
          nameEdit.setAttribute('name','name');
          nameEdit.setAttribute('value',name.textContent.trim())
          nameEdit.setAttribute('oldValue',name.textContent.trim())
          console.log(nameEdit);
          name.replaceChildren(nameEdit)

          const addr = cols[2];
          const addrEdit = document.createElement('input');
          addrEdit.setAttribute('type','text');
          addrEdit.setAttribute('name','address');
          addrEdit.setAttribute('value',addr.textContent.trim())
          addrEdit.setAttribute('oldValue',addr.textContent.trim())
          console.log(addrEdit);
          addr.replaceChildren(addrEdit)

          const age = cols[3];
          const ageEdit = document.createElement('input');
          ageEdit.setAttribute('type','number');
          ageEdit.setAttribute('name','age');
          ageEdit.setAttribute('min','12');
          ageEdit.setAttribute('value',age.textContent.trim())
          ageEdit.setAttribute('oldValue',age.textContent.trim())
          age.replaceChildren(ageEdit);
        }
      })
    }
  })
</script>
