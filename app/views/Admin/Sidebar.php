<div class="sidebar">

    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/dashboard.png'?>" alt="sidebar-image" class="sidebar-img"><span> Dashboard </span></a></div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/service.png'?>" alt="sidebar-image" class="sidebar-img"><span> Services </span><span class="see-more" onclick='expandSideBar("sub-items-serv")'>	&#43;</span></a>
        <div class="sub-items" id="sub-items-serv">
            <a href="#">Add Service</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/project.png'?>" alt="sidebar-image" class="sidebar-img"><span> Projects </span><span class="see-more" onclick='expandSideBar("sub-items-proj")'>	&#43;</span></a>
        <div class="sub-items" id="sub-items-proj">
            <a href="#">Add Project</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/announcement.png'?>" alt="sidebar-image" class="sidebar-img"><span> Announcements </span><span class="see-more" onclick='expandSideBar("sub-items-anno")'>	&#43;</span></a>
        <div class="sub-items" id="sub-items-anno">
            <a href="#">Add Announcement</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/event.png'?>" alt="sidebar-image" class="sidebar-img"><span> Events </span><span class="see-more" onclick='expandSideBar("sub-items-eve")'>	&#43;</span></a>
        <div class="sub-items" id="sub-items-eve">
            <a href="#">Add Event</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/usermanagement.png'?>" alt="sidebar-image" class="sidebar-img"><span> User Management </span><span class="see-more" onclick='expandSideBar("sub-items-user")'>	&#43;</span></a>
        <div class="sub-items" id="sub-items-user">
            <a href="#">Create User</a>
            <a href="#">Disabled User List</a>
        </div>
    </div>

</div>


<script>
    function expandSideBar(id){
        document.getElementById(id).classList.toggle("show-drop");
    }
</script>