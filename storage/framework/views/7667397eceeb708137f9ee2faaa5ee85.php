<ul>
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <div class="user-details" data-user-id="<?php echo e($item->id); ?>">
            <?php
            echo $item->name;
            ?>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.user-details').each(function() {
            var userId = $(this).data('user-id');
            var userDetailsDiv = $(this);

            $.ajax({
                type: 'GET',
                url: `api/users/${userId}`,
                success: function(response) {
                    if (response.length > 0) {
                        userDetailsDiv.html(JSON.stringify(response));
                    }

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
<?php /**PATH C:\xampp\htdocs\traccar_breeze-main\resources\views/master/monitor/tree.blade.php ENDPATH**/ ?>