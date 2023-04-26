<div class="content">
  <?php $userStat = $data['userStat']['result'] ?? '';?>
    <div class="page">
        <div class="lend-book">
            <form action="<?=URLROOT . '/LibraryStaff/index' ?>" method="post" id="Form">
            <div class="usr-search">
                <div class="search-bar">
                    <input type="search" name="search" placeholder=" Search User" id="search" value="<?= $_POST['search'] ?? '' ?>" onkeyup="searchUser()">
                    <button name='search-btn' id='searchBtn'>
                        <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="search btn">
                    </button>
                </div>

                <div id ="usr-search-list" class="usr-search-list"></div>
            </div>

            <div class="lend-book-content">
                <div class="lend-form">
                        <div class="lend-book-title">
                            <h2>LEND A BOOK</h2>
                        </div>
                        <div class="field">
                            <label for="acc1">Book Accession No 01</label>
                            <input type="search" placeholder="Enter Book Accession No" name="acc1" id="acc1"  onblur="searchBook('acc1')">
                        </div>
                        <div class="field">
                            <label for="acc2">Book Accession No 02</label>
                            <input type="search" placeholder="Enter Book Accession No" name="acc2" id="acc2"  onblur="searchBook('acc2')">
                        </div>
                        <div class="lend-confirm">
                            <button type="button" class="btn white bg-blue" onclick="openModal(null, 'lendBtn', 'lend', <?php echo htmlspecialchars(json_encode($userStat)); ?>)">Lend</button>
                            <?php Modal::Modal(content:'Are You Sure?',name:'lendBtn', id:'lendBtn', confirmBtn:true); ?>
                            <?php Modal::Modal(content:'Please Search A Valid User',name:'errorModal', id:'errorModal'); ?>
                        </div>
                </div>
                <div class="status">
                    <div>
                        <h2>USER STATISTICS</h2>
                    </div>
                    <div class="status-content">
                        <div>
                            <h4>User Name : </h4>
                            <div class="green" id="userName"><?=$userStat[0]['name'] ?? 'No User'?></div>
                        </div>
                        <div>
                            <h4 >Fine : </h4>
                            <div id="fineCal" class="green"></div>
                        </div>
                        <div>
                            <h4 >Books Lost : </h4>
                            <div class="<?php echo (isset($userStat[0]['no_of_books_lost']) && ($userStat[0]['no_of_books_lost'] > 0)) ?
                            'red':'green'?>"><?=$userStat[0]['no_of_books_lost'] ?? '0'?></div>
                        </div>
                        <div>
                            <h4>Books Damaged : </h4>
                            <div class="<?php echo (isset($userStat[0]['no_of_books_damaged']) && ($userStat[0]['no_of_books_damaged'] > 0)) ?
                            'red':'green'?>"><?=$userStat[0]['no_of_books_damaged'] ?? '0'?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="recieve-book">
            <div class="recieve-book-title">
                <h2>RECIEVE A BOOK</h2>
                <div class="extend-due-date">
                    <input type="button" value="Extend Due Date" class="btn bg-blue white" onclick="openModal(null,'lendBtn', 'extend', <?php echo htmlspecialchars(json_encode($userStat)); ?>)">
                </div>
            </div>
            <div class="recieve-book-content">
                <div class="content-table">
                    <table id="borrowTable">
                        <thead>
                            <tr>
                                <th>Accession No</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Book Category</th>
                                <th>Due Date</th>
                                <th>Damaged</th>
                                <th>Recieved</th>
                            </tr>
                        </thead>
                        <?php if(isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])):
                            $count = 0;
                            foreach ($userStat as $borrowData):
                              if(!isset($borrowData['recieved_date'])):
                                $count++;?>
                        <tr id="<?=$borrowData['accession_no']?>" >
                            <td><?=$borrowData['accession_no']?></td>
                            <td><?=$borrowData['title']?></td>
                            <td><?=$borrowData['author']?></td>
                            <td><?=$borrowData['publisher']?></td>
                            <td><?=$borrowData['category_name']?></td>
                            <td><?=$borrowData['due_date']?></td>
                            <td class="check"><input type="checkbox" name="<?= "damagedcheck$count"?>" id="<?= "damagedcheck$count"?>"></td>
                            <td class="check"><input type="checkbox" name="<?= "recievedcheck$count"?>" id="<?= "recievedcheck$count"?>" checked></td>
                        </tr>
                      <?php endif;endforeach;else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center">Borrow Data Not Found</td>
                        </tr>
                      <?php endif; ?>
                    </table>
                </div>
                <?php  if(isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])): ?>
                <div class="recieve-submition">
                    <div class="recieve-confirm">
                        <input type="button" value="Confirm" class="btn bg-green white" onclick="openModal(null,'lendBtn', 'recieve', <?php echo htmlspecialchars(json_encode($userStat)); ?>)">
                    </div>
                </div>
              <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
