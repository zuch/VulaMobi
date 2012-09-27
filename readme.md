# **Vulamobi Backend API**
************************

For clarity's sake, here is an overview of Vulamobi's present architecture:
![Vulamobi_Architecture_2.0](http://people.cs.uct.ac.za/~swatermeyer/images/Architecture%202.0.png)

To call the scripts on the intermediary server hosted on nightmare(people.cs.uct.ac.za/~swatermeyer/Vulamobi) you need to use jQuery AJAX to perform "GET" and "POST" from the client-side native app **DEMO:** http://people.cs.uct.ac.za/~swatermeyer/VulaMobi.

To save you guys time I have created [vulamobi.js](http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/js/vulamobi.js), this is the client-side javascript file used to perform jQuery AJAX calls to the VulaMobi Backend.

You must [download](http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/js/vulamobi.js) this file aswell as [jquery](http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/js/jquery.js) and include these files in your app then edit **vulamobi.js** as you see fit.

##API Functions

1. **auth/login**
2. **auth/logout**
3. **student/name**
4. **student/sites**
5. **student/id**
6. **announce/all**
7. **announce/site**
8. **chat/site**
9. **grade/site**
10. **resource/site**
11. **role/site**
12. **role/roster**
13. **gallery/dir**
14. **gallery/upload**

##Auth

**Note:** Everytime you call a web service you **have to** POST the user's `username` and `password`.

This is because the intermediary server re-logs in the user everytime you call a web service.

##1. auth/login

Login to Vula

**Responses**:
 - `logged_in` - logged in, re-route to home view
 - `logged_out` - logged out, re-route to login view
 - `Empty Username or Password` - Username or Password are empty, display feedback message
 - `Incorrect Username or Password` - Username or Password is incorrect, display feedback message

**Response Type**: `TEXT`

**URL** `ajax.php?auth/login`

##2. auth/logout

Logout of Vula

**Responses**:
 - `logged_out` - logged out, re-route to login view

**Response Type**: `TEXT`

**URL** `ajax.php?auth/logout`

##3. student/name

Return name of User e.g Sascha Watermeyer

**Responses**:
 - `name` - text output of name

**Response Type**: `TEXT`

**URL** `ajax.php?student/name`

##4. student/sites

Return Active Sites of User

**Responses**:
 - array of JSON Objects, each object with **2** fields:
    - `title`
    - `site_id`

**Response Type**: `JSON`

**URL** `ajax.php?student/sites`

##5. student/id

Return Student Number of User e.g WTRSAS001

**Responses**:
 - `id` - text output of user id

**Response Type**: `TEXT`

**URL** `ajax.php?student/id`

##6. announce/all

Returns Announcements of all Active Sites for a User.

**Responses**:
 - array of JSON Objects, each object with **4** fields:
    - `entityTitle`
    - `id`
    - `siteTitle`
    - `onclick` js function call with ID of a single announcement

**Response Type**: `JSON`

**URL** `ajax.php?announce/all`

##7. announce/site

Get announcements for a specific site(pass through site_id) e.g `ajax.php?announce/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012. 

**Responses**:
 - array of JSON Objects, each object with **4** fields:
    - `entityTitle`
    - `id`
    - `siteTitle`
    - `onclick` js function call with ID of a single announcement

**Response Type**: `JSON`

**URL** `ajax.php?announce/site/site_id`

##8. chat/site

Get chat messages for a specific site(pass through site_id) e.g `ajax.php?chat/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012.

**Responses**:
 - `message` chat message with date information

**Response Type**: `JSON`

**URL** `ajax.php?chat/site/site_id`

##9. grade/site

Get grades of a user for a specific site(pass through site_id) e.g `ajax.php?grade/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012. 

To get the site_id's use `ajax.php?student/sites`

**Responses**:
 - array of JSON Objects, each object with **3** fields:
    - `name`
    - `date`
    - `mark`

**Response Type**: `JSON`

**URL** `ajax.php?grade/site/site_id`

##10. resource/site

Get resources for a specific site(pass through site_id) e.g `ajax.php?resource/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012. 

To get the site_id's use `ajax.php?student/sites`

**Responses**:
 - array of **2** Types of JSON Objects, each object with **3** fields:

    **folder**
      - `type` "folder"
      - `text`
      - `onclick` js function call with ID of a resource folder   

    **file**
      - `type` "file"      
      - `text`
      - `href` js function call with ID of a resource folder or file

**Response Type**: `JSON`

**URL** `ajax.php?resource/site/site_id`

##11. role/site

Get role for user of a specific site(pass through site_id) e.g. `ajax.php?role/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012.

To get the site_id's use `ajax.php?student/sites`

**Responses**:
 - `text` - text response of role of user

**Response Type**: `TEXT`

**URL** `ajax.php?role/site/site_id`

##12. role/roster

Get entire roster of a specific site(pass through site_id) e.g. `ajax.php?role/roster/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012.

To get the site_id's use `ajax.php?student/sites`

**Responses**:
 - array of JSON Objects, each object with **4** fields:
    - `name`
    - `id`
    - `email`
    - `role`

**Response Type**: `JSON`

**URL** `ajax.php?role/roster/site_id`

##13. gallery/dir

Returns JSON info about the pictures uploaded in directory "/uploads/user_id" by a user.

**Responses**:
 - array of JSON Objects, each object with **2** fields:
    - `filename`
    - `url`

**Response Type**: `JSON`

**URL** `ajax.php?gallery/dir`

##14. gallery/upload

The script that George must call to upload a picture to server
 
**Responses**:
- `done` - upload succesful
- `not_set` - POST['image'] not set

**Response Type**: `TEXT`

**URL** `ajax.php?gallery/upload`