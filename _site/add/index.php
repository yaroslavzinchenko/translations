<?php
	// Message Variables.
	$msg = '';
	$msgClass = '';

	// Check For Submit.
	if (filter_has_var(INPUT_POST, 'submit'))
	{

		// Get Form Data.
		$song = htmlspecialchars($_POST['song']);
		$band = htmlspecialchars($_POST['band']);
		$lyrics = htmlspecialchars($_POST['lyrics']);
		$spotify_link = htmlspecialchars($_POST['spotify_link']);
		$youtube_link = htmlspecialchars($_POST['youtube_link']);

		// Check Required Fields.
		if (!empty($song) && !empty($band)  && !empty($lyrics) && !empty($spotify_link) && !empty($youtube_link))
		{
			// print_r($_POST);

			// Подготавливаем имя файла.
			$fileName = strtolower($song);
			$fileName = str_replace(' ', '_', $fileName);
			$fileName = $fileName . '.html';
			echo $fileName;

			// Added.
			$msg = 'Your form has been submitted';
			$msgClass = 'alert-success';
		}
		else
		{
			// Failed.
			$msg = 'Please, fill in all fields';
			$msgClass = 'alert-danger';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	
	<!-- Масштабирование на мобильных устройствах -->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>Add</title>
</head>
<body>
	<div class="container">

		<br>
		
		<?php if ($msg != ''): ?>
			<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
		<?php endif; ?>

		<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="form-group">
				<label for="song">Название</label>
				<input type="text" name="song" id="song" class="form-control" value="<?php echo isset($_POST['song']) ? $song : ''; ?>">
			</div>
			<div class="form-group">
				<label for="band">Группа</label>
				<input type="text" name="band" id="band" class="form-control" value="<?php echo isset($_POST['band']) ? $band : ''; ?>">
			</div>
			
			<div class="form-group">
				<label for="lyrics">Стихи</label>
				<textarea name="lyrics" id="lyrics" class="form-control"><?php echo isset($_POST['lyrics']) ? $lyrics : ''; ?></textarea>
			</div>
			<div class="form-group">
				<label for="spotify_link">Ссылка Spotify</label>
				<input type="text" name="spotify_link" id="spotify_link" class="form-control" value="<?php echo isset($_POST['spotify_link']) ? $spotify_link : ''; ?>">
			</div>
			<div class="form-group">
				<label for="youtube_link">Ссылка YouTube</label>
				<input type="text" name="youtube_link" id="youtube_link" class="form-control" value="<?php echo isset($_POST['youtube_link']) ? $youtube_link : ''; ?>">
			</div>
			<br>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>

	</div>
</body>
</html>