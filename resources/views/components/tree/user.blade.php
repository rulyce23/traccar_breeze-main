<div id="accordion-collapse" data-accordion="collapse" class="px-[15px] py-[10px]">
    <h2 id="accordion-collapse-heading-1">
        <button type="button"
            class="flex gap-1 items-center dark:bg-white bg-white dark:text-black text-black w-full font-medium text-left border-none focus:ring-0 dark:focus:ring-0 dark:border-none  hover:bg-gray-100 dark:hover:bg-white"
            data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
            aria-controls="accordion-collapse-body-1">
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5 5 1 1 5" />
            </svg>
            <div>
                <input type="radio" data-id="{{ $session->id }}" class="hidden" name="user_radio" checked
                    id="user-{{ $session->id }}" data-name="{{ $session->name }}">
                <label for="user-{{ $session->id }}">
                    <div class="flex gap-[5px]" style="padding: 0 3px 0 0">
                        <i class="tree-icon user_admin_ico_open w-[16px] h-[16px]"
                            style="background-position: 0 -307px;"></i>
                        <p class="text-[12px] text-black">{{ $session->name }}(0/0)
                        </p>
                    </div>
                </label>
            </div>
        </button>
    </h2>
    <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
        @foreach ($users as $user)
            <div class="flex" style="padding: 10px 0 0 22px">
                <input type="radio" class="hidden" name="user_radio" data-id="{{ $user->id }}"
                    id="user-{{ $user->id }}" data-name="{{ $user->name }}">
                <label for="user-{{ $user->id }}">
                    <div class="flex gap-[5px]" style="padding: 0 3px 0 0">
                        <i class="tree-icon user_admin_ico_open w-[16px] h-[16px]"
                            style="background-position: 0 -307px;"></i>
                        <p class="text-[12px]">{{ $user->name }}
                        </p>
                    </div>
                </label>
            </div>
        @endforeach
    </div>
</div>
