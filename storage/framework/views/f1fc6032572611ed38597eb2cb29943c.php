<?php if(request()->is('dashboard')): ?>
    <div class=" min-h-[88vh] border-r border-gray-300 bg-white">
        <div style="background-image: linear-gradient(#F1F5FD, #E9F0FF); background-color: aliceblue; border-bottom: 1px solid #ddd"
            class="px-[15px] py-1">
            <p class="text-sm font-bold text-[#333333] leading-loose">My Account</p>
        </div>
        <div class="bg-white">
            <div class="py-[10px]">
                <ul class="text-sm " id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li role="presentation">
                        <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                            style="color: #666666" id="account-tab" data-tabs-target="#account" type="button"
                            role="tab" aria-controls="account" aria-selected="true" autofocus>Account
                            Details</button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                            style="color: #666666" id="messages-tab" data-tabs-target="#messages" type="button"
                            role="tab" aria-controls="messages" aria-selected="false">Messages
                            (0)</button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                            style="color: #666666" id="va-tab" data-tabs-target="#va" type="button" role="tab"
                            aria-controls="va" aria-selected="false">Virtual
                            Account</button>
                    </li>
                    <li role="presentation">
                        <a href="#" class="inline-block button-tab py-2 px-5 w-full text-start leading-[normal]"
                            style="color: #666666">
                            Report
                        </a>
                    </li>
                </ul>
            </div>




        </div>
    </div>
<?php elseif(request()->is('monitor')): ?>
    <div class=" min-h-[88vh] w-[300px] border-r border-gray-300 bg-white">
        <div style="background-image: linear-gradient(#F1F5FD, #E9F0FF); background-color: aliceblue; border-bottom: 1px solid #ddd"
            class="px-[15px] py-1">
            <p class="text-sm font-bold text-[#333333] leading-loose">My Account</p>
        </div>
        <div class="bg-white w-full">cek

        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\traccar\traccar_breeze\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>