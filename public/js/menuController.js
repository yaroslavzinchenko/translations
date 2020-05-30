var iconMenuEnabled = true;

function changeIcon() {

	if (iconMenuEnabled) {
		document.getElementById('dropdown-button-id').style.background = "url('/images/icons/cancel.png') center no-repeat";
		document.getElementById('dropdown-button-id').style.backgroundSize = '61%';
		iconMenuEnabled = false;

	} else {
		document.getElementById('dropdown-button-id').style.background = "url('/images/icons/menu-lines.png') center no-repeat";
		document.getElementById('dropdown-button-id').style.backgroundSize = '75%';
		iconMenuEnabled = true;
	}

}

/* When the user clicks on the button,
toggle between hiding and showing the dropdown content. */
function dropdownController() {
	document.getElementById("myDropdown").classList.toggle("show");
}
