<?php
$admin = $_SESSION['role'] ?? 'Guest' == 'Admin';
$categories = [];
foreach($data['categories']['result'] ?? [] as $category) {
    $categories[$category['category_id']] = $category['category_name'];
}
?>
<div class="head-area">
  <h1>Contact Information for Emergencies within the area</h1>
  <hr>

  <?php
  $places = $data['places']['result'] ?? [];
  foreach($categories as $category_id => $category_name): 
    $places_category = array_filter($places, function($place) use ($category_id) {
        return $place['category_id'] == $category_id;
    });
    if(count($places_category) == 0) continue;
    $caption = $category_name; ?>
    <div class="category">
      <h2><?= $category_name ?></h2>
      <hr>
      <div class="content-table">
        <table <?=$category_id?"id=\"$category_id\"":''?>>
          <?php if($caption):?>
          <caption><?= $caption ?></caption>
          <?php endif; ?>
          <thead>
            <tr>
              <th style="background:transparent;border:none"></th>
              <th>Contact Number(s)</th>
              <th>Address</th>
              <?php if($admin):?>
              <th>Actions</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
          <?php foreach($places_category as $place): ?>
              <tr>
                <td>
                  <?= $place['place_name'] ?>
                </td>
                <td>
                  <?= $place['contact_numbers'] ?>
                </td>
                <td>
                  <?= $place['address'] ?>
                </td>
                <?php if($admin): ?>
                <td class="btn-column">
                <form method="POST" >
                  <input type="text" name="place_id" value="<?= $place['place_id'] ?>" hidden>
                  <input class="btn bg-yellow edit" type="submit" name="EditPlace" value="Edit">
                  <input class="btn bg-red delete" type="submit" name="DelPlace" value="Delete">
                </form>
                </td>
                <?php endif; ?>
              </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php if($admin): ?>
  <div class="formContainer">
  <form class="fullForm" method="POST" id="add-new">
      <?php
          if($data['AddCategory']['success'] ?? false) echo "<div>Added Successfully</div>";
          $old = $data['oldCat'] ?? [];
          $errors = $data['errorsCat'] ?? [];
          Errors::validation_errors($errors);
          Text::text('Name', 'category_name', 'category_name',
                      placeholder:'Enter new Category', maxlength:255,
                      value:$old['category_name'] ?? null);
          Other::submit('AddCategory',value:'Add a new Category');
      ?>
  </form>
  </div>

  <div class="formContainer">
  <form class="fullForm" method="POST" id="add-new">
      <?php
          if($data['AddPlace']['success'] ?? false) echo "<div>Added Successfully</div>";
          $errors = $data['errorsPlace'] ?? [];
          Errors::validation_errors($errors);
          $old = $data['oldPlace'] ?? [];
          Text::text('Name', 'place_name', 'place_name',
                      placeholder:'Enter new Place\'s name', maxlength:255,
                      value:$old['name'] ?? null);
          Text::text('New place\'s address', 'address', 'address',
                      placeholder:'Enter new place\'s address',
                      value:$old['address'] ?? null);
          Group::select('Category','category_id',$categories,
                      selected:$old['category_id'] ?? null);
          Text::text('Contact numbers', 'contact_numbers', 'contact_numbers',
                      placeholder:'Numbers(separated by commas)', maxlength:255,
                      pattern:'[0-9,\+]+',value:$old['contact_numbers'] ?? null);
          Other::submit('AddPlace',value:'Add a new Place');
      ?>
  </form>
  </div>
<script>
document.querySelectorAll('tr > td > form').forEach(form=>{
  const edit_btn = form.querySelector('.edit');
  const delete_btn = form.querySelector('.delete');
  edit_btn.addEventListener('click',e=>{
    e.preventDefault();
    if(edit_btn.value=='Edit'){
      edit_btn.value = 'Save';
      console.log(e,edit_btn);
      const td_place = form.parentElement.parentElement.querySelector('td:first-child');
      const td_contacts = form.parentElement.parentElement.querySelector('td:nth-child(2)');
      const td_address = form.parentElement.parentElement.querySelector('td:nth-child(3)');

      const place = td_place.innerText;
      const contacts = td_contacts.innerText;
      const address = td_address.innerText;

      const place_id = form.querySelector('input[type="text"]').value;

      const edit_inputs = {
        place:document.createElement('input'),
        contacts:document.createElement('input'),
        address:document.createElement('input'),
      }

      edit_inputs.place.type = 'text';
      edit_inputs.contacts.type = 'text';
      edit_inputs.address.type = 'text';

      edit_inputs.place.maxLength = 255;
      edit_inputs.contacts.maxLength = 255;
      edit_inputs.address.maxLength = 255;

      edit_inputs.place.placeholder = place;
      edit_inputs.contacts.placeholder = contacts;
      edit_inputs.address.placeholder = address;

      edit_inputs.place.value = place;
      edit_inputs.contacts.value = contacts;
      edit_inputs.address.value = address;

      edit_inputs.contacts.pattern = '[0-9,\+]+';

      edit_inputs.place.name = 'place_name';
      edit_inputs.contacts.name = 'contact_numbers';
      edit_inputs.address.name = 'address';  

      td_place.replaceChildren(edit_inputs.place);
      td_contacts.replaceChildren(edit_inputs.contacts);
      td_address.replaceChildren(edit_inputs.address);
    } else if(edit_btn.value=='Save') {
      const changes = {};
      const edit_inputs = {
        place:form.parentElement.parentElement.querySelector('td:first-child > input'),
        contacts:form.parentElement.parentElement.querySelector('td:nth-child(2) > input'),
        address:form.parentElement.parentElement.querySelector('td:nth-child(3) > input'),
      }
      const place = edit_inputs.place.placeholder;
      const contacts = edit_inputs.contacts.placeholder;
      const address = edit_inputs.address.placeholder;

      // If values in the form are not changed, don't send them
      let check_contacts = /[0-9,\+]+/
      if(edit_inputs.place.value != place) changes.place_name = edit_inputs.place.value;
      if(edit_inputs.contacts.value != contacts &&
        check_contacts.test(edit_inputs.contacts.value)) changes.contact_numbers = edit_inputs.contacts.value;
      if(edit_inputs.address.value != address) changes.address = edit_inputs.address.value;
      if(Object.keys(changes).length == 0) return;
      const place_id = form.querySelector('input[type="text"]').value;
      changes.EditPlace = place_id;
      fetch('<?= URLROOT . '/Emergency/Api' ?>',{
        method:'POST',
        headers: {
            "Content-type":"application/json"
        },
        body:JSON.stringify(changes)
      }).then(res=>res.json()).then(res=>{
        if(res.success){
          edit_btn.value = 'Edit';
          edit_inputs.place.replaceWith(edit_inputs.place.value);
          edit_inputs.contacts.replaceWith(edit_inputs.contacts.value);
          edit_inputs.address.replaceWith(edit_inputs.address.value);
        } else {
          console.log(res);
        }
      }).catch(console.log)
    }
  })
})
</script>
<?php endif; ?>
<style>
td,th {
  border: 1px solid black;
  border-radius: 0 !important;
}
caption {
  caption-side: bottom;
}
</style>
<?php ViewCounter::count('Emergency Information'); ?>