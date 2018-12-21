## Avatar Upload

### Installation.
    
- Install **vue-upload-component**. ```npm install vue-upload-component --save```

- Install **cropperjs for image cropping**. ```npm install cropperjs --save```

- Install **axios for sending POST request to URL**. ```npm install axios --save```

### Creating your component.
    
- Create a Vue component in your [`js`](AVATAR-VUE.png) folder and register it inside `app.js`.

    ```javascript
    Vue.component('avatar', require('./components/Avatar.vue').default);
    ```

    **Make sure to run:** `npm run dev`

- Copy the Avatar.vue script.
    
    [`Avatar.vue`](resources/js/components/Avatar.vue)

- You can now use it from your view.
    
    ```php
    @extends('layouts.app')
    
    @section('content')
    ...
    <avatar></avatar>
    ...
    @endsection
    ```

### Create controller for file storing.
    
- Run `php artisan make:controller ProfileController`.

- In `ProfileController.php`, copy the following function.
    
    ```php
    /**
     * Upload image
     */
    public function upload(Request $request)
    {
        /**
         * file()->store() will return image path
         * storage/app/{returned path}
         */
        $path = $request->file('avatar')->store('avatars');

        /**
         * Get current user
         */
        $user = Auth::user();

        /**
         * Store image path to database
         */
        $user->image = $path;
        $user->save();
    }
    ```

- Register the function as POST in `routes/web.php`.
    
    ```php
    Route::post('/upload', 'ProfileController@upload')->name('upload');
    ```

### Changing values _(if necessary)_.

- Change POST request URL.
    
    Go to the `Avatar.vue` component and scroll down to the ```save()``` method. Then change the following parameter.
    
    ```javascript
    save(file, component)
    {
        ...
        
        Axios.post('upload',    // URL: <------------------- Change this URL
        formData,
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
        ).then(function () { ... })
        .catch(function (error) { ... });
    }
    ```
