
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<x-guest-layout>
    <div class="w-[318px] fixed left-1/2 top-1/2 -ml-[159px] -mt-[185px] z-10">
        <span class="mappin">
            <i class="shenzhen"></i>
            <i class="beijing"></i>
            <i class="dubai"></i>
            <i class="canberra"></i>
            <i class="washington"></i>
            <i class="losangeles"></i>
            <i class="santiago"></i>
        </span>
        <form action="{{ route('login.store') }}" method="POST">
            <div class="pt-5">
                <img src="{{ asset('images/logo.png') }}" class="object-contain w-full" alt="">
            </div>
            @csrf
            <div class="mb-5">
                <div class="relative">
                    <input type="text" class="w-full pl-[52px] h-[50px]" name="email"
                        style="font-size: 20px !important; line-height: 38px !important" required placeholder="Account">
                    <div class="absolute top-0 left-0 w-[52px] h-[50px]">
                        <img src="{{ asset('storage/icon/user.svg') }}" class="w-full object-scale-down" alt="">
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <div class="relative">
                    <input type="password" class="w-full pl-[52px] h-[50px]" name="password"
                        style="font-size: 20px !important; line-height: 38px !important" required
                        placeholder="Password">
                    <div class="absolute top-0 left-0 w-[52px] h-[50px]">
                        <img src="{{ asset('storage/icon/password.svg') }}" class="w-full object-scale-down"
                            alt="">
                    </div>
                </div>
            </div>
            <div class="mb-5 flex items-center">
                <input type="checkbox" id="remember_me" name="remember" class="mr-2">
                <label for="remember_me" class="text-sm" style="color:white;">Remember Me</label>
            </div>
            <div class="bg-[#4d94dd] px-3 py-[6px] ">
                <button class=" w-full text-white text-center text-[20px] leading-[38px] border-none">
                    Login
                </button>
            </div>
        </form>
    </div>
    <div>
        <div style="position: fixed;top: 50%;right: 10px;margin-top: -105px;">
            <div style="margin-bottom: 10px;">
                <a href="#"><img src="{{ asset('storage/images/login/Apple-down.jpg') }}" /></a>
            </div>
            <div>
                <a href="#"><img src="{{ asset('storage/images/login/Android-down.png') }}" /></a>
            </div>
        </div>
        <div class="fixed bottom-3 w-full flex justify-center text-sm gap-1">
            <a href="" class="text-white">Term Of Service</a>
            <b class="text-white">|</b>
            <a href="" class="text-white">Privacy Policy</a>
        </div>
    </div>
</x-guest-layout>
