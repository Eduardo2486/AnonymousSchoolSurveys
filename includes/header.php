<div class="top-bar" id="realEstateMenu">
    <div class="top-bar-left">
    <ul class="menu">
        <li><a href="<?php echo "home.php";  ?>">Results</a></li>
        <?php
            if(isset($_SESSION['name'])){
                if($_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'superadmin'){
                    echo '<li><a href="tests.php">Tests</a></li>';
                }
            }
        ?>

        <li><a href="<?php echo "questionnaires.php";  ?>">Questionnaires</a></li>
        <li><a href="<?php echo "teachers.php";  ?>">Teachers</a></li>
        
        <li><a href="<?php echo "partials.php";  ?>">Partials</a></li>
        <li><a href="<?php echo "subjects.php";  ?>">Subjects</a></li>
        <?php
            if(isset($_SESSION['name'])){
                if($_SESSION['rol'] == 'admin' OR $_SESSION['rol'] == 'superadmin'){
                    echo '<li><a href="users.php">Users</a></li>';
                }
            }
        ?>

    </ul>
    </div>
    <div class="top-bar-right">
    <ul class="menu">
    <?php
        if(isset( $_SESSION['name'])){
            echo "<li><a href='user.php'>". $_SESSION['name']. "</a></li>";
            echo "<li><a href='logout.php'>Log out</a></li>";
        }
    ?>
    </ul>
    </div>
   
</div>