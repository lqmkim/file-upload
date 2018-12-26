## Avatar Upload

### Installation.
    
- Install **vimeo**. ```npm install vimeo --save```

### Creating your component.
    
- Create a Vue component in your `js` folder and register it inside `app.js`.

    ```javascript
    Vue.component('vimeo', require('./components/Vimeo.vue').default);
    ```

    **Make sure to run:** `npm run dev`

- Copy the `Vimeo.vue` script.
    
    [`Vimeo.vue`](resources/js/components/Vimeo.vue)

- You can now use it from your view.
    
    ```php
    @extends('layouts.app')
    
    @section('content')
    ...
    <vimeo :user="{{ Auth::user() }}"></vimeo>
    ...
    @endsection
    ```
    
### Set client value.

- Scroll down until you see three empty strings.
    
    ```javascript
    let client = new Vimeo("", // Client identifier (like app ID)
        "", // Client secret (like app key/password)
        ""); // Access Token (Contains access information like whether the user can UPLOAD, DELETE, EDIT ALBUMS etc)
    ```

- Go to https://developer.vimeo.com/, sign in and create a new app.

- Copy the **client ID** and **client secret**.

- Go to _Authentication_, generate an access key with **Upload** scope (if it is your first time, go to _Permissions_ and enable **Upload Access**).

### Create controller for storing video id.
    
- Run `php artisan make:controller ProfileController`.

- In `ProfileController.php`, copy the following function.
    
    ```php
    /**
     * Save video id to database
     */
    public function videoid(Request $request)
    {
        /**
         * Get video URI
         */
        $uri = $request->input('uri');

        /**
         * Get current user
         */
        $user = Auth::user();

        /**
         * Store image path to database
         */
        $user->video = $uri;
        $user->save();
    }
    ```

- Register a POST URL in `routes/web.php`.
    
    ```php
    Route::post('/videoid', 'ProfileController@videoid')->name('videoid');
    ```

### Changing values _(if necessary)_.

- Change POST request URL.
    
    Go to the `Vimeo.vue` component and scroll down to the ```upload()``` method.
    
    ```javascript
    upload(event)
    {
        let file_name = event.target.files[0];

        client.upload(
            file_name,      
            {
                'name': this.user.name,             // <----- Name of the video
                'description': this.user.email      // <----- Description
            },
            function (uri) {
                ...

                /**
                 * Make a POST request to '/videoid'
                 * This route will call ProfileController videoid() function
                 */
                Axios.post('videoid',   // URL: <------------------- Change this URL
                {
                    uri: uri.replace('/videos/', '')    // Get video ID only
                })
                .then(function(){           // If POST succeeded
                    ...
                })
                .catch(function(error){     // If not
                    ...
                });
            },
            function (bytes_uploaded, bytes_total) {    // During upload
                var percentage = (bytes_uploaded / bytes_total * 100).toFixed(2);
                
                ...
            },
            function (error) {          // If unsuccessful
                ...
            }
        );
    }
    ```
