<div class="light-blue">
    <div class="container section">
        <a href="#" data-target="menu-side" class="sidenav-trigger">
            <i class="material-icons white-text">menu</i>
        </a>
        <ul class="sidenav" id="menu-side">
            <li>
                <div class="user-view" height="auto">
                    <div class="background">
                        <img src="./s1.jpg" alt="">
                    </div>
                    <a href="#">
                        <img src="./profiles/<?= $_SESSION['pic'] ?>.png" class="circle" alt="">
                    </a>
                    <a href="#">
                        <h4 class="name white-text"><?= $name ?>&nbsp;<?= $last; ?></h4>
                    </a>
                    <a href="#">
                        <span class="email white-text"><?= $email ?></span>
                    </a>
                </div>
            </li>
            <li>
                <a href="dashboard.php"><i class="material-icons">home</i> Home</a>
            </li>
            <li>
                <a href="#"><i class="material-icons">person</i> Profile</a>
            </li>
            <li>
                <a href="#"><i class="material-icons">note</i> Notes</a>
            </li>
            <li>
                <a href="#"><i class="material-icons">notifications</i> Notifications</a>
            </li>
            <li>
                <a href="#"><i class="material-icons">build</i> Configuration</a>
            </li>
            <li>
                <div class="divider"></div>
            </li>
            <li>
                <a href="logout.php"><i class="material-icons">close</i> Log out</a>
            </li>
        </ul>
    </div>
</div>