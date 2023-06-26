<?php
require base_path("views/partials/header.php");
require base_path("views/partials/nav.php");
require base_path("views/partials/banner.php");
?>
<main>
  <div class="mt-3 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
    <p><a href='/notes' class="text-blue-500 underline">Return to notes...</a></p>
    <p class="mt-6"><?= htmlspecialchars($note['body']) ?></p>
    <form class="mt-6" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $note['id']?>">
        <button class="text-sm text-red-500">Delete</button>
    </form>
  <div>
</main>
</div>

<?php
require base_path("views/partials/footer.php");
?>
