<body>
    <div id="wrapper">
        <div id="status">
                <span id="msg"></span>
        </div>
        <div id="content">
            <div id="login">
                <h1 id="heading">VulaMobi API</h1>
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
                    <button type="button" onclick="login();">login</button> 
                    </br>
                    <button type="button" onclick="logout();">logout</button> 
                <h3><a href="https://github.com/zuch/VulaMobi/">documentation</a></h3>
                </p>
            </div>
            <div id="demo">

            </div>
            
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
            <input type="submit" name="submit" id="role" value="role/site" onclick="role('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
            <input type="submit" name="submit" id="roster" value="role/roster" onclick="roster('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
            <input type="submit" name="submit" id="announcement_site" value="announce/site" onclick="announcement_site('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
            <input type="submit" name="submit" id="announcement_body" value="announce/body" onclick="announcement_body('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d','3c40ff32-680f-42ee-8f34-fa5271e39c17');">CS Honours 2012 random announcement</br>
            <input type="submit" name="submit" id="announcement_all" value="announce/all" onclick="announcement_all();">Announcements for All Active Sites</br>
            <input type="submit" name="submit" id="resource" value="resource/site" onclick="resource('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
            <input type="submit" name="submit" id="resource" value="resource/page" onclick="page('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
            <input type="submit" name="submit" id="assign" value="assign/site" onclick="assign('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
            <input type="submit" name="submit" id="assign_all" value="assign/all" onclick="assign_all();">Assignments for All Active Sites</br>
            <input type="submit" name="submit" id="chat" value="chat/site" onclick="chat('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">CS Honours 2012</br>
            </br>
            <form name = "myform">
                <textarea name="msg"  rows="5" cols="25" id="msg">
                </textarea>
            </form>
            <input type="button" name="submit" id="chat" value="chat/submit" onclick="submit('43271a70-b78e-460b-a5b8-8356d0989a85');">Send a message to Major Projects</br>

            <h2>Test</h2>
            <input type="submit" name="submit" id="test_t" value="test/t" onclick="test_t();"></br>
            <input type="submit" name="submit" id="example" value="Parse JSON example" onclick="example();"><a href="https://gist.github.com/3720842">source code</a></br>
            <!-- <input type="submit" name="submit" id="example_grade" value="Parse Grade example" onclick="grade_example('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');"><a href="https://gist.github.com/3720842">source</a></br>-->
            <span style="color:green"></span>
            <div id="results"></div>
            <h2>Source Code</h2>
            <ul>
                <li><h3><a href="./js/vulamobi.js">vulamobi.js</a>The Buttons in this page are using this file</h3></li>
                <li>HTML source for this <a href="https://github.com/zuch/VulaMobi/blob/master/application/views/public/index.php">page</a></li>
            </ul>
        </div>
    </div>

