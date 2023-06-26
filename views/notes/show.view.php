<?php
require base_path("views/partials/header.php");
require base_path("views/partials/nav.php");
require base_path("views/partials/banner.php");
?>

<main>
  <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
    <p><?= htmlspecialchars($note['body']) ?></p>
  </div>
  <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 bg-white">
    <p><a href='/notes' class="text-blue-500 underline">Return to notes.</a></p>
  </div>

</main>
</div>

<?php
require base_path("views/partials/footer.php");
?>
