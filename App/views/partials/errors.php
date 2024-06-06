<?php if (isset($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
        <div class=" bg-red-100 my-3 py-4 px-3"><?= $error ?></div>
    <?php endforeach; endif; ?>