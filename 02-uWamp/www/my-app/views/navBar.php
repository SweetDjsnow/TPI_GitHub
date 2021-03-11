<nav>
   <div class="nav-bar-container">
    <a href="../controllers/disconnect.php"><button class="nav-disconnect-btn">Se déconnecter</button></a>
    <p class="nav-bar-username"><?php echo $_SESSION['useUsername']; ?></p>
    <div class="icons-container">
      <a href="../views/mainPage.php" ><img class="main-page-icon-nav" src="../img/home.png"></a>
      <a href="../views/searchPage.php" ><img class="search-page-icon-nav" src="../img/loupe.png"></a>
      <?php if(isset($_SESSION) && $_SESSION['useIsAdmin'] == 1){echo '<a href="../views/addPage.php" ><img class="add-page-icon-nav" src="../img/add.png"></a>';} ?>
    </div>
   </div>
</nav>
