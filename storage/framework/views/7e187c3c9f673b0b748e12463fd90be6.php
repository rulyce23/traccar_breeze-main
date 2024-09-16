<nav class="w-full h-[60px] bg-[#0087d6]">
    <div class="flex justify-between">
        <div class="flex text-white">
            <div>
                <a href="<?php echo e(route('dashboard')); ?>">
                    <div class="flex gap-[3px] py-[22px] pl-[2px] pr-2 items-center text-sm hover:text-[yellow]">
                        <i class="fa fa-id-card-o"></i>
                        <p>Dashboard</p>
                    </div>
                </a>
            </div>
            <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-hdd-o"></i>
                <p>Device</p>
            </div>
            <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-group"></i>
                <p>Account</p>
            </div>
            <div>
                <a href="<?php echo e(route('monitor.index')); ?>">
                    <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm hover:text-[yellow]">
                        <i class="fa fa-map-o"></i>
                        <p>Monitor</p>
                    </div>
                </a>
            </div>
            <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-object-group"></i>
                <p>Geo Fence</p>
            </div>
            <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-video-camera"></i>
                <p>Video</p>
            </div>
            <div class="flex gap-[3px] py-[22px] px-2 items-center text-sm">
                <i class="fa fa-cab"></i>
                <p>Fleet</p>
            </div>
            <div class="ml-[15px] p-[15px]">
                <a class="w-8 h-8 bg-[#2b9bdd] hover:bg-white hover:text-[#0087d6] transition duration-500 flex rounded-full items-center justify-center"
                    href="">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </div>
        <div class="text-white text-sm" style="padding: 12px 15px 0 15px; line-height: normal">
            <div class="flex justify-end gap-3">
                <p class=" mb-[5px]">Hello,</p>
                <span class="font-bold    "> test123</span>
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
                <div class="flex items-center">
                    <i class="fa fa-cogs"></i>
                    <p>&nbsp;Settings</p>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\traccar\traccar_breeze\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>