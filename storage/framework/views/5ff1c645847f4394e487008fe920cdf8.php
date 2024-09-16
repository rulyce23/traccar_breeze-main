<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
        <form action="<?php echo e(route('login.store')); ?>" method="POST">
            <div class="pt-5">
                <img src="<?php echo e(asset('storage/images/logo/logo.png')); ?>" class="object-contain w-full" alt="">
            </div>
            <?php echo csrf_field(); ?>
            <div class="mb-5">
                <div class="relative">
                    <input type="text" class="w-full pl-[52px] h-[50px]" name="email"
                        style="font-size: 20px !important; line-height: 38px !important" required placeholder="Account">
                    <div class="absolute top-0 left-0 w-[52px] h-[50px]">
                        <img src="<?php echo e(asset('storage/icon/user.svg')); ?>" class="w-full object-scale-down" alt="">
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <div class="relative">
                    <input type="password" class="w-full pl-[52px] h-[50px]" name="password"
                        style="font-size: 20px !important; line-height: 38px !important" required
                        placeholder="Password">
                    <div class="absolute top-0 left-0 w-[52px] h-[50px]">
                        <img src="<?php echo e(asset('storage/icon/password.svg')); ?>" class="w-full object-scale-down"
                            alt="">
                    </div>
                </div>
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
                <a href="#"><img src="<?php echo e(asset('storage/images/login/Apple-down.jpg')); ?>" /></a>
            </div>
            <div>
                <a href="#"><img src="<?php echo e(asset('storage/images/login/Android-down.png')); ?>" /></a>
            </div>
        </div>
        <div class="fixed bottom-3 w-full flex justify-center text-sm gap-1">
            <a href="" class="text-white">Term Of Service</a>
            <b class="text-white">|</b>
            <a href="" class="text-white">Privacy Policy</a>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\traccar\traccar_breeze\resources\views/auth/login.blade.php ENDPATH**/ ?>