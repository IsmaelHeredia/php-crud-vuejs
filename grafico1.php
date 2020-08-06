<div class="card card-primary contenedor">
    <div class="card-header bg-primary">Gráfico 1</div>
    <div class="card-body">

<?php

include_once("includes/Conexion.php");
include_once("includes/Funciones.php");
include_once("includes/Seguridad.php");

$ids = array();
$textos = array();
$datos = array();

$conexion = new Conexion();
$conexion->abrir_conexion();
$conn = $conexion->retornar_conexion();
$sql = $conn->prepare('SELECT nombre,precio FROM productos');
$sql->execute();
$resultado = $sql->fetchAll();
foreach($resultado as $fila) {
	$nombre = $fila["nombre"];
	$precio = $fila["precio"];
	array_push($textos,$nombre);
	array_push($datos,$precio);
}

$nombres = array();
$series  = array();

for ($i = 0; $i <= count($textos) - 1; $i++) {
    
    $nombre = $textos[$i];
    $valor  = $datos[$i];
    $serie  = array(
        'name' => $nombre,
        'y' => (int) $valor
    );
    array_push($nombres, $nombre);
    array_push($series, $serie);
}

$conexion->cerrar_conexion();

?>

	<script type="text/javascript">
	$(function () {
	    $('#grafico1').highcharts({
	        chart: {
	            type: 'bar'
	        },
	        title: {
	            text: 'Reporte de productos y sus precios'
	        },
	        xAxis: {
	            categories: <?php echo json_encode($nombres); ?>,
	            title: {
	            text: 'Productos'
	            }
	        },
	                
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Precios',
	                align: 'high'
	            },
	            labels: {
	                overflow: 'justify'
	            }
	        },
	        tooltip: {
	        useHTML: true,
	        formatter: function() {
	            return '<b>Precio : </b>$'+this.point.y;
	        }},
	        plotOptions: {
	        
	        series: {
	            dataLabels:{
	                //enabled:true,
	            },events: {
	                legendItemClick: function () {
	                        return false; 
	                }
	            }
	        }
	          },
	        legend: {
	            reversed: true
	        },
	        credits: {
	            enabled: false
	        },
	        series: [{
	        name:'Precios',
	        data: <?php
	            echo json_encode($series);
	?>
	 }]
	    });
	});
	</script>    

	<div id="grafico1" style="width: 800px; height: 400px;"></div>
	</div>
</div>