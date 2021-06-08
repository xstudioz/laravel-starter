<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script src="{{asset('js/bundle.js')}}"></script>
  <script src="{{asset('js/xs-lib.min.js')}}"></script>
  <script>
    Vue.component('counter', my.counter)
  </script>
</head>
<body>
<div id="app">
  <counter></counter>
</div>

<script>
  new Vue({
    el: '#app'
  })
</script>
</body>
</html>
