<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$("button").click(function(){




				// alert("querySuccess_enviar_detalle");
				// var direccion   =$(".direccion").val();
				var codigo      =13;
				var password    =6873149;
				var info='detalle';


				var results=[];
				results[0]='detalle';
				results[1]='detalle2';
				results[2]='detalle3';
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: "sitrans_insert.php",
					data: "codigo=" + codigo + "&password=" + password + "&info=" + info + "&data=" + results,
					success: function (resp) {
						// $.mobile.loading("hide");
						alert(resp);
					},
					error: function (e) {
						// $.mobile.loading("hide");
						alert('error enviar'+e.Message);
					}
				});



			});
		});
	</script>
</head>
<body>

	<div id="div1"><h2>Let jQuery AJAX Change This Text</h2></div>

	<button>Get External Content</button>

</body>
</html>