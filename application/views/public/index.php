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
    <input type="submit" name="submit" id="login" value="login" onclick="login();" ></br>
    <input type="submit" name="submit" id="logout" value="logout" onclick="logout();">
</p>
</br>
<h2>AJAX Functions</h2>
<p>
    Test out the jQuery AJAX calls to the VulaMobi Backend hosted on nightmare
</p>
<input type="submit" name="submit" id="name" value="name" onclick="user_name();"></br>
<input type="submit" name="submit" id="sites" value="sites" onclick="sites();"></br>
<input type="submit" name="submit" id="id" value="id" onclick="user_id();"></br>
<input type="submit" name="submit" id="grade" value="grade" onclick="grade('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="gallery" value="gallery" onclick="gallery();"></br>
<input type="submit" name="submit" id="role" value="role" onclick="role('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="roster" value="roster" onclick="roster('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="test" value="test" onclick="test();"></br>
<!-- Logout -->
<h3>logout</h3>
<p>
    <b>URL: ajax.php?student/logout</br></b>
</p>
<!-- Username -->
<h3>name</h3>
<p>
    <b>URL: ajax.php?student/name</br></b>    
</p>
<!-- Sites -->
<h3>active sites</h3>
<p>
    <b>URL: ajax.php?student/sites</br></b>
</p>
<!-- User_id -->
<h3>id</h3>
<p>
    <b>URL: ajax.php?student/id</b></br>
</p>
<h3>grade/site</h3>
<p>
    <b>URL: ajax.php?grade/site/{site_id}</b></br>
</p>
<h3>gallery/dir</h3>
<p>
    <b>URL: ajax.php?gallery/dir</b></br>
</p>
<h3>role/site</h3>
<p>
    <b>URL: ajax.php?role/site/{site_id}</b></br>
</p>
<h3>role/roster</h3>
<p>
    <b>URL: ajax.php?role/roster/{site_id}</b></br>
<h3>test</h3>
<p>
    <b>URL: ajax.php?test/t</b></br>
</p>
<h4><a href="https://github.com/zuch/VulaMobi/wiki">documentation</a></h4>
<h2>Source Code</h2>
<ul>
    <li><h3><a href="./js/vulamobi.js">vulamobi.js</a></h3></li>
    <li>HTML source for this <a href="https://github.com/zuch/VulaMobi/blob/master/application/views/public/index.php">page</a></li>
</ul>
</br>

