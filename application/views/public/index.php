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
<input type="submit" name="submit" id="name" value="student/name" onclick="user_name();"></br>
<input type="submit" name="submit" id="sites" value="student/sites" onclick="sites();">Active Sites</br>
<input type="submit" name="submit" id="id" value="student/id" onclick="user_id();"></br>
<input type="submit" name="submit" id="grade" value="grade/site" onclick="grade('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="grade_all" value="grade/all" onclick="grade_all();">Grades for All Active Sites</br>
<input type="submit" name="submit" id="gallery" value="gallery/dir" onclick="gallery();"></br>
<input type="submit" name="submit" id="upload" value="gallery/upload" onclick="upload();"></br>
<input type="submit" name="submit" id="role" value="role/site" onclick="role('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="roster" value="role/roster" onclick="roster('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="announcement_all" value="announce/all" onclick="announcement_all();">Under My_WorkSpace</br>
<input type="submit" name="submit" id="announcement_site" value="announce/site" onclick="announcement_site('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="shumba_all" value="announce/shumba_all" onclick="shumba_all();">Announcements for All Active Sites</br>
<input type="submit" name="submit" id="resource" value="resource/site" onclick="resource('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
<input type="submit" name="submit" id="chat" value="chat/site" onclick="chat('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br></br>
<input type="submit" name="submit" id="test_t" value="test/t" onclick="test_t();"></br>
<input type="submit" name="submit" id="example" value="Parse JSON example" onclick="example();"><a href="https://gist.github.com/3720842">source code</a></br>
<!-- <input type="submit" name="submit" id="example_grade" value="Parse Grade example" onclick="grade_example('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');"><a href="https://gist.github.com/3720842">source</a></br>-->
<span style="color:green"></span>
<div id="results"></div>
<h3><a href="https://github.com/zuch/VulaMobi/wiki">documentation</a></h3>
<h2>Source Code</h2>
<ul>
    <li><h3><a href="./js/vulamobi.js">vulamobi.js</a>The Buttons in this page are using this file</h3></li>
    <li>HTML source for this <a href="https://github.com/zuch/VulaMobi/blob/master/application/views/public/index.php">page</a></li>
</ul>
</br>

