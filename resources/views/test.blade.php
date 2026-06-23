<!DOCTYPE html>
<html>
<head>
    <title>TEST</title>
</head>
<body>

<h1>TEST FORM</h1>

<form method="POST" action="/test-directo">
    @csrf
    <input type="email" name="email" value="test@test.com">
    <button type="submit">ENVIAR</button>
</form>

</body>
</html>