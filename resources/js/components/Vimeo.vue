<template>
    <div>
        <!--
            Video display
            (Only show when video ID exist)
        -->
        <iframe v-bind:src="'https://player.vimeo.com/video/'+user.video" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen v-show="user.video!=null"></iframe>
        <!--
            Hidden input replaced with button
            On changed: change()
        -->
        <input type="file" style="display: none;" ref="input" @change="upload">
        <!--
            Upload button & upload status
            (Only show if video ID doesn't exist)
        -->
        <button type="submit" class="btn btn-primary" @click="$refs.input.click()" v-show="user.video==null">Upload Video</button>
        <strong class="ml-4" v-show="user.video==null">{{ status }}</strong>
    </div>
</template>

<script src="https://player.vimeo.com/api/player.js"></script>


<script>
import Axios from 'axios';
let Vimeo = require('vimeo').Vimeo;
let client = new Vimeo("", // Client identifier (like app ID)
    "", // Client secret (like app key/password)
    ""); // Access Token (Contains access information like whether the user can UPLOAD, DELETE, EDIT ALBUMS etc)

/**
 * To get the client ID, secret and access token:
 * 
 * Go to https://developer.vimeo.com/
 * and create a new app
 */

export default {
    props: ['user'],
    data() {
        return {
            /**
             * To display the upload status
             */
            status: 'This status display not working, please see console for upload status.',
        }
    },
    mounted() {
        console.log(this.user);
    },
    methods: {
        upload(event)
        {
            /**
             * Get file
             */
            let file_name = event.target.files[0];

            /**
             * Upload video
             */
            client.upload(
                file_name,      
                {
                    'name': this.user.name,             // Name of the video
                    'description': this.user.email      // Description
                },
                function (uri) {        // If successful
                    console.log(uri);

                    /**
                     * Make a POST request to '/videoid'
                     * This route will call ProfileController videoid() function
                     */
                    Axios.post('videoid',   // URL: <------------------- Change this URL
                    {
                        uri: uri.replace('/videos/', '')    // Get video ID only
                    })
                    .then(function(){          // If POST succeeded
                        console.log('Successful.');
                    })
                    .catch(function(error){     // If not
                        console.log(error);
                    });
                },
                function (bytes_uploaded, bytes_total) {    // When uploading
                    var percentage = (bytes_uploaded / bytes_total * 100).toFixed(2);

                    /**
                     * Upload status
                     */
                    console.log('Status: ' + bytes_uploaded/1048576 + 'MB / ' + bytes_total/1048576 + 'MB - ' + percentage + '%');
                },
                function (error) {          // If unsuccessful
                    console.log('Failed because: ' + error);
                }
            );
        }
    }
}
</script>
