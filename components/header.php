<div class="nav-header">
    <div class="brand-logo">
        <a href="/">
            <b class="logo-abbr"><img src="/assets/images/logo.png" alt="logo"> </b>
            <span class="logo-compact"><img src="/assets/images/logo-compact.png" alt="logo"></span>
            <span class="brand-title">
                <img src="/assets/images/logo-text.png" alt="logo">
            </span>
        </a>
    </div>
</div>
<div class="header">
    <div class="header-content clearfix">
        <div class="header-right">
            <ul class="clearfix">
                <?php if (isset($_SESSION['loggedin'])) : ?>
                    <li class="icons dropdown">
                        <h5>
                            <span class="text-dark">User: </span>
                            <span class="text-primary">
                                <?php echo $_SESSION['username'] ?>&nbsp;<?php echo $_SESSION['pName'] ?>
                            </span>
                        </h5>
                    </li>
                    <li class="icons dropdown">
                        <a href="/login.php" class="btn btn-rounded btn-primary text-white px-3 py-2">Manage Documents</a>
                    </li>
                    <li class="icons dropdown">
                        <a href="/logout.php" class="btn btn-rounded btn-danger text-white px-3 py-2">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="icons dropdown">
                        <a href="/login.php" class="btn btn-rounded btn-primary text-white px-3 py-2">
                            <i class="fa fa-sign-in mr-1 text-white" aria-hidden="true"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>