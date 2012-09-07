<body>
<h1>VulaMobi Backend API</h1>
<p>
    <label for="username">Username</label>
    </br>
    <input type="text" id="username" name="username"></input>
</p>
<p>
    <label for="password">Password</label>
    </br>
    <input type="password" id="password" name="password"></input>
</p>
<p>
    <input type="submit" name="submit" id="login" value="Login" onclick="login()" >
</p>
</br>
<h3>AJAX Functions</h3>
<p>
    Test out the jQuery AJAX calls to the VulaMobi Backend hosted on nightmare
</p>
<p>
    <input type="submit" name="submit" id="logout" value="Logout" onclick="logout()">
</p>
<p>
    <input type="submit" name="submit" id="name" value="Name" onclick="username();">
</p>
<p>
    <!-- site_id for CS Honours 2012 -->
    <input type="submit" name="submit" id="sites" value="Sites" onclick="sites('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">
</p>
<p>
    <!-- site_id for CS Honours 2012 -->
    <input type="submit" name="submit" id="grade" value="Grade" onclick="grade('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">
</p>
<p>
<p>
    <!-- site_id for CS Honours 2012 -->
    <input type="submit" name="submit" id="id" value="id" onclick="user_id();">
</p>
<p>
    <!-- site_id for CS Honours 2012 -->
    <input type="submit" name="submit" id="gallery" value="gallery" onclick="gallery();">
</p>
<br>
<h3>Source Code</h3>
<ul>
    <li>Client-side javasript used to interact with the VulaMobi Backend: <a href="./js/vulamobi.js">vulamobi.js</a> (Coz Im that nice)</li>
    <li>HTML source for this <a href="https://github.com/zuch/VulaMobi/blob/master/application/views/public/index.php">page</a></li>
</ul>
</br>

