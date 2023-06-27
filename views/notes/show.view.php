<?php
require base_path("views/partials/header.php");
require base_path("views/partials/nav.php");
require base_path("views/partials/banner.php");
?>
<main>
  <div class="mt-3 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
    <p><a href='/notes' class="text-blue-500 underline">Return to notes...</a></p>
    <p class="mt-6"><?= htmlspecialchars($note['body']) ?></p>


    <footer class="mt-6">
    <a href="/note/edit?id=<?= $note['id'] ?>" class="rounded-md bg-gray-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Edit</a>
    </footer>

<!-- Form for the delete button-->
<!--    <form class="mt-6" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $note['id']?>">
        <button class="text-sm text-red-500">Delete</button>
    </form>
-->
  <div>
</main>
</div>

<?php
require base_path("views/partials/footer.php");
?>
