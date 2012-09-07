<body>
<h1>VulaMobi Backend API</h1>
<p>
    <label for="username"><b>Username</b></label>
    </br>
    <input type="text" id="username" name="username"></input>
</p>
<p>
    <label for="password"><b>Password</b></label>
    </br>
    <input type="password" id="password" name="password"></input>
</p>
<p>
    <input type="submit" name="submit" id="login" value="login" onclick="login()" ><pre><a href="ajax.php?auth/login">link</a></pre>
</p>
</br>
<h2>AJAX Functions</h2>
<p>
    Test out the jQuery AJAX calls to the VulaMobi Backend hosted on nightmare
</p>
<p>
    <input type="submit" name="submit" id="logout" value="logout" onclick="logout()"><pre><a href="ajax.php?auth/logout">link</a></pre>
</p>
<p>
    <input type="submit" name="submit" id="name" value="name" onclick="username();"><pre><a href="ajax.php?student/name">link</a></pre>
</p>
<p>
    <!-- site_id for CS Honours 2012 -->
    <input type="submit" name="submit" id="sites" value="sites" onclick="sites();"><pre><a href="ajax.php?student/sites">link</a></pre>
</p>
<p>
    <input type="submit" name="submit" id="id" value="id" onclick="user_id();"><pre><a href="ajax.php?student/id">link</a></pre>
</p>
<p>
    <!-- site_id for CS Honours 2012 -->
    <input type="submit" name="submit" id="grade" value="grade" onclick="grade('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');"> <b>CS Honours 2012</b><pre><a href="ajax.php?grade/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d">link</a></pre>
</p>
<p>
    <input type="submit" name="submit" id="gallery" value="gallery" onclick="gallery();"><pre><a href="ajax.php?gallery/dir">link</a></pre>
</p>
<p>
    <!-- site_id for CS Honours 2012 -->
    <input type="submit" name="submit" id="role" value="role" onclick="role('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');"><b>CS Honours 2012</b><pre><a href="ajax.php?role/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d">link</a></pre>
</p>
<p>
    <input type="submit" name="submit" id="roster" value="roster" onclick="roster('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');"><b>CS Honours 2012</b><pre><a href="ajax.php?role/roster/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d">link</a></pre>
</p>
<h4><a href="https://github.com/zuch/VulaMobi/wiki">documentation</a></h4>
<h2>Source Code</h2>
<ul>
    <li>Client-side javasript used to interact with the VulaMobi Backend: <a href="./js/vulamobi.js">vulamobi.js</a> (Coz Im that nice)</li>
    <li>HTML source for this <a href="https://github.com/zuch/VulaMobi/blob/master/application/views/public/index.php">page</a></li>
</ul>
</br>

