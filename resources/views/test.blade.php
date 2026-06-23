<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>

<h1>TEST FORM</h1>

<form method="POST" action="/test-form">
    @csrf
    <input type="text" name="email">
    <button type="submit">ENVIAR</button>
</form>

</body>
</html>