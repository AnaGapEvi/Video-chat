<!doctype html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Video Chat</title>
</header>
<style>
   .nav{
       margin: 0!important;
   }
</style>
<body>
    <div id="app">
        <test class="nav"></test>
        <router-view></router-view>
    </div>
    <script src="../js/app.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/chat/v3.0/twilio-chat.min.js"></script>
</body>
</html>
