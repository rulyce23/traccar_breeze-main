<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.cdnfonts.com/css/arial-2" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
    </style>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="text-gray-900 antialiased">
    <div class="h-screen">
        <img src="<?php echo e(asset('storage/images/login/bg-logins.jpg')); ?>" class="object-fit h-screen w-full"
            style="background-repeat: no-repeat;
            background-position: center top;
            background-size: 100% 100%;"
            alt="">
        <div
            style="content: ''; position: fixed; left: 0; top: 0; width: 100%; height: 100%;
                background-color: rgba(0,0,0,.7);">
        </div>
        <?php echo e($slot); ?>

    </div>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\traccar\traccar_breeze\resources\views/layouts/guest.blade.php ENDPATH**/ ?>