<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        
        print '<li class="';
        if ($path_parts['filename'] == "index") {
            print ' activePage ';
        }
        print '">';
        print '<a href="index.php">HOME</a>';
        print '</li>';
        
       
        
        print '<li class="';
        if ($path_parts['filename'] == "news") {
            print ' activePage ';
        }
        print '">';
        print '<a href="news.php">IDENTITY THEFT NEWS</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "happens") {
            print ' activePage ';
        }
        print '">';
        print '<a href="happens.php">DANGERS</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "todo") {
            print ' activePage ';
        }
        print '">';
        print '<a href="todo.php">WHAT TO DO</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "form") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form.php">JOIN</a>';
        print '</li>';
        
         print '<li class="';
        if ($path_parts['filename'] == "faq") {
            print ' activePage ';
        }
        print '">';
        print '<a href="faq.php">FAQ</a>';
        print '</li>';
        
        ?>
    </ol>
</nav>
