<div id="addDevice" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white  shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b rounded-t pl-5 pr-2">
                <h3 class="text-sm text-gray-900 leading-10 ">
                    Add Devices
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center  "
                    data-modal-hide="addDevice">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('device.store') }}" method="post">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div class="flex items-center gap-5">
                        <div class="flex justify-between">
                            <label for="model" class="w-32 text-sm text-end">Model : <span
                                    class="text-red-500">*</span></label>
                        </div>
                        <select name="model" id="model" class="modelJson js-example-basic-single"
                            style="width: 100%;font-size: 12px">
                            <option disabled selected> Please Select</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-5">
                        <div class="flex justify-between">
                            <label for="user" class="w-32 text-sm text-end">To Account : <span
                                    class="text-red-500">*</span></label>
                        </div>

                        <div class="w-full relative">
                            <input class="opacity-0 absolute z-0" name="user" id="userInput" type="text" required>
                            <button type="button"
                                class="w-full h-[28px] text-xs border border-gray-800 text-start line-clamp-1 px-2 relative z-10"
                                id="dropdownDefaultButton" data-dropdown-toggle="dropdown">
                            </button>

                            <div id="dropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute">
                                <div id="accordion-collapse" data-accordion="collapse" class="px-[15px] py-[10px]">
                                    <h2 id="accordion-collapse-heading-user-1" class="flex gap-1">
                                        <div>
                                            <button type="button"
                                                class="flex gap-1 items-center bg-white dark:bg-white text-black w-full font-medium text-left border-none focus:ring-0 hover:bg-gray-100"
                                                data-accordion-target="#accordion-collapse-body-user-1"
                                                aria-expanded="true" aria-controls="accordion-collapse-body-user-1">
                                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0 fill-black"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 10 6">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="userItem cursor-pointer" data-id="{{ $session->id }}"
                                            data-name="{{ $session->name }}">
                                            <div>
                                                <div class="flex gap-[5px]" style="padding: 0 3px 0 0">
                                                    <i class="tree-icon user_admin_ico_open w-[16px] h-[16px]"
                                                        style="background-position: 0 -307px;"></i>
                                                    <p class="text-[12px] text-black">{{ $session->name }}(0/0)
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </h2>
                                    <div id="accordion-collapse-body-user-1" class="hidden"
                                        aria-labelledby="accordion-collapse-heading-user-1">
                                        @foreach ($users as $user)
                                            <div class="flex userItem cursor-pointer" style="padding: 10px 0 0 22px"
                                                data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                <div>
                                                    <div class="flex gap-[5px]" style="padding: 0 3px 0 0">
                                                        <i class="tree-icon user_admin_ico_open w-[16px] h-[16px]"
                                                            style="background-position: 0 -307px;"></i>
                                                        <p class="text-[12px]">{{ $user->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-5">
                        <div class="flex justify-between self-start">
                            <label for="imei" class="w-32 text-sm text-end">IMEI : <span
                                    class="text-red-500">*</span></label>
                        </div>
                        <textarea name="imei" id="" rows="5" class="w-full" required></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="submit"
                            class="bg-[#2e8ded] text-white px-[15px] text-sm rounded-sm leading-[28px]">
                            Save
                        </button>
                        <button type="button" data-modal-hide="addDevice"
                            class="bg-[#f1f1f1] text-black px-[15px] text-sm rounded-sm leading-[28px]">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    fetch('/api/modeljson/')
        .then(response => response.json())
        .then(data => {
            const selectElement = document.querySelector('.modelJson');

            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.name;
                option.text = item.name;
                selectElement.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
</script>

<script>
    const userItems = document.querySelectorAll('.userItem');

    userItems.forEach(item => {
        item.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const userName = this.getAttribute('data-name');
            const button = document.getElementById('dropdownDefaultButton');
            button.textContent = userName;
            document.getElementById('userInput').value = userId;
            button.click();
        });
    });
</script>
