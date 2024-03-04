<!-- Header.php -->
<?php
    //session_start();



?>
<nav class='header flex space-between align-center'>

    <img src='../images/to-do-list-64.png' alt='todo'/>
    <!-- Right side of nav -->
    <!-- Desktop view -->
    <div class="desktop">

        <div class="flex align-center">
            <h5 class='mar-right-32'>

                <a href="../index.html">
                    Home Page
                </a>
            </h5>
            <h5 class='mar-right-32'>

                <a href="../pages/tasks.php">
                    My Tasks
                </a>
            </h5>

            <div class="default-btn">
                <h5>
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo " <a href='../pages/logout.php'>
                        SIGN OUT
                </a>";
                    } else {

                        echo " <a href='../pages/login.php'>
                        LOG IN
                </a>";
                    }
                    ?>

                </h5>
            </div>
        </div>

    </div>
    <!-- End of desktop view -->

    <!-- Mobile view -->
    <div class="mobile">
        <div class="mobile-nav">
            <div class="hamburger-icon">
                <img src="../images/icons/menu.svg" alt="menu">
            </div>
            <div class="nav-links">
                <h5 class = 'mar-bottom-8'>

                    <a href="../index.html">
                        Home Page
                    </a>
                </h5>
                <h5 class = 'mar-bottom-8'>

                    <a href="../pages/tasks.php">
                        My Tasks
                    </a>
                </h5>
                <div class="default-btn">
                    <h5>
                        <?php
                        if (isset($_SESSION['email'])) {
                            echo " <a href='../pages/logout.php'>
                        SIGN OUT
                </a>";
                        } else {

                            echo " <a href='../pages/login.php'>
                        LOG IN
                </a>";
                        }
                        ?>

                    </h5>
                </div>
            </div>

        </div>

    </div>
    <!-- End of mobile view -->
    <!-- End of right side of nav-->
    <script>
        let mobileVisible = false;
        const mobileNav = document.getElementById('mobile-nav');
        const mobileNavLinks = document.querySelector('.mobile-nav .nav-links');
        const menuIcon = document.querySelector(".hamburger-icon");

        // used to hide or show mobile nav based on visible state
        const toggleMobileNav = () => {

            // toggle visibility
            mobileVisible = !mobileVisible;

            // show the nav if it's visible
            if(mobileVisible) {
                mobileNavLinks.classList.add('show-nav');
                // hide the nav if it's not visible
            } else {
                mobileNavLinks.classList.remove('show-nav');
            }

        }

        // toggle the mobile menu on menu click
        menuIcon.addEventListener('click', toggleMobileNav);
    </script>
</nav>