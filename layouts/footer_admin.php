	<footer>
	    <div class="container text-center">
	        <p>Copyright &copy; Ismael Heredia 2020 &middot; All Rights Reserved &middot;</p>
	    </div>
	</footer>
	<script>

		var usuarioLogeado = "";

		axios.post(window.$url_api, {
		tipo:'recibirUsuarioSesion'
		}).then(function(response){
			usuarioLogeado = response.data.nombreUsuario;
			$("#nombreUsuario").text(usuarioLogeado);
			
			var element = document.getElementById("bienvenidaNombreUsuario");
			if(typeof(element) != 'undefined' && element != null){
				$("#bienvenidaNombreUsuario").text(usuarioLogeado);
			}
		}).catch(function(error) {
			console.log('error : ' + error);
		});

		$(document).on('click', '#cerrarSesion', function(e){
			axios.post(window.$url_api, {
			tipo:'cerrarSesion'
			}).then(function(response){
				window.location.href = "index.php";
			}).catch(function(error) {
				console.log('error : ' + error);
			});
		});

	</script>
 </body>
</html>