var acc1 = document.getElementById('acc1');
var acc2 = document.getElementById('acc2');
var form = document.getElementById('Form');
var searchBtn = document.getElementById('searchBtn');
var userName = document.getElementById('userName');
var user = document.getElementById('search');
var borrowTable = document.getElementById('borrowTable');
var damageCheckFrow = document.getElementById('damagedcheck1');
var recieveCheckFrow = document . getElementById('recievedcheck1');
var damageCheckSrow = document . getElementById('damagedcheck2');
var recieveCheckSrow = document . getElementById('recievedcheck2');
var fineCal = document . getElementById('fineCal');
var openedModal;
var fineAmont;

acc2.addEventListener('change',function(e){
    if(acc1.value == acc2.value){
        acc2 . setCustomValidity('Book Accessions are same');
    }
});

searchBtn.addEventListener('click',function(){
    acc1.setCustomValidity('');
    acc2.setCustomValidity('');
    form.submit();
});

//fine calculation dynamically
window.onload = async function(){
    var data = <?php echo ((isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])) ? json_encode($userStat) : 0);?>;
    var Amount = await calculateFine(data);
    if(Amount>0){
        fineCal.classList.remove('green');
        fineCal.classList.add('red');
        fineCal.innerText = "Rs."+Amount;
    }
    else{
        fineCal.innerText = "Rs."+Amount+".00";
    }
}

async function calculateFine(data){
    var damaged_fine,delay_after_fine,delay_month_fine,lost_fine;


    if(data != 0){
        try{
            const response = await fetch("<?=URLROOT . '/LibraryStaff/index'?>",{
                method:"POST",
                headers: {
                    "Content-type":"application/json"
                },
                body: JSON.stringify({'searchID':'fineInfo'})
            });
            const fineData = await response.json();
            if(fineData.length > 0){
                damaged_fine = parseFloat(fineData[0]['result'][0]['damaged_fine']);
                delay_after_fine = parseFloat(fineData[0]['result'][0]['delay_after_fine']);
                delay_month_fine = parseFloat(fineData[0]['result'][0]['delay_month_fine']);
                lost_fine = parseFloat(fineData[0]['result'][0]['lost_fine']);
            }
        }
        catch(err) {
            damaged_fine = 0;
            delay_after_fine = 0;
            delay_month_fine = 0;
            lost_fine = 0;
        };

        const today = new Date();
        const due_date = new Date(data[0]['due_date']);

        //due date comparison
        if(today > due_date){
            const mili_sec_per_day = 1000 * 60 * 60 * 24;

            const timeDiff = today.getTime() - due_date.getTime();
            const diffInDays = Math.ceil(timeDiff / mili_sec_per_day);

            //for less than or equal to 1month(30 days)
            if(diffInDays <= 30){
                fineAmont = diffInDays * delay_month_fine;
            }
            //more than 1 month
            else{
                fineAmont = (30 * delay_month_fine) + ((diffInDays-30)*delay_after_fine);
            }
            if(!recieveCheckFrow.checked ){
                fineAmont = fineAmont + lost_fine;
            }
            if(!recieveCheckSrow.checked ){
                fineAmont = fineAmont + lost_fine;
            }
            if(damageCheckFrow.checked && recieveCheckFrow.checked){
                fineAmont = fineAmont + damaged_fine;
            }
            if(damageCheckSrow.checked && recieveCheckSrow.checked){
                fineAmont = fineAmont + damaged_fine;
            }
        }
        else{
            fineAmont = 0;
            if(!recieveCheckFrow.checked ){
                fineAmont = fineAmont + lost_fine;
            }
            if(!recieveCheckSrow.checked ){
                fineAmont = fineAmont + lost_fine;
            }
            if(damageCheckFrow.checked && recieveCheckFrow.checked){
                fineAmont = fineAmont + damaged_fine;
            }
            if(damageCheckSrow.checked && recieveCheckSrow.checked){
                fineAmont = fineAmont + damaged_fine;
            }
        }

        return fineAmont;
    }
    else{
        fineAmont = 0;
        return fineAmont;
    }
}

