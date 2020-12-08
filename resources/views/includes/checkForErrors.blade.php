@if (isset($_SESSION['info']))
    @if ($_SESSION['info'] != '')
        <div class="alert alert-success text-center">{{$_SESSION['info']}}</div>
    @endif
    @php
        $_SESSION['info'] = "";
    @endphp
@endif

@if (isset($_SESSION['warning']))
    @if ($_SESSION['warning'] != '')
        <div class="alert alert-warning text-center">{{$_SESSION['warning']}}</div>
    @endif
    @php
        $_SESSION['warning'] = "";
    @endphp
@endif

@if (isset($_SESSION['error']))
    @if ($_SESSION['error'] != '')
        <div class="alert alert-danger text-center">{{$_SESSION['error']}}</div>
    @endif
    @php
        $_SESSION['error'] = "";
    @endphp
@endif

@if (count($errors) > 0)
    @foreach($errors as $error)
        <div class="alert alert-danger text-center">{{$error}}</div>
    @endforeach
@endif
