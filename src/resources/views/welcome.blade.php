<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>駆け出し部屋</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/super-build/ckeditor.js"></script> --}}
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/androidstudio.min.css"> -->
    <!-- <link rel="stylesheet" href="/path/to/styles/default.css"> -->

    <!-- <link href="highlight.js/monokai-sublime.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/agate.min.css">


</head>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/highlight.js@10.3.2/lib/languages/php.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/languages/all.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/js-cookie@3/dist/js.cookie.min.js"></script>

@vite('resources/css/app.css')

<style>
    @font-face {
        font-family: 'MyFont';
        src: url('http://localhost:8081/font/azukiL.ttf');
    }

    body {
        background-color: #F9FBFE;
        height: 100%;
        width: 100%;
        font-family: 'MyFont';
        font-weight: 900;
        /* color:#F9FBFE; */
    }

    v-btn {
        background: 'F9FBFE';
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        font-weight: 900;


    }
    v-card {
    background-color: #F9FBFE;
    background-size: cover;
    /* position: relative;
    z-index: 0; */

}

v-toolbar {
    background-color: #F9FBFE;
    
}

.hidden {
  display: none;
}
</style>



</head>

<body>




    <!-- <script src="\resources\js\components\store\store.js"></script> -->
   
    @vite('resources/js/app.js')

   




    <div id="register" class="hidden"></div>
    <div id="login" class="hidden"></div>

    <div id="answer" class="hidden"></div>
    <div id="app" class="hidden"></div>

    <div id="profile" class="hidden"></div>

    <div id="index" class="show"></div>

    <script>




    </script>



</body>

</html>