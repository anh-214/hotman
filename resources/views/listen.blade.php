<!DOCTYPE html>
<head>
    {{-- <meta name="csrf-token" content="{{csrf_token()}}"> --}}
    <title>Pusher Test</title>
    <script src="{{asset('js/app.js')}}"></script>
    <script>

        // // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        // var pusher = new Pusher('e01e2404465ce83d0835', {
        // cluster: 'ap1'
        // });

        // var channel = pusher.subscribe('my-channel');
        // channel.bind('my-event', function(data) {
        // alert(JSON.stringify(data));
        // });

        
        Echo.private('orderNotification.@if(Auth::guard('admin')->check()){{'admin'}}@else{{'none'}}@endif')

        .listen('MessageNotification', (e) => {
        // $('#content').append(`<div class="well">${e.message}</div>`);
        console.log(e.message)
    });
    </script>
</head>
<body>
    <h1>Pusher Test</h1>
    <p>
        Try publishing an event to channel <code>my-channel</code>
        with event name <code>my-event</code>.
    </p>
</body>
