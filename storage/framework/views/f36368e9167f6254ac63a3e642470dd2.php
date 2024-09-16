<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Stargps')); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('storage/font-awesome/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dist/css/icon.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dist/css/icon.css')); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gokertanrisever/leaflet-ruler@master/src/leaflet-ruler.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
        rel='stylesheet' />

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class=" antialiased">
    <style>
        @import url('https://fonts.cdnfonts.com/css/helvetica-neue-55');
        @import url('https://fonts.cdnfonts.com/css/tahoma');

        @font-face {
            font-family: 'icomoon';
            src: url('<?php echo e(asset('storage/icomoon/icomoon.eot?nf1pj')); ?>');
            src: url('<?php echo e(asset('storage/icomoon/icomoon.eot?nf1pj#iefix')); ?>') format('embedded-opentype'),
                url('<?php echo e(asset('storage/icomoon/icomoon.ttf?nf1pj')); ?>') format('truetype'),
                url('<?php echo e(asset('storage/icomoon/icomoon.woff?nf1pj')); ?>') format('woff'),
                url('<?php echo e(asset('storage/icomoon/icomoon.svg?nf1pj#icomoon')); ?>') format('svg');
            font-weight: normal;
            font-style: normal;
        }


        body {

            font-family: sans-serif;
        }
    </style>
    <div class="min-h-screen bg-gray-100 h-full w-full">
        <div class="flex h-full min-h-screen">
            <aside class=" z-10 w-[260px] h-auto flex-none bg-white" aria-label="Sidebar">
                <div class="h-[60px] w-full bg-[#0087d6]">
                    <div class="h-full flex items-center pl-4">
                        <img src="<?php echo e(asset('storage/images/logo/logo.png')); ?>" class=""
                            style="height: 50px; filter: brightness(0) invert(1);">
                    </div>
                </div>
                <?php if(request()->is('monitor')): ?>
                <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(request()->is('device')): ?>
                <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(request()->is('account')): ?>
                <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </aside>
            <div class="flex-auto">
                <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo e($slot); ?>

            </div>
        </div>
        <main>

        </main>
    </div>
    <script>

            // Ambil data dari sesi Laravel
        const userEmail = '<?php echo e(session('email')); ?>';
        const userName = '<?php echo e(session('name')); ?>';
        const userPassword = '<?php echo e(session('password')); ?>';
        const userToken = '<?php echo e(session('token')); ?>';


        // Simpan data pengguna ke localStorage
        function saveUserToLocalStorage(email, name,password,token) {
            localStorage.setItem('userEmail', email);
            localStorage.setItem('userName', name);
            localStorage.setItem('userPassword', password);
            localStorage.setItem('userToken', token);

        }



        // Simpan data ke localStorage jika tersedia
        if (userEmail && userName && userPassword && userToken) {
            saveUserToLocalStorage(userEmail, userName, userPassword, userToken);
        }

        // Contoh: Menampilkan data yang disimpan di localStorage
        console.log('User Email:', localStorage.getItem('userEmail'));
        console.log('User Name:', localStorage.getItem('userName'));
        console.log('User Password:', localStorage.getItem('userPassword'));
        console.log('User Token:', localStorage.getItem('userToken'));

    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gokertanrisever/leaflet-ruler@master/src/leaflet-ruler.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-plugins/layer/tile/Google.js"></script>
    <script src="https://unpkg.com/esri-leaflet@3.0.10/dist/esri-leaflet.js"></script>
    <script src="https://unpkg.com/esri-leaflet-vector@4.1.0/dist/esri-leaflet-vector.js"></script>
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"
        integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    </body>
</html>
<?php /**PATH C:\xampp\htdocs\traccar_breeze-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>