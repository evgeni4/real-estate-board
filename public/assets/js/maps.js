google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
	var input = document.getElementById('property_form_address');
	var autocomplete = new google.maps.places.Autocomplete(input);
	autocomplete.addListener('place_changed', function () {
		var place = autocomplete.getPlace();
// place variable will have all the information you are looking for.
		let d = document.getElementById('singleMap')
		console.log(d)
		document.getElementById("property_form_latitude").value = place.geometry['location'].lat();
		document.getElementById("property_form_longitude").value = place.geometry['location'].lng();
		$('#singleMap').attr('data-latitude',place.geometry['location'].lat())
		$('#singleMap').attr('data-longitude',place.geometry['location'].lng())
	});
}