
<nav>
    <ul>
        <li class="nav-list-item">
            <a class="nav-item grayed" href="/">Todos</a>
        </li>
        <li class="nav-list-item">
            <a class="nav-item grayed" href="/?completed=1">Completed Todos</a>
        </li>
        <?php
            if($_SESSION['id'] && $_SESSION['username'] ){
                echo <<<_END
                    <li class="nav-list-item">
                        <a class="nav-item grayed" href="/logout">Logout</a>
                    </li>
                _END;
            }
        ?>
    </ul>
</nav>
