<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <!-- START from includeStandardHead.vm -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />

        <!-- this causes problems for layout needs investigating -->
        <link href="/portal/styles/portalstyles.css" type="text/css" rel="stylesheet" media="all" />
        <!--[if gte IE 5]><![if lt IE 7]>
            <link href="/portal/styles/portalstyles-ie5.css" type="text/css" rel="stylesheet" media="all" />
        <![endif]><![endif]-->
        <link href="/library/skin/default/portal.css" type="text/css" rel="stylesheet" media="all" />


        <title>Vula : CS Honours, 2012 : Participants</title>
        <link href="/library/skin/tool_base.css" type="text/css" rel="stylesheet" media="all" />
        <link href="/library/skin/default/tool.css" type="text/css" rel="stylesheet" media="all" />

        <script type="text/javascript" language="JavaScript" src="/library/js/headscripts.js"></script>
        <script type="text/javascript" language="JavaScript" src="/library/js/jquery.js"></script>

        <script type="text/javascript" language="JavaScript" src="/portal/scripts/portalscripts.js"></script>

        <script type="text/javascript" language="JavaScript">
            setLoginStatus (true, "https://vula.uct.ac.za/portal", "https://vula.uct.ac.za/portal", "871259d6-71fe-4cde-80a7-c07c1e0901ac", "wtrsas001");
            setTimeoutInfo (true, 600);
            setUIToggleState (true, true, false);
        </script>

    </head>
    <!-- END from includeStandardHead.vm -->
    <body class="portalBody">
        <script type="text/javascript" language="JavaScript">
            var sakaiPortalWindow = "";
        </script>
        <!-- END Header -->
        <script type="text/javascript">
            $(document).ready(function() {
                var toggleClass=""
                toggleClass="toggleTools"
                $('#toggler').css({'display' : 'block'});
                $('#toggler').addClass(toggleClass)

                $('#toggleToolMenu').click(function(){
                    if ( $('#toggleNormal').is(':visible') ) {
                        sakaiRestoreNavigation();	
                        document.cookie = "sakai_nav_minimized=false; path=/";
                    } else {
                        sakaiMinimizeNavigation();
                        document.cookie = "sakai_nav_minimized=true; path=/";
                    }
                });
            });
        </script>
        <!-- site.vm -->

        <!-- start includeSiteNav -->
        <div id="portalOuterContainer">
            <div id="portalContainer"  >
                <div id="skipNav">

                    <a href="#tocontent"  class="skip" title="jump to content" accesskey="c">
                        jump to content
                    </a>
                    <a href="#totoolmenu"  class="skip" title="jump to tools list" accesskey="l">
                        jump to tools list
                    </a>
                    <a href="#sitetabs" class="skip" title="jump to worksite list" accesskey="w">
                        jump to worksite list
                    </a>
                </div>
                <div id="headerMax">
                    <div id="siteNavWrapper" class="course">
                        <div id="mastHead">
                            <div id="mastLogo">
                                <img title="Logo" alt="Logo" src="/library/skin/default/images/logo_inst.gif" />
                            </div>
                            <div id="mastBanner">
                                <img title="Banner" alt="Banner" src="/library/skin/default/images/banner_inst.gif" />
                            </div>
                            <!-- login component -->
                            <div id="mastLogin">
                                <div id="loginLinks">
                                    <span id="loginUser">Sascha Watermeyer (wtrsas001) | </span>
                                    <a href="https://vula.uct.ac.za/portal/logout" title="Logout" id="loginLink1" ><img src="/library/skin/default/images/logout.gif" alt="Logout"/></a>
                                </div>
                            </div>
                            <!-- end login component -->
                        </div>
                    </div>

                    <!-- START from includeTabs.vm -->
                    <!-- start includeTabs -->
                    <div class="siteNavWrap course">
                        <div id="siteNav">
                            <div id="linkNav">
                                <a id="sitetabs" class="skip" name="sitetabs"></a>
                                <h1 class="skip">Worksites begin here</h1>
                                <ul id="siteLinkList">
                                    <li><a href="https://vula.uct.ac.za/portal/site/%7Ewtrsas001" title="My Workspace"><span>My Workspace</span></a></li>
                                    <li class="selectedTab"><a href="#"><span>CS Honours, 2012</span></a></li>
                                    <li><a href="https://vula.uct.ac.za/portal/site/43271a70-b78e-460b-a5b8-8356d0989a85" title="Major Project"><span>Major Project</span></a></li>
                                    <li><a href="https://vula.uct.ac.za/portal/site/69e9386d-a772-47c6-8842-4d1d14a7650c" title="CS agents"><span>CS agents</span></a></li>
                                    <li><a href="https://vula.uct.ac.za/portal/site/0fecefa0-3afb-4504-a888-4bb4b48523a3" title="DBS"><span>DBS</span></a></li>
                                    <li><a href="https://vula.uct.ac.za/portal/site/e193c143-9d00-402b-811b-58ae999498c9" title="CSC3002F,2011"><span>CSC3002F,2011</span></a></li>
                                    <li><a href="https://vula.uct.ac.za/portal/site/a02e13fc-ba96-433e-86b0-3269c3287ea0" title="CSC3003S,2011"><span>CSC3003S,2011</span></a></li>
                                </ul>
                            </div> <!-- /linkNav -->

                        </div>
                        <div class="divColor" id="tabBottom">
                        </div>


                        <div id="selectNav" style="display:none">
                            <div>
                                <span class="skip">To operate the combo box, first press Alt+Down Arrow to open it, and then use the up and down arrow keys to scroll through the options.</span>

                                <div class="termContainer">
                                    <h4>2012</h4>
                                    <ul>
                                        <li><a href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d" title="CS Honours, 2012">
                                                <span>CS Honours, 2012</span>
                                            </a></li>
                                    </ul>
                                </div> <!-- /termContainer -->
                                <div class="termContainer">
                                    <h4>2011</h4>
                                    <ul>
                                        <li><a href="https://vula.uct.ac.za/portal/site/e193c143-9d00-402b-811b-58ae999498c9" title="CSC3002F,2011">
                                                <span>CSC3002F,2011</span>
                                            </a></li>
                                        <li><a href="https://vula.uct.ac.za/portal/site/a02e13fc-ba96-433e-86b0-3269c3287ea0" title="CSC3003S,2011">
                                                <span>CSC3003S,2011</span>
                                            </a></li>
                                    </ul>
                                </div> <!-- /termContainer -->
                                <div class="termContainer">
                                    <h4>PROJECTS</h4>
                                    <ul>
                                        <li><a href="https://vula.uct.ac.za/portal/site/69e9386d-a772-47c6-8842-4d1d14a7650c" title="CS agents">
                                                <span>CS agents</span>
                                            </a></li>
                                        <li><a href="https://vula.uct.ac.za/portal/site/0fecefa0-3afb-4504-a888-4bb4b48523a3" title="DBS">
                                                <span>DBS</span>
                                            </a></li>
                                        <li><a href="https://vula.uct.ac.za/portal/site/43271a70-b78e-460b-a5b8-8356d0989a85" title="Major Project">
                                                <span>Major Project</span>
                                            </a></li>
                                    </ul>
                                </div> <!-- /termContainer -->
                                <div class="termContainer">
                                    <h4>OTHER</h4>
                                    <ul>
                                        <li><a href="https://vula.uct.ac.za/portal/site/%7Ewtrsas001" title="My Workspace">
                                                <span>My Workspace</span>
                                            </a></li>
                                    </ul>
                                </div> <!-- /termContainer -->
                                <div id="more_tabs_instr"><em>Hidden Sites</em> are not included in this menu. Access them in My Workspace -&gt; Worksite Setup.<br /> To hide a site, go to My Workspace -> Preferences -> Customize Tabs.</div>
                            </div> <!-- /  -->
                        </div> <!-- /selectNav -->

                    </div> <!-- /tabsCssClass -->
                    <!-- end includeTabs -->
                    <!-- END from includeTabs.vm -->


                </div>

                <!-- START from includePageWithNav.vm -->
                <div id="container" class="course" >

                    <!-- START from includePageNav.vm -->
                    <!-- start includePageNav -->
                    <div class="divColor" id="toolMenuWrap">
                        <div id="toggler">
                            <a id="toggleToolMenu" onmouseup="blur()" href="#" title="Expand/Contract Navigation"><img id="toggleToolMax" src="/portal/styles/images/transMin.png" alt=
                                                                                                                       "Expand/Contract Navigation"/><img id="toggleNormal" src="/portal/styles/images/transMin.png" alt="Expand/Contract Navigation" style="display:none"/></a>
                        </div>
                        <div id="worksiteLogo">
                            <p id="siteType">course</p>
                        </div>
                        <a id="totoolmenu" class="skip" name="totoolmenu"></a>
                        <h1 class="skip">Tools begin here</h1>
                        <div id="toolMenu">
                            <ul>
                                <li>
                                    <a class="icon-sakai-iframe-site " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/52821396-b05b-4e2f-87f5-125e054518cb" title="For displaying Site information | Display recent announcements, updated as messages arrive | Show a summary of schedule events in My Workspace | Display unread discussion and forum topic messages for all sites or a site | Display recent announcements, updated as messages arrive"><span>Home</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-announcements " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/77419572-9f56-421a-bda1-a7e5daeceeeb" title="For posting current, time-critical information"><span>Announcements</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-schedule " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/d2f7d35a-7a23-47ac-b49f-f522395458bd" title="For posting and viewing deadlines, events, etc."><span>Calendar</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-syllabus " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/cfbbb58d-5368-4522-bab5-3ea6b1a6c9dc" title="For posting a summary outline and/or requirements for a site."><span>Course Outline</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-resources " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/0bd4bbd6-bf3d-45a9-8fde-adecd7058949" title="For posting documents, URLs to other websites, etc."><span>Resources</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-melete " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/df1dea27-bd02-46dd-9b0d-99db5330dbe9" title="For creating and organizing content modules"><span>Modules</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-rwiki " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/3031ccd3-e8f1-4576-8f41-0abf0b957d84" title="For collaborative editing of pages and content"><span>Wiki</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-poll " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/fd4a46be-4df0-4cfb-afdf-89a61461135a" title="For anonymous polls or voting"><span>Polls</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-qna " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/273f6650-4f83-4140-8be1-32bae8d0ac5f" title="For asking, answering and organising questions"><span>Q&amp;A</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-blogwow " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/736ad310-26b0-479e-b6c8-d16b5a4f7637" title="For course or project blogging or journals"><span>Blogs</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-messages " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/32d5075b-2430-409c-8401-bffb7ac0290b" title="Display messages to/from users of a particular site"><span>Messages</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-chat " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/3616dae7-738d-4e8d-a0f1-0d6b70d434bf" title="For real-time conversations in written form"><span>Chat Room</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-assignment-grades " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/fe64b628-6c08-4a70-9f27-b2468fbf9041" title="For posting, submitting and grading assignment(s) online"><span>Assignments</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-gradebook-tool " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/3f33b95a-ad6c-43ea-ab00-7b260413b5e1" title="For storing and computing assessment grades from Tests &amp; Quizzes or that are manually entered."><span>Gradebook</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-postem " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/b2314f11-3125-4212-a406-8516c00de96d" title="PostEm gradebook tool for sakai."><span>PostEm</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-sections " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/a94ee2c7-3d66-4f04-9d1d-f9f478fc08e3" title="For managing sections (e.g. tutorial groups) within a site."><span>Section Info</span></a>
                                </li>
                                <li class="selectedTool">
                                    <a class="icon-sakai-site-roster"><span>Participants</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-search " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/c83e6b7d-b8c9-43eb-add9-011a64550055" title="For searching content within the site or across sites"><span>Search</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-rsf-evaluation " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/68a1d3f6-0f3f-4b49-bccd-7380a7effe2a" title="For course evaluations or other surveys or feedback"><span>Course Evaluation</span></a>
                                </li>
                                <li>
                                    <a class="icon-sakai-signup " href="https://vula.uct.ac.za/portal/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d/page/c636353f-7280-4f8c-a3bb-0709d6768b03" title="For enabling online registration for meetings and other events."><span>Sign-up</span></a>
                                </li>
                                <li>
                                    <a  class="icon-sakai-help" accesskey="6" href="https://vula.uct.ac.za/portal/help/main" target="_blank" 
                                        onclick="openWindow('https://vula.uct.ac.za/portal/help/main', 
                                            'Help', 'resizable=yes,toolbar=no,scrollbars=yes,menubar=yes,width=800,height=600'); 
                                            return false" title="Help">
                                        <span>Help</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Add subsite lists -->
                        <h1 class="skip">Users present begins here</h1>
                        <div id="presenceWrapper">
                            <div id="presenceTitle">Users present:</div>
                            <div id="presenceIframe">
                                &nbsp;
                            </div>
                            <script type="text/javascript">
                                var sakaiPresenceTimeDelay = 3000;
                                var sakaiPresenceFragment = "https://vula.uct.ac.za/portal/presence/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d?output_fragment=yes&auto=true";

                                $(document).ready(function() {
                                    sakaiLastPresenceTimeOut = setTimeout('updatePresence()', sakaiPresenceTimeDelay); 
                                } );
                            </script>
                        </div>
                    </div>
                    <a id="tocontent" class="skip" name="tocontent"></a>
                    <h1 class="skip">Content begins here</h1>
                    <!-- end includePageNav -->
                    <!-- end page nav -->
                    <!-- END from includePageNav.vm -->



                    <!-- START from includePageBody.vm -->
                    <div id="content">
                        <div id="col1">
                            <!-- start Tool -->
                            <div class="portletTitleWrap">
                                <div class="portletTitle">
                                    <div class="title">
                                        <a href="https://vula.uct.ac.za/portal/tool-reset/92491917-5f13-4da5-8425-4af8c522200c/?panel=Main" target="Main92491917x5f13x4da5x8425x4af8c522200c" title="Reset">
                                            <img src="/library/image/transparent.gif" alt="Reset" border="1" /></a>
                                        <h2>Participants</h2>
                                    </div>
                                    <div class="action">
                                        <a href="https://vula.uct.ac.za/portal/help/main?help=sakai.site.roster" title="Help for {0} Participants" 
                                           target="_blank" onclick="openWindow('https://vula.uct.ac.za/portal/help/main?help=sakai.site.roster', 'Help',
                                               'resizable=yes,toolbar=no,scrollbars=yes,menubar=yes,width=800,height=600'); return false">
                                            <img src="/library/image/transparent.gif"  alt="Help for {0} Participants" border="0" /></a>
                                    </div>
                                </div>
                            </div>
                            <!-- end Tool -->
                            <!-- start Tool Body -->						
                            <div class="portletMainWrap">
                                <iframe	name="Main92491917x5f13x4da5x8425x4af8c522200c"
                                        id="Main92491917x5f13x4da5x8425x4af8c522200c"
                                        title="Participants "
                                        class ="portletMainIframe"
                                        height="475"
                                        width="100%"
                                        frameborder="0"
                                        marginwidth="0"
                                        marginheight="0"
                                        scrolling="auto"
                                        src="https://vula.uct.ac.za/portal/tool/92491917-5f13-4da5-8425-4af8c522200c?panel=Main">
                                </iframe>
                            </div>
                            <!-- end Tool Body -->												
                        </div>
                    </div>
                    <div id="footer">
                        <!-- include bottom -->
                        <div class="footerContainer">
                            <div class="footerWrapper">
                                <div class="footer">
                                    <span class="footerLinks">
                                        <a href="http://www.cet.uct.ac.za" target="_blank">Centre for Educational Technology</a>  |  <a href="http://www.uct.ac.za" target="_blank">University of Cape Town</a>
                                    </span>

                                    <span class="footerSakai">
                                        Powered by <a href="http://sakaiproject.org" target="_blank">Sakai</a>
                                    </span>

                                    <span class="footerVersion">
                                        Vula - [r111850-r10154] - Sakai 2.8 - Server vula4a
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end includePageBody -->
                    <!-- END from includePageBody.vm -->
                </div>
                <!-- END from includePageWithNav.vm -->

            </div>
        </div>
        <!-- end includeSiteNav -->
        <!-- end site.vm -->
    </body>
</html>
