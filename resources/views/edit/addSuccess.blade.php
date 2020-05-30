<!doctype html>
<html lang="ru">
@include('includes.head')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<body>
<div class="container">
    <br>
    <div class="alert {{$msgClass}}">{{$msg}}</div>
    <br>
    Перенаправление на /artists/add
</div>
</body>
</html>


<script>
    setTimeout(function(){window.location='/artists/add'}, 5000);
</script>
