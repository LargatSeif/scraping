<!DOCTYPE html>
<html>
<head>
	<title>Inputs</title>
</head>
<body>
<form method="POST" action="scrapper.php">
	<input type="text" name="url" placeholder="Url de la magazine">
	PAGES:	<input type="number" name="nbr" >
	<br>
	<input type="text" name="container" placeholder="article container selector">
	<br>
	<input type="text" name="title" placeholder="title selector">
	<br>
	<input type="text" name="time" placeholder="time selector">
	<br>
	<input type="text" name="content" placeholder="content selector">
	<br>
	<input type="submit" value="SCRAP!">
</form>
</body>
</html>