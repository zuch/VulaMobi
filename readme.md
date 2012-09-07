# **Vulamobi Backend API**
************************

For clarity's sake, here is an overview of Vulamobi's present architecture:
![Vulamobi_Architecture_2.0](http://people.cs.uct.ac.za/~swatermeyer/images/Architecture_2.0.jpg)

To call the scripts on the intermediary server hosted on nightmare(people.cs.uct.ac.za/~swatermeyer/Vulamobi) you need to use jQuery AJAX to perform "GET" and "POST" from the client-side native app **DEMO:** http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/.

To save you guys time I have created [vulamobi.js](http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/js/vulamobi.js), this is the client-side javascript file used to perform jQuery AJAX calls to the VulaMobi Backend.

You must [download](http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/js/vulamobi.js) this file aswell as [jquery](http://people.cs.uct.ac.za/~swatermeyer/VulaMobi/js/jquery.js) and include these files in your app then edit **vulamobi.js** as you see fit.

##API Functions

1. **auth/login**
2. **auth/logout**
3. **student/name**
4. **student/sites**
5. **student/id**
6. **grade/site**
7. **role/site**
8. **role/roster**
9. **gallery/dir**
10. **gallery/upload**

## auth

Before you can use any VulaMobi web services, you first need to login or the returned result will always be "logged_out". 

**Note: If at anytime you recieve "logged_out" as a response then re-route to the login view**.

##1. auth/login

Login to Vula

**Responses**:
 - `logged_in` - logged in, re-route to home view
 - `logged_out` - logged out, re-route to login view
 - `empty` - Username or Password are empty, display feedback message
 - `incorrect` - Username or Password is incorrect, display feedback message
 - `already` - already logged in, re-route to home view

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
 - `logged_out` - logged out, re-route to login view
 - `name` - text output of name

**Response Type**: `TEXT`

**URL** `ajax.php?student/name`

##4. student/sites

Return Active Sites of User

**Responses**:
 - `logged_out` - logged out, re-route to login view
 - array of JSON Objects, each object with **2** fields:
    - `title`
    - `site_id`

**Response Type**: `JSON`

**URL** `ajax.php?student/sites`

##5. student/id

Return Student Number of User e.g WTRSAS001

**Responses**:
 - `logged_out` - logged out, re-route to login view
 - `id` - text output of user id

**Response Type**: `TEXT`

**URL** `ajax.php?student/id`

##6. grade/site

Get grades of a user for a specific site(pass through site_id) e.g `ajax.php?grade/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012. 

To get the site_id's use `ajax.php?student/sites`

**Responses**:
 - `logged_out` - logged out, re-route to login view
 - array of JSON Objects, each object with **3** fields:
    - `name`
    - `date`
    - `mark`

**Response Type**: `JSON`

**URL** `ajax.php?grade/site/site_id`

##7. role/site

Get role for user of a specific site(pass through site_id) e.g. `ajax.php?role/site/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012.

To get the site_id's use `ajax.php?student/sites`

**Responses**:
 - `logged_out` - logged out, re-route to login view
 - `text` - text response of role of user

**Response Type**: `TEXT`

**URL** `ajax.php?role/site/site_id`

##8. role/roster

Get entire roster of a specific site(pass through site_id) e.g. `ajax.php?role/roster/fa532f3e-a2e1-48ec-9d78-3d5722e8b60d` for CS Honours 2012.

To get the site_id's use `ajax.php?student/sites`

**Responses**:
 - 'logged_out' - logged out, re-route to login view
 - array of JSON Objects, each object with **4** fields:
    - `name`
    - `id`
    - `email`
    - `role`

**Response Type**: `JSON`

**URL** `ajax.php?role/roster/site_id`

##9. gallery/dir

Returns JSON info about the pictures uploaded in directory "/uploads/user_id" by a user.

**Responses**:
 - `logged_out` - logged out, re-route to login view
 - array of JSON Objects, each object with **2** fields:
    - `filename`
    - `url`

**Response Type**: `JSON`

**URL** `ajax.php?gallery/dir`

##10. gallery/upload

The script that George must call to upload a picture to server
 
**Responses**:

- `logged_out` - re-route to login view
- `done` - upload succesful
- `not_set` - POST['image'] not set

**Response Type**: `TEXT`

**URL** `ajax.php?gallery/upload`