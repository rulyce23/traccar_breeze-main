  <style>
        /* Container for the dropdown menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown button */
        .dropdown-button {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .dropdown-button i {
            margin-right: 5px;
        }

        /* Dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 9999; /* Ensure dropdown is on top */
            top: 100%; /* Position dropdown below the button */
            left: 0; /* Align dropdown with the button */
        }

        /* Dropdown links */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Change color of dropdown button on hover */
        .dropdown:hover .dropdown-button {
            background-color: #ddd;
        }



           /* Tambahkan CSS untuk dialog konfirmasi */
           .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: black;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: white;
            margin: auto;
            color: black;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-button {
            margin: 10px;
        }
    </style>
<nav class="w-full h-[60px] bg-[#0087d6]">
    <div class="flex justify-between">
        <div class="flex text-white">
            <div>
                <a href="<?php echo e(route('monitor.index')); ?>">
                <div class="flex gap-[3px] py-[22px] pl-[2px] pr-2 items-center text-sm hover:text-[yellow]">
                        <i class="fa fa-map-o"></i>
                        <p>Monitor</p>
                    </div>
                </a>
        </div>
        <div>
            <a href="<?php echo e(route('device.index')); ?>">
            <div class="flex gap-[3px] py-[22px] pl-[2px] pr-2 items-center text-sm hover:text-[yellow]">
                <i class="fa fa-hdd-o"></i>
                <p>Device</p>
            </div>
            </a>
        </div>
        <div>
        <a href="<?php echo e(route('account.index')); ?>">
        <div class="flex gap-[3px] py-[22px] pl-[2px] pr-2 items-center text-sm hover:text-[yellow]">
                <i class="fa fa-group"></i>
                <p>Account</p>
            </div>
            </a>
            </div>
            <!-- <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-object-group"></i>
                <p>Geo Fence</p>
            </div> -->
            <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-video-camera"></i>
                <p>Video</p>
            </div>
            <!-- <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-cab"></i>
                <p>Fleet</p>
            </div> -->
            <div class="ml-[15px] p-[15px]">
                <a class="w-8 h-8 bg-[#2b9bdd] hover:bg-white hover:text-[#0087d6] transition duration-500 flex rounded-full items-center justify-center"
                    href="">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </div>
        <div class="text-white text-sm" style="padding: 12px 15px 0 15px; line-height: normal">
            <div class="flex justify-end gap-3">
            <h1>Welcome, <?php echo e($userName); ?></h1>
            </div>
            <div class="flex gap-[18px]">
                <div class="flex items-center">
                    <i class="fa fa-send-o"></i>
                    <p>&nbsp;Command</p>
                </div>
                <div class="flex items-center">
                    <i class="fa fa-question-circle"></i>
                    <p>&nbsp;Help</p>
                </div>
                <div class="dropdown">
                <div class="dropdown-button">
                    <i class="fa fa-cogs"></i>
                    <p>&nbsp;Settings</p>
                </div>
                <div class="dropdown-content">
                    <a href="#">My Profile</a>
                    <a href="#">Change Password</a>
                    <a href="#" id="logoutButton">Log Out</a>

            </div>

                <div id="logoutModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Are you sure you want to logout?</p>
                    <button id="confirmLogout" class="modal-button">Yes</button>
                    <button id="cancelLogout" class="modal-button">No</button>
                </div>


    </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutButton = document.getElementById('logoutButton');
            const logoutModal = document.getElementById('logoutModal');
            const confirmLogout = document.getElementById('confirmLogout');
            const cancelLogout = document.getElementById('cancelLogout');
            const closeModal = document.querySelector('.close');

            logoutButton.addEventListener('click', function() {
                logoutModal.style.display = 'block';
            });

            closeModal.addEventListener('click', function() {
                logoutModal.style.display = 'none';
            });

            cancelLogout.addEventListener('click', function() {
                logoutModal.style.display = 'none';
            });

            confirmLogout.addEventListener('click', function() {
                window.location.href = '/logout'; // Mengarahkan ke rute logout
            });

            window.addEventListener('click', function(event) {
                if (event.target === logoutModal) {
                    logoutModal.style.display = 'none';
                }
            });
        });
    </script>
</nav>
<?php /**PATH C:\xampp\htdocs\traccar_breeze-main\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>