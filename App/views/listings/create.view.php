<?=
loadPartial("head");
loadPartial("navbar");
loadPartial("top-banner");
?>

<!-- Post a Job Form Box -->
<section class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">افزودن کتاب جدید</h2>
        <!-- <div class="message bg-red-100 p-3 my-3">This is an error message.</div>
        <div class="message bg-green-100 p-3 my-3">
          This is a success message.
        </div> -->
        <form method="POST" action="/listings" dir="rtl">
            <?php
            loadPartial('errors' , [
                    'errors' => $errors ?? []
            ]);
            ?>

            <div class="mb-4">
                <input
                    type="text"
                    name="title"
                    placeholder="عنوان کتاب"
                    class="w-full px-4 py-2 border rounded focus:outline-none"
                    value="<?= $listing['title'] ?? "" ?>"
                />
            </div>
            <div class="mb-4">
            <textarea
                name="description"
                placeholder="توضیحات کتاب"
                class="w-full px-4 py-2 border rounded focus:outline-none"><?= $listing['description'] ?? "" ?></textarea>
            </div>
            <div class="mb-4">
                <input
                        type="number"
                        name="count"
                        placeholder="تعداد"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= $listing['title'] ?? "" ?>"
                />
            </div>

            <button
                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
            >
                Save
            </button>
            <a
                href="/"
                class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none"
            >
                Cancel
            </a>
        </form>
    </div>
</section>

<?=
loadPartial('bottom-banner');
loadPartial('footer');
?>