//to dynamicaly change fine values on checkbox check
if(recieveCheckFrow){
    recieveCheckFrow.addEventListener('change',async function(){
        var data = <?php echo ((isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])) ? json_encode($userStat) : 0);?>;
        var Amount =  await calculateFine(data);
        if(Amount>0){
            fineCal.classList.remove('green');
            fineCal.classList.add('red');
            fineCal.innerText = "Rs."+Amount;
        }
        else{
            fineCal.classList.remove('red');
            fineCal.classList.add('green');
            fineCal.innerText = "Rs."+Amount+".00";
        }
    });
}

if(recieveCheckSrow){
    recieveCheckSrow.addEventListener('change',async function(){
        var data = <?php echo ((isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])) ? json_encode($userStat) : 0);?>;
        var Amount =  await calculateFine(data);
        if(Amount>0){
            fineCal.classList.remove('green');
            fineCal.classList.add('red');
            fineCal.innerText = "Rs."+Amount;
        }
        else{
            fineCal.classList.remove('red');
            fineCal.classList.add('green');
            fineCal.innerText = "Rs."+Amount+".00";
        }
    });
}

if(damageCheckFrow){
    damageCheckFrow.addEventListener('change',async function(){
        var data = <?php echo ((isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])) ? json_encode($userStat) : 0);?>;
        var Amount =  await calculateFine(data);
        if(Amount>0){
            fineCal.classList.remove('green');
            fineCal.classList.add('red');
            fineCal.innerText = "Rs."+Amount;
        }
        else{
            fineCal.classList.remove('red');
            fineCal.classList.add('green');
            fineCal.innerText = "Rs."+Amount+".00";
        }
    });
}

if(damageCheckSrow){
    damageCheckSrow.addEventListener('change',async function(){
        var data = <?php echo ((isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])) ? json_encode($userStat) : 0);?>;
        var Amount =  await calculateFine(data);
        if(Amount>0){
            fineCal.classList.remove('green');
            fineCal.classList.add('red');
            fineCal.innerText = "Rs."+Amount;
        }
        else{
            fineCal.classList.remove('red');
            fineCal.classList.add('green');
            fineCal.innerText = "Rs."+Amount+".00";
        }
    });
}

function closeModal(){
    openedModal.style.display = "none";
}

function openModal(id,modal,type,data=null){
    event.preventDefault();
    if(data.length != 0){
                switch(type){
                    case 'lend':
                        openedModal = document.getElementById(modal);

                        if(data.length>0 && data[0]['recieved_date'] == null){
                            modal = 'errorModal';
                            openedModal = document.getElementById(modal);
                            openedModal.querySelector('p').innerText = "User have Books to Return";
                            openedModal.style.display = "block";
                        }
                        else{
                            if(acc1.value == ''){
                                acc1 . setCustomValidity('Please Provide Book Accession Number');
                            }
                            if(acc2.value == ''){
                                acc2 . setCustomValidity('Please Provide Book Accession Number');
                            }
                            if(acc1.value == acc2.value){
                                acc2 . setCustomValidity('Book Accessions are same');
                            }

                            //only lend modal pop up when no validate errors
                            if(acc1.validity.valid && acc2.validity.valid){
                                var bookVal = {
                                'value1':acc1.value.match(/\d+/g)[0],
                                'value2':acc2.value.match(/\d+/g)[0],
                                'searchID':'countPlanToRead'
                                }

                                fetch("<?=URLROOT . '/LibraryStaff/index'?>",{
                                    method:"POST",
                                    headers: {
                                        "Content-type":"application/json"
                                    },
                                    body: JSON.stringify(bookVal)
                                })
                                .then(response => response.json())
                                .then(response => {
                                    if(response[0].length == 2){
                                        openedModal.querySelector('p').innerText = "The books \n" + acc1.value +" : "+ response[0][0]['result'][0]['acc1Count']
                                        + " plan to read users \n" + acc2.value +" : "+ response[0][1]['result'][0]['acc2Count'] + " plan to read users \n" +
                                        "Confirm Lending ?";
                                    }
                                    openedModal.style.display = "block";
                                })
                                .catch(err => {
                                    modal = 'errorModal';
                                    openedModal = document.getElementById(modal);
                                    openedModal.querySelector('p').innerText = "Data Retrieving Error";
                                    openedModal.style.display = "block";
                                });
                            }
                            else{
                                form.reportValidity();
                            }
                        }
                        break;
                    case 'recieve':
                        openedModal = document.getElementById(modal);

                        //create a hidden input field only to confirm reqeust coming from recieve
                        var recieveFlag = document.createElement('input');
                        recieveFlag.type = "hidden";
                        recieveFlag.name = "recieveFlag";
                        recieveFlag.value = fineAmont;

                        var fineData = ((data[0]['due_date'] != null) && (data[0]['recieved_date'] == null)) ? data : 0;
                        if(recieveCheckFrow.checked && recieveCheckSrow.checked && !damageCheckFrow.checked && !damageCheckSrow.checked){
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Recieved\n"
                                + data[1]['title'] + " : Recieved\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Recieved\n"
                                + data[1]['title'] + " : Recieved\n";
                            }
                        }
                        else if (recieveCheckFrow.checked && recieveCheckSrow.checked && damageCheckFrow.checked && !damageCheckSrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Damaged\n"
                                + data[1]['title'] + " : Recieved\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Damaged\n"
                                + data[1]['title'] + " : Recieved\n";
                            }
                        }
                        else if (recieveCheckFrow.checked && recieveCheckSrow.checked && !damageCheckFrow.checked && damageCheckSrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Recieved\n"
                                + data[1]['title'] + " : Damaged\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Recieved\n"
                                + data[1]['title'] + " : Damaged\n";
                            }
                        }
                        else if (recieveCheckFrow.checked && recieveCheckSrow.checked && damageCheckFrow.checked && damageCheckSrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Damaged\n"
                                + data[1]['title'] + " : Damaged\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Damaged\n"
                                + data[1]['title'] + " : Damaged\n";
                            }
                        }
                        else if (!recieveCheckFrow.checked && recieveCheckSrow.checked && !damageCheckSrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Lost\n"
                                + data[1]['title'] + " : Recieved\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Lost\n"
                                + data[1]['title'] + " : Recieved\n";
                            }
                        }
                        else if (!recieveCheckFrow.checked && recieveCheckSrow.checked && damageCheckSrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Lost\n"
                                + data[1]['title'] + " : Damaged\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Lost\n"
                                + data[1]['title'] + " : Damaged\n";
                            }
                        }
                        else if (recieveCheckFrow.checked && !recieveCheckSrow.checked && !damageCheckFrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Recieved\n"
                                + data[1]['title'] + " : Lost\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Recieved\n"
                                + data[1]['title'] + " : Lost\n";
                            }
                        }
                        else if (recieveCheckFrow.checked && !recieveCheckSrow.checked && damageCheckFrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Damaged\n"
                                + data[1]['title'] + " : Lost\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Damaged\n"
                                + data[1]['title'] + " : Lost\n";
                            }
                        }
                        else if (!recieveCheckFrow.checked && !recieveCheckSrow.checked) {
                            if(fineAmont != 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Lost\n"
                                + data[1]['title'] + " : Lost\n" + "Please Make Sure User Settled the Fines?";
                            }
                            else if(fineAmont == 0){
                                openedModal.querySelector('p').innerText = "The Books \n" + data[0]['title'] + " : Lost\n"
                                + data[1]['title'] + " : Lost\n";
                            }
                        }
                        openedModal.querySelector('.model-text').appendChild(recieveFlag);
                        openedModal.style.display = "block";
                        break;
                    case 'extend':
                        openedModal = document.getElementById(modal);

                        if(data.length>0 && data[0]['recieved_date'] != null){
                            modal = 'errorModal';
                            openedModal = document.getElementById(modal);
                            openedModal.querySelector('p').innerText = "User haven't Borrowed Any Books";
                            openedModal.style.display = "block";
                        }
                        else{
                            var accessions = {
                                'value1':data[0]['accession_no'],
                                'value2':data[1]['accession_no'],
                                'searchID':'extendedCount'
                            }

                            fetch("<?=URLROOT . '/LibraryStaff/index'?>",{
                                method:"POST",
                                headers: {
                                    "Content-type":"application/json"
                                },
                                body: JSON.stringify(accessions)
                            })
                            .then(response => response.json())
                            .then(response => {
                                if((response[0]['extendCount'].length == 2) && (response[0]['planToReadCount'].length == 2)){
                                    extended_count_1 = response[0]['extendCount'][0]['result'][0]['extended_time'];
                                    extended_count_2 = response[0]['extendCount'][1]['result'][0]['extended_time'];

                                    if(extended_count_1<3 && extended_count_2<3 && (extended_count_1==extended_count_2)){
                                        openedModal.querySelector('p').innerText = "The books \n" + data[0]['title'] +" : "+ response[0]['planToReadCount'][0]['result'][0]['acc1Count']
                                        + " plan to read users \n" + data[1]['title'] +" : "+ response[0]['planToReadCount'][1]['result'][0]['acc2Count'] + " plan to read users \n" +
                                        "Confirm Extending ?";
                                    }
                                    else if (extended_count_1 >= 3 || extended_count_2 >=3){
                                        modal = 'errorModal';
                                        openedModal = document.getElementById(modal);
                                        openedModal.querySelector('p').innerText = "User Have Exceeded the Extend Count";
                                    }
                                    openedModal.style.display = "block";
                                }
                            })
                            .catch(err => {
                                modal = 'errorModal';
                                openedModal = document.getElementById(modal);
                                openedModal.querySelector('p').innerText = "Data Retrieving Error";
                                openedModal.style.display = "block";
                            });
                        }
                        break;
                    default:
                        break;
                }
    }
    else{
        modal = 'errorModal';
        openedModal = document.getElementById(modal);
        openedModal.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == openedModal) {
            openedModal.style.display = "none";
        }
    }
}

