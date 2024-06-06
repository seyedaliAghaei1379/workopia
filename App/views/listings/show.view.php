<?=
loadPartial("head");
loadPartial("navbar");
?>

    <section class="bg-blue-900 text-white py-6 text-center">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold">
                <?= $listing->title ?></h2>
            </h2>
            <p class="text-lg mt-2">
                <?= $listing->description ?>
            </p>
        </div>
    </section>
    <section class="container mx-auto p-4 mt-4">
        <div class="rounded-lg shadow-md bg-white p-3">
            <div class="bg-red-100 text-center">
                <?php
                loadPartial('message');
                ?>
            </div>

            <div class="flex justify-between items-center">

                <a class="block p-4 text-blue-700" href="/listings">
                    <i class="fa fa-arrow-alt-circle-left"></i>
                    بازگشت به صفحه ی کتاب ها
                </a>

                <div class="flex space-x-4 ml-4">
                    <a href="/listings/edit/<?= $listing->id ?>"
                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
                    <!-- Delete Form -->
                    <form method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Delete
                        </button>
                    </form>
                    <!-- End Delete Form -->
                </div>
            </div>
            <div class="p-4">
                <h2 class="text-xl font-semibold"><?= $listing->title ?></h2>
                <p class="text-gray-700 text-lg mt-2">
                    <?= $listing->description ?>
                </p>
            </div>
        </div>
    </section>

    <section class="container mx-auto p-4">

        <?php
//            inspectAndDie($reserve);
            if($reserve){
        ?>

        <form action="/listings/reserved" method="post" class="w-full mb-4" dir="rtl"  >
            <input type="hidden" name="book_id" value="<?= $listing->id ?>">
            <input type="hidden" name="count" value="1">
            <input type="hidden" name="timeStart" value="<?= time() ?>">
            <select  name="timeEnd" style="width: 100%;padding: 1rem" class="w-full">
                <option value="1">1روز</option>
                <option value="2">2روز</option>
                <option value="3">3روز</option>
            </select>
<!--            <input type="hidden" name="" value="--><?php //= $listing-> ?><!--">-->
            <button class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium cursor-pointer text-indigo-700 bg-indigo-100 hover:bg-indigo-200">رزرو کتاب</button>

        </form>
                <?php }else {
                ?>
                <p class="bg-yellow-500 text-gray-700 text-center p-4">موجودی کتاب ها تمام شده است لطفا چند روز دیگر مشاهده نمائید</p>
                    <?php
            } ?>
    </section>

<?=
loadPartial('footer');
?>