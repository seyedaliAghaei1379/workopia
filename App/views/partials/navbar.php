<?php

use Framework\Session;
?>

<!-- Nav -->
<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="/">رزرو کتاب</a>
        </h1>
        <nav class="space-x-4">
            <?php if(Session::has('user')) : ?>
            <div class="flex justify-between gap-4 items-center">
                <span>خوش آمدید <?= Session::get('user')['name']  ?></span>
                <form method="POST" action="/auth/logout">
                <button type="submit">خروج از حساب</button>
                </form>
                <a
                        href="/listings/create"
                        class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"
                ><i class="fa fa-edit"></i> ثبت کتاب</a
                >

            </div>

            <?php else: ?>
                <a href="/auth/login" class="text-white hover:underline">ورود</a>
                <a href="/auth/register" class="text-white hover:underline">ثبت نام</a>
            <?php endif; ?>


        </nav>
    </div>
</header>