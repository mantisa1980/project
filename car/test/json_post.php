<script type="text/javascript">
function test()
{
	/*var data = {
	    "A": 1,
	    "B":[
	        {"X":2, "Y":3},
	    ]
	};
	data["B"].push({"X":5, "Y":6});
*/
	var data = [];
	data.push({"X":7, "Y":8});

	var form = document.getElementById("form");
	var input = document.createElement("input");
	input.type  = "hidden";
	input.name  = "data";
	input.value = JSON.stringify(data);
	form.appendChild(input);
	form.submit();
}
	

</script>
<form id="form" method="post" action="fetch_json_post.php">
	<input type="button" value="send" onClick="test()">
</form>
