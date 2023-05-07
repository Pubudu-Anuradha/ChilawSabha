<div class="container-body">
    <div class="contact-page">
        <h1>CONTACT US <hr class="hr1"></h1>
        <div class="sabha-contact">
            <h2> Chilaw pradeshiya Sabha Head Office</h2>
            <div class="sabha-contact-details">
                <div class="sabha-data">
                    <span class="icon">&#9993;</span> Email
                    <div>chlawpsproject@gmail.com</div>
                </div>
                <div class="sabha-data">
                    <span class="icon">&#9750;</span> Address
                    <div>Dansela, Suduwella, Madampe</div>
                </div>
                <div class="sabha-data">
                    <span class="icon">&#9743;</span> Telephone
                    <div>032-2247675</div>
                </div>
            </div>
            <div class="sabha-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.724123000269!2d79.84854031523255!3d7.495680313176087!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2cfe0ff0a56d1%3A0xdde6e655ec5fd5!2sChilaw%20Pradeshiya%20Sabha%20-%20Madampe!5e0!3m2!1sen!2slk!4v1676963417808!5m2!1sen!2slk"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        
        <div class="lib-contact">
            <h2>Yagampaththu Public Library</h2>
            
            <div class="lib-contact-details">
                <div class="lib-data">
                    <span class="icon">&#9993;</span> Email
                    <div>chilawlibrary@gov.lk</div>
                </div>
                <div class="lib-data">
                    <span class="icon">&#9750;</span> Address
                    <div>Kurunegala-Narammala-Madampe Rd, Madampe</div>
                </div>
                <div class="lib-data">
                    <span class="icon">&#9743;</span> Telephone
                    <div>032-2247675</div>
                </div>
            </div>
            <div class="lib-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.7222389430026!2d79.84855101523259!3d7.495887713173423!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2cf5fc9cee399%3A0x6203dbeb1203d4f9!2sYagampattu%20Public%20Library!5e0!3m2!1sen!2slk!4v1676963712985!5m2!1sen!2slk"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <h2>Our People</h2>
        <div class="card-container" id="card-container">
        </div>
        </div>
<?php if(($_SESSION['role'] ?? 'Guest') == 'Admin'): 
    $cards = $data['cards']['result'] ?? [];?>
    <h3>Edit Contacts</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Contact No</th>
                <th>email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($cards) == 0): ?>
            <tr>
                <td colspan="5">No Cards Available</td>
            </tr>
<?php       endif;            
            foreach($cards as $card): ?>
            <form id="<?= $card['card_id'] ?>" method="POST">
            <tr>
                <td class="name"><?= $card['name'] ?></td>
                <td class="position"><?= $card['position'] ?></td>
                <td class="contact_no"><?= $card['contact_no'] ?></td>
                <td class="email"><?= $card['email'] ?></td>
                <td class="btn-column">
                    <a href="<?= $card['card_id'] ?>" class="btn edit bg-yellow"></a>
                        <input type="number" aria-label="card-id" name="card_id" id="del-<?= $card['card_id'] ?>" hidden=true
                        value="<?= $card['card_id'] ?>">
                        <input aria-label="delete card" type="submit" name="Delete" value="X" class="delist" style="background-color: var(--red);">
                </td>
            </tr>
            </form>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="formContainer">
    <form class="fullForm" method="POST" id="add-new">
        <?php
            if($data['Add'] ?? false) echo "<div>Added Successfully</div>";
            $errors = $data['errors'] ?? [];
            Errors::validation_errors($errors);
            Text::text('Name', 'name', 'name',
                        placeholder:'Enter new contact\'s name', maxlength:255,
                        value:$old['name'] ?? null);
            Text::text('Position', 'position', 'position',
                        placeholder:'Enter new contact\'s name', maxlength:255,
                        value:$old['name'] ?? null);
            Text::email('New contact\'s email', 'email', 'email',
                        placeholder:'Enter new contact\'s email',
                        value:$old['email'] ?? null);
            Text::text('Contact number', 'contact_no', 'contact_no',
                        '+94XXXXXXXXX or 0XXXXXXXXX', type:'tel', maxlength:12,
                        pattern:"(\+94\d{9})|0\d{9}", value:$old['contact_no'] ?? null);
            Other::submit('Add',value:'Add a new contact');
        ?>
    </form>
    </div>
    <?php foreach($cards as $card): ?>

    <?php endforeach; ?>
