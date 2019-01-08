## Avatar Upload

### Implementation.

- Require **jsPDF**:

    ```html
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
    ```

### Creating your component.

- Create a Vue component in your `js` folder and register it inside `app.js`.

    ```javascript
    Vue.component('pdf', require('./components/Pdf.vue').default);
    ```

**Make sure to run:** `npm run dev`

- Copy the `Pdf.vue` script.

    [`Pdf.vue`](resources/js/components/Pdf.vue)

- You can now use it from your view.

    ```php
    @extends('layouts.app')

    @section('content')
    ...
    <pdf>
        <!--
        Content goes here.
        -->
    </pdf>
    ...
    @endsection
    ```

### Change values if necessary.
