<?php session_start(); ?>
<?php if(!isset($_SESSION['user_id'])): ?>
<?= 
'<nav class="navbar is-light" role="navigation" aria-label="main navigation">
<div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
    STIKY
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
    <span aria-hidden="true"></span>
    <span aria-hidden="true"></span>
    <span aria-hidden="true"></span>
    </a>
</div>

<div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
        <a class="navbar-item">
            Home
        </a>
    
        <a class="navbar-item">
            About us
        </a>
    </div>

    <div class="navbar-end">
        <div class="navbar-item">
            <div class="buttons">
            <a href="signup.php" class="button is-primary">
                Sign up
            </a>
            <a href="login.php" class="button is-dark">
                Log in
            </a>
            </div>
        </div>
    </div>
</div>
</nav>';
?>
<?php else: ?>
<?=
'
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
        STIKY
        </a>
    
        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
    </div>
    
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                Home
            </a>
        
            <a class="navbar-item">
                About us
            </a>
        </div>
    
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                <a class="button is-primary">
                    <strong>Sign up</strong>
                </a>
                <a class="button is-light">
                    Log in
                </a>
                </div>
            </div>
        </div>
    </div>
</nav>
'
?>
<?php endif; ?>