<?php endif; ?>
    </div>
</div>

<script>
const card_container = document.getElementById('card-container');
const refresh_cards = () =>{
    fetch('<?= URLROOT . '/ContactUs/cardsApi' ?>',{
        method:'POST',
        headers: {
            "Content-type":"application/json"
        },
        body:JSON.stringify({
            "action":"getCards"
        })
    }).then(res => res.json()).then(response => {
        if(response.result) {
            card_container.innerHTML = '';
            response.result.forEach((card)=>{
                inner = ``
                inner += `
                    <div class="name">
                        ${card.name}
                    </div>
                    <div class="position">
                        ${card.position}
                    </div>`
                if(card.contact_no) {
                    inner += `
                    <div class="contact">
                        ${card.contact_no}
                    </div>`
                }
                if(card.email) {
                    inner += `
                    <div class="email">
                        ${card.email}
                    </div>`
                }
                card_container.innerHTML += `<div class="card"> ${inner}</div>`;
            })
        }
    });
}
refresh_cards();
</script>
<?php if(($_SESSION['role'] ?? 'Guest') == 'Admin'): ?>
<script>
var cards = <?= json_encode($cards) ?>;
const edit_btns = document.querySelectorAll('.edit');
edit_btns.forEach(btn=>{
    btn.state = 'Edit';
    btn.addEventListener('click',(e)=>{
        e.preventDefault();
        var card_id = btn.getAttribute('href');
        const card = cards.find(card => card.card_id == card_id);
        const td_name = btn.parentElement.parentElement.querySelector('.name');
        const td_position = btn.parentElement.parentElement.querySelector('.position');
        const td_contact_no = btn.parentElement.parentElement.querySelector('.contact_no');
        const td_email = btn.parentElement.parentElement.querySelector('.email');
        if(btn.state == 'Edit'){
            const card = cards.find(card => card.card_id == card_id);
            td_name.innerHTML = `<input type="text" value="${card.name}">`;
            td_position.innerHTML = `<input type="text" value="${card.position}">`;
            td_contact_no.innerHTML = `<input type="text" value="${card.contact_no}">`;
            td_email.innerHTML = `<input type="email" value="${card.email}">`;
            btn.state = 'Save';
            btn.classList.remove('bg-yellow');
            btn.classList.add('bg-green');
            btn.classList.remove('edit');
            btn.classList.add('enable');
        } else if(btn.state == 'Save'){
            const form = document.getElementById(card_id);
            console.log(form)
            if(form.reportValidity()){
            console.log(form)
                td_name.disabled = true;
                td_position.disabled = true;
                td_contact_no.disabled = true;
                td_email.disabled = true;

                const name = td_name.querySelector('input').value;
                const position = td_position.querySelector('input').value;
                const contact_no = td_contact_no.querySelector('input').value;
                const email = td_email.querySelector('input').value;

                let changes = {
                };
                if(name != card.name) changes.name = name;
                if(position != card.position) changes.position = position;
                if(contact_no != card.contact_no) changes.contact_no = contact_no;
                if(email != card.email) changes.email = email;
                console.log(changes);
                fetch('<?= URLROOT . '/ContactUs/cardsApi/Update/' ?>' + card_id,{
                    method:'POST',
                    headers: {
                        "Content-type":"application/json"
                    },
                    body:JSON.stringify(changes)
                }).then(res => res.json()).then(response => {
                    if(response.success) {
                        btn.state = 'Edit';
                        btn.classList.remove('bg-green');
                        btn.classList.add('bg-yellow');
                        btn.classList.remove('enable');
                        btn.classList.add('edit');
                        td_name.innerHTML = name;
                        td_position.innerHTML = position;
                        td_contact_no.innerHTML = contact_no;
                        td_email.innerHTML = email;
                        refresh_cards();
                    } else {
                        console.log(response);
                    }}).catch(err => {
                        console.log(err);
                    });
            } else {
                console.log('AAAAAAAAAAAAAAAAAAA')
            }
        }
    })
})
</script>
<?php endif; ?>