<body>
    <div id="header"><h1>VulaMobi API</h1></div>
    <div id="wrapper">
        <div id="status_wrapper">
            <div id="status">
                    <span id="msg"></span>
            </div>
        </div>
        <div id="content">
            <div id="login">
                <p>
                    <label for="username"><b>Username</b></label>
                    </br>
                    <input type="text" id="username" name="username">
                </p>
                <p>
                    <label for="password"><b>Password</b></label>
                    </br>
                    <input type="password" id="password" name="password">
                </p>
                
                    <button type="button" onclick="login();">login</button> 
                    </br>
                    <button type="button" onclick="logout();">logout</button> 
                    <h3 style="color:#444444">Demo</h3>
            </div>
            <div id="demo">
                <div><h3 id="demo_heading"></h3></div>
                <div id="demo_content"></div>
                <div id="home"></div>
            </div>
            <div id="show_docs">
                </br>
                <button onclick="getElementById('docs').style.display = 'block'">Show Docs</button>
            </div> 
            <div id="docs">
                <h2>Documentation</h2>
                <a href="https://github.com/zuch/VulaMobi/wiki"><img src="./images/github-icon.png" alt="GitHub"></a> 
                <h2>Functions</h2>
                <p>
                    Test out the jQuery AJAX calls to the VulaMobi Backend hosted on nightmare
                </p>
                <button type="button" onclick="s_name();">student/name</button></br>
                <button type="button" onclick="sites();">student/sites</button>Active Sites</br>
                <button type="button" onclick="user_id();">student/id</button></br>
                <button type="button" onclick="grade('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">grade/site</button>CS Honours 2012</br>
                <button type="button" onclick="grade_all();">grade/all</button>Grades for All Active Sites</br>
                <button type="button" onclick="gallery();">gallery/dir</button></br>
                <button type="button" onclick="role('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">role/site</button>CS Honours 2012</br>
                <button type="button" onclick="roster('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">role/roster</button>CS Honours 2012</br>
                <button type="button" onclick="announcement_site('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">announce/site</button>Honours 2012</br>
                <button type="button" onclick="announcement_body('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d','3c40ff32-680f-42ee-8f34-fa5271e39c17');">announce/body</button>CS Honours 2012 random announcement</br>
                <button type="button" onclick="announcement_all();">announce/all</button>Announcements for All Active Sites</br>
                <button type="button" onclick="resource('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');;">resource/site</button>CS Honours 2012</br>
                <button type="button" onclick="assign('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">assign/site</button>CS Honours 2012</br>
                <button type="button" onclick="assign_all();">assign/all</button>Assignments for All Active Sites</br>
                <button type="button" onclick="chat('fa532f3e-a2e1-48ec-9d78-3d5722e8b60d');">chat/site</button>CS Honours 2012Sites</br>
                </br>
                <form name = "myform">
                    <textarea name="msg"  rows="5" cols="25" id="msg">
                    </textarea>
                </form>
                <button type="button" onclick="submit('43271a70-b78e-460b-a5b8-8356d0989a85');">chat/submit</button>Send a message to Major Projects</br>
                <h2>Test</h2>
                <button type="button" onclick="test_t();">test/t</button></br>
                <button type="button" onclick="example();">Parse JSON example</button><a href="https://gist.github.com/3720842">source code</a></br>
                <span style="color:green"></span>
                <div id="results"></div>
                <h2>Source Code</h2>
                <ul>
                    <li><h3><a href="./js/vulamobi.js">vulamobi.js</a></h3></li>
                    <li><h3> <a href="https://github.com/zuch/VulaMobi/blob/master/application/views/public/index.php">html</a></h3></li>
                </ul>
            </div>
        </div>
    </div>

