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
    <input type="submit" name="submit" id="logout" value="Logout" onclick="logout()" `>
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
<pre>
http://localhost/VulaMobi/ajax.php?student/grade/a02e13fc-ba96-433e-86b0-3269c3287ea0/1
</pre>
