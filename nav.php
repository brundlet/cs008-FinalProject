<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        
        print '<li class="';
        if ($path_parts['filename'] == "index") {
            print ' activePage ';
        }
        print '">';
        print '<a href="index.php">Home</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "form") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form.php">Join</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "news") {
            print ' activePage ';
        }
        print '">';
        print '<a href="news.php">Identity Theft News</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "happens") {
            print ' activePage ';
        }
        print '">';
        print '<a href="happens.php">Dangers</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "todo") {
            print ' activePage ';
        }
        print '">';
        print '<a href="todo.php">What To Do</a>';
        print '</li>';
        
        ?>
    </ol>
</nav>