function searchUser(){
    var searchDiv = document.getElementById('usr-search-list');
    var userVal = {
      'value':user.value,
      'searchID':'userSearch'
    }

    fetch("<?=URLROOT . '/LibraryStaff/index'?>",{
        method:"POST",
        headers: {
            "Content-type":"application/json"
        },
        body: JSON.stringify(userVal)
    })
    .then(response => response.json())
    .then(response => {

        if(response.length > 0){
            searchDiv.innerHTML = '';
            var i = 0;
            response[0].forEach(result => {
                const searchResultDiv = document.createElement('div');
                searchResultDiv.classList.add('search-result');
                searchResultDiv.innerHTML = response[0][i]['membership_id'] + " " + response[0][i]['name'];

                searchResultDiv.addEventListener('click', () => {
                    user.value = searchResultDiv.innerText;
                    searchDiv.innerHTML = '';
                });
                window.addEventListener('click', () => {
                    searchDiv.innerHTML = '';
                });
                searchDiv.append(searchResultDiv);
                i++;
            });
        }
    })
    .catch(err => {
        searchDiv.innerHTML = '';
    });
}

function searchBook(id){
    var book = document.getElementById(id);
    var value = book.value;
    var bookVal = {
        'value':book.value,
        'searchID':'bookSearch'
    }
    book.onfocus = function() {
        book.style.color = 'black';
        book.value = value;
    }
    if(book.value != ''){
        fetch("<?=URLROOT . '/LibraryStaff/index'?>",{
            method:"POST",
            headers: {
                "Content-type":"application/json"
            },
            body: JSON.stringify(bookVal)
        })
        .then(response => response.json())
        .then(response => {
            if(response.length > 0){
                if(response.length == 2 && response[1] == 1){
                    book.style.color = 'green';
                    book . setCustomValidity('');
                    book.value = bookVal['value'] + "  "  + response[0];
                }
                else{
                    book.style.color = 'red';
                    book . setCustomValidity('Book Not Available');
                    book.value = bookVal['value'] + "  " + 'Book Not Available';
                }
            }
            else{
                book.style.color = 'red';
                book . setCustomValidity('Book Not Found');
                book.value = bookVal['value'] + "  " + 'Book Not Found';
            }
        })
        .catch(err => {
            book.style.color = 'red';
            book.value = bookVal['value'] + "  " + 'Book Not Found';
        });
    }
}

</script>
