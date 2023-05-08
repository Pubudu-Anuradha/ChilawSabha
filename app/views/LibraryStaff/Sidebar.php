<div class="sidebar">

    <div class="items"><a href="<?=URLROOT . '/LibraryStaff/index'?>" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/dashboard.png'?>" alt="sidebar-image" class="sidebar-img"><span> Dashboard </span></a></div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/bookcatalog.png'?>" alt="sidebar-image" class="sidebar-img" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Bookcatalog'?>'"><span onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Bookcatalog'?>'"> Book Catalogue </span>
    <span class="see-more" id="see-more-bk" onclick='expandSideBar("sub-items-serv","see-more-bk")'>&#43;</span></a>
        <div class="sub-items" id="sub-items-serv">
            <a href="<?=URLROOT . '/LibraryStaff/addbooks'?>">Add Book</a>
            <a href="<?=URLROOT . '/LibraryStaff/lostbooks'?>">Lost Book List</a>
            <a href="<?=URLROOT . '/LibraryStaff/damagedbooks'?>">Damaged Book List</a>
            <a href="<?=URLROOT . '/LibraryStaff/delistedbooks'?>">De-Listed Book List</a>

        </div>
    </div>
    <div class="items"><a href="<?=URLROOT . '/LibraryStaff/bookrequest'?>" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/bookrequest.png'?>" alt="sidebar-image" class="sidebar-img"><span> Book Requests </span></a></div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/usermanagement.png'?>" alt="sidebar-image" class="sidebar-img" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Users'?>'"><span onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Users'?>'"> User Management </span>
    <span class="see-more" id="see-more-usr" onclick='expandSideBar("sub-items-user","see-more-usr")'>&#43;</span></a>
        <div class="sub-items" id="sub-items-user">
            <a href="<?=URLROOT . '/LibraryStaff/addusers'?>">Create User</a>
            <a href="<?=URLROOT . '/LibraryStaff/disabledusers'?>">Disabled User List</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/analytics.png'?>" alt="sidebar-image" class="sidebar-img" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/analytics'?>'"><span onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/analytics'?>'"> Analytics </span>
    <span class="see-more" id="see-more-an" onclick='expandSideBar("sub-items-analytics","see-more-an")'>&#43;</span></a>
        <div class="sub-items" id="sub-items-analytics">
            <a href="<?=URLROOT . '/LibraryStaff/booktransactions'?>">Book Transactions</a>
            <a href="<?=URLROOT . '/LibraryStaff/finance'?>">Finance</a>
            <a href="<?=URLROOT . '/LibraryStaff/userreport'?>">User Report</a>
        </div>
    </div>

</div>


<script>
    function expandSideBar(id,iconID){
        var icon = document.getElementById(iconID).innerHTML;
        if(icon == "+"){
            document.getElementById(iconID).innerHTML = "&#8722;";
        }else{
            document.getElementById(iconID).innerHTML = "&#43;";
        }
        document.getElementById(id).classList.toggle("show-drop");
    }
</script>