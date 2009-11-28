/*var onload = [];

onload.push(function() {
	setInterval( function() {
	checkWords();
	},1500
	);
});
*/
function validate(form){ 
	var tweetText = document.getElementById("input_field");
	var errorDiv = document.getElementById("errorDiv");

	if (tweetText.getValue().length > 140) {
		errorDiv.setStyle("display","block");
		return false;
	} else {
		errorDiv.setStyle("display","none");
		return true;
	}
}