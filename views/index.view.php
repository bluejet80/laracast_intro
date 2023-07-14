<?php 
require "partials/header.php"; 
require "partials/nav.php"; 
require "partials/banner.php"; 
?>

  <main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <p>This is the Content for the Home Page</p>
      <p>Hello, <?= $_SESSION['user']['name']  ?? 'Guest' ?>. Welcome to the Site.</p>
      
    </div>
  </main>
</div>
    
<?php 
require "partials/footer.php";
?>
