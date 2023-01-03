<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/super-build/ckeditor.js"></script> --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/androidstudio.min.css">

    <link href="highlight.js/monokai-sublime.min.css" rel="stylesheet">


</head>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>

@vite('resources/css/app.css')

<style>
    @font-face {
        font-family: 'MyFont';
        src: url('http://localhost:8081/font/azukiL.ttf');
    }

    body {
        background-color: #FFF6E5;
        height: 100%;
        width: 100%;
        font-family: 'MyFont';
       
        }
        v-btn{
        background-color: #000000;
       
       
        }

        
</style>



</head>

<body>






    @vite('resources/js/app.js')



    <div id="register" class="hidden"></div>
    <div id="login" class="hidden"></div>


    <div id="app" class="show"></div>

    <div id="index" class="hidden"></div>

    <script>




    </script>



</body>

</html>