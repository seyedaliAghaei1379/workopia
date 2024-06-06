<?=
loadPartial("head");
loadPartial("navbar");
loadPartial("showcase-search");

?>

<?php
//inspect($listings);
?>


<!-- Job Listings -->
<section>
    <div class="container mx-auto p-4 mt-4">
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">کتاب های اخیر</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <?php foreach ($listings as $listing) :?>
            <div class="rounded-lg shadow-md bg-white" dir="rtl">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">
                        نام کتاب :
                        <?= $listing->title ?></h2>
                    <p class="text-gray-700 text-lg mt-2 mb-2">
                        توضیحات :
                        <?= $listing->description ?>
                    </p>

                    <a href="/listings/<?= $listing->id ?>"
                       class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
                    >
                        دیدن جزئیات
                    </a>
                </div>
            </div>
            <?php endforeach; ?>


        </div>
        <a href="/listings" class="block text-xl text-center" dir="rtl">
            <i class="fa fa-arrow-alt-circle-right"></i>
            همه ی کتاب ها
        </a>
</section>

<?php

loadPartial('bottom-banner');
loadPartial('footer');

?>
