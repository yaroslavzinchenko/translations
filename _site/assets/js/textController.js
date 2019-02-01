var translationEnabled = true;

function textController() {

	if (translationEnabled) {
		document.getElementById('textWithTranslation').style.display = 'none';
		document.getElementById('textWithoutTranslation').style.display = 'block';
		translationEnabled = false;

	} else {
		document.getElementById('textWithTranslation').style.display = 'block';
		document.getElementById('textWithoutTranslation').style.display = 'none';
		translationEnabled = true;
	}
	
}