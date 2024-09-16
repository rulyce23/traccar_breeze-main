<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class=" w-[300px]" style="padding:4px 15px">
        <div class="flex justify-between">
            <p
                style="display: inline-block;font-size: 16px;color: #333;margin-right: 10px;width: 120px;line-height: 24px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                002 GAYATRI</p>
            <p class="text-end"
                style="display: inline-block;color: #808080;font-size: 14px;font-weight: 400;padding-right: 10px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 130px;line-height: 24px;">
                353701098046143</p>
        </div>
        <div class="grid grid-cols-2 mb-[10px]">
            <div class="w-[100px] h-[100px] border border-green-500"></div>
            <div class="flex h-full items-center">
                <div class="space-y-2">
                    <div class="flex gap-[10px] items-center">
                        <i class="text-[18px] icon-engine"></i>
                        <p class="text-[#00D600] text-[12px]">ON</p>
                    </div>
                    <div class="flex gap-[10px] items-center">
                        <i class="text-[18px] icon-satellite"></i>
                        <p class="text-[12px]">0</p>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <p class="text-[12px]">Last Positioning: </p>
        </div>
    </div>
    <div id="myTabContent">
        <div class="hidden" id="account" role="tabpanel" aria-labelledby="account-tab">

            <div class="border-b bg-[aliceblue]" x-data="{
                openTab: 1,
                activeClasses: 'border-[1px] border-gray-300 border-b-0 rounded-t text-[#666666] bg-white',
                inactiveClasses: 'text-[#666666]'
            }" class="p-6">
                <ul class="flex border-b px-[15px] pt-[3px]">
                    <li @click="openTab = 1" :class="{ '': openTab === 1 }" class="-mb-px ">
                        <a href="#" :class="openTab === 1 ? activeClasses : inactiveClasses"
                            class="inline-block text-xs py-[7px] px-[15px] mt-[2px] font-bold">
                            Overview
                        </a>
                    </li>
                    <li @click="openTab = 2" :class="{ '': openTab === 2 }" class="-mb-px">
                        <!-- Set active class by using :class provided by Alpine -->
                        <a href="#" :class="openTab === 2 ? activeClasses : inactiveClasses"
                            class="inline-block text-xs py-[7px] px-[15px] mt-[2px] font-bold">
                            Rapid Sale
                        </a>
                    </li>
                </ul>
                <div class="w-full bg-white h-full">
                    <div x-show="openTab === 1">

                        <div class="grid-cols-2 grid p-[15px] gap-[38px]">
                            <div class="grid grid-cols-4 gap-[10px]">
                                <div class="shadow-xl col-span-2 h-[101px] bg-[#7556D6] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">0</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-home" style="background-position: -5px -7px;"></i>
                                            <span class="text-sm icons-text">Stock</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl col-span-2 h-[101px] bg-[#7F3979] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-shop-cart "
                                                style="background-position: -43px -7px;"></i>
                                            <span class="text-sm icons-text">Total</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#3FA0EC] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-cart "
                                                style="width: 30px;background-position: -76px -8px;"></i>
                                            <span class="text-sm icons-text">Online</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#1B9CB2] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-cart-gray "
                                                style="width: 30px;background-position: -111px -8px;"></i>
                                            <span class="text-sm icons-text">Offline</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#31aa2d] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center leading-none"
                                            style="margin-top: 10px !important">
                                            <i class="icon icon-hourglass"
                                                style="width:30px;background-position: -148px -8px;">
                                            </i>
                                            <span class="text-sm icons-text ml-1" style="">Expiring Soon</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#2F5998] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-history " style="background-position: -184px -8px;"></i>
                                            <span class="text-sm icons-text">Expired</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#3b9f3d] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center flex gap-1 items-center"
                                            style="margin-top: 7px !important">
                                            <i class="icon icon-magic flex-none"
                                                style="background-position: -224px -8px;"></i>
                                            <span class="text-sm icons-text">Activated</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#2f61ad] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-target "
                                                style="background-position: -256px -7px;"></i>
                                            <span class="text-sm icons-text">Inactive</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#e96343] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-warning "
                                                style="background-position: -294px -7px;"></i>
                                            <span class="text-sm icons-text leading-none">Alerting Devices</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#2f9bf2] py-[15px]">
                                    <a class="" href="">
                                        <p class="text-center num num-box">2</p>
                                        <div class="icons-text-box text-center" style="margin-top: 7px !important">
                                            <i class="icon icon-heart" style="background-position: -328px -7px;"></i>
                                            <span class="text-sm icons-text">Following</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-[10px]">
                                <div class="shadow-xl h-[101px] bg-[#01AFF0] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-monitor"></i>
                                        <span
                                            class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>Monitor</b></span>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] col-span-2 bg-[#3E5C8A] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-signal"></i>
                                        <span
                                            class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>Report</b></span>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#0086D0] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-enclosure"></i>
                                        <span class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>Geo
                                                Fence</b></span>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#7F3979] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-face-set"></i>
                                        <span
                                            class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>Account</b></span>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#008299] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-router"></i>
                                        <span class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>Device
                                                Management</b></span>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#2770ec] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-note"></i>
                                        <span
                                            class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>Command</b></span>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#0F7B11] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-flag"></i>
                                        <span
                                            class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>POI</b></span>
                                    </a>
                                </div>
                                <div class="shadow-xl h-[101px] bg-[#A34A42] pt-[15px] relative">
                                    <a class="grid" href="/consoleNew" target="_blank">
                                        <i class="icon icon-bell-set"></i>
                                        <span
                                            class="absolute bottom-[5px] left-[10px] text-white text-sm"><b>Alerts</b></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div x-show="openTab === 2">Tab #2</div>
                </div>
            </div>

        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="messages" role="tabpanel"
            aria-labelledby="messages-tab">
            ms
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="va" role="tabpanel"
            aria-labelledby="va-tab">
            va
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<script>
    // var ajax = function(method, url, callback) {
    //     var xhr = new XMLHttpRequest();
    //     xhr.withCredentials = true;
    //     xhr.open(method, url, true);
    //     xhr.onreadystatechange = function() {
    //         if (xhr.readyState == 4) {
    //             callback(JSON.parse(xhr.responseText));
    //         }
    //     };
    //     if (method == 'POST') {
    //         xhr.setRequestHeader('Content-type', 'application/json');
    //     }
    //     xhr.send()
    // };
    // ajax('GET', 'api/session', function(session) {
    //     console.log(session);
    //     var socket = new WebSocket("wss://traccar.sentralgps.com/api/socket");

    //     socket.addEventListener("open", function(event) {
    //         console.log("WebSocket connection opened:", event);
    //     });
    // });

    // $.ajax({
    //     url: "https://traccar.sentralgps.com/api/session",
    //     type: "POST",
    //     data: {
    //         email: "admin",
    //         password: "admin"
    //     },
    //     dataType: "json",
    //     success: function(data, textStatus, jqXHR) {
    //         console.log(jqXHR);
    //         // Perintah berhasil
    //         // Cookies dapat diakses melalui jqXHR.getResponseHeader('Set-Cookie')
    //         var cookies = jqXHR.getResponseHeader('Set-Cookie');
    //         console.log("Cookies received:", cookies);
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //         // Penanganan kesalahan
    //         console.error("Request failed with status:", jqXHR.status);
    //     }
    // });
    // success: function(sessionResponse) {
    //         console.log(sessionResponse);
    //         var socket = new WebSocket("wss://traccar.sentralgps.com/api/socket");

    //         socket.addEventListener("open", function(event) {
    //             console.log("WebSocket connection opened:", event);
    //         });
    //     },
    //     error: function(error) {
    //         console.error("Failed to authenticate:", error);
    //     }
    // });
</script>
<?php /**PATH C:\xampp\htdocs\traccar\traccar_breeze\resources\views/dashboard.blade.php ENDPATH**/ ?>