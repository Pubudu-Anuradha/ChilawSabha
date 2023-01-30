<div class="sidebar">

    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/dashboard.png'?>" alt="sidebar-image" class="sidebar-img">Dashboard</a></div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/service.png'?>" alt="sidebar-image" class="sidebar-img">Services <span class="see-more" onclick="expandServ()">	&#43;</span></a>
        <div class="sub-items" id="sub-items-serv">
            <a href="#">Add Service</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/project.png'?>" alt="sidebar-image" class="sidebar-img">Projects <span class="see-more" onclick="expandProj()">	&#43;</span></a>
        <div class="sub-items" id="sub-items-proj">
            <a href="#">Add Project</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/announcement.png'?>" alt="sidebar-image" class="sidebar-img">Announcements <span class="see-more" onclick="expandAnno()">	&#43;</span></a>
        <div class="sub-items" id="sub-items-anno">
            <a href="#">Add Announcement</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/event.png'?>" alt="sidebar-image" class="sidebar-img">Events <span class="see-more" onclick="expandEve()">	&#43;</span></a>
        <div class="sub-items" id="sub-items-eve">
            <a href="#">Add Event</a>
        </div>
    </div>
    <div class="items"><a href="#" class="sidebar-drop"><img src="<?=URLROOT . '/public/assets/usermanagement.png'?>" alt="sidebar-image" class="sidebar-img">User Management <span class="see-more" onclick="expandUser()">	&#43;</span></a>
        <div class="sub-items" id="sub-items-user">
            <a href="#">Create User</a>
            <a href="#">Disabled User List</a>
        </div>
    </div>

</div>


<script>
    function expandServ(){
        document.getElementById("sub-items-serv").classList.toggle("show-drop");
    }
    function expandProj(){
        document.getElementById("sub-items-proj").classList.toggle("show-drop");
    }
    function expandAnno(){
        document.getElementById("sub-items-anno").classList.toggle("show-drop");
    }
    function expandEve(){
        document.getElementById("sub-items-eve").classList.toggle("show-drop");
    }
    function expandUser(){
        document.getElementById("sub-items-user").classList.toggle("show-drop");
    }
</script>