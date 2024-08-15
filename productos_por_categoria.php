<?php include("template/cabecera.php"); ?>
<?php include("administrador/config/bd.php"); 

$idCategoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : "";

if (empty($idCategoria)) {
    echo "ID de categoria no proporcionado";
    exit;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM producto WHERE id_categoria = :id_categoria");
$sentenciaSQL->bindParam(':id_categoria', $idCategoria, PDO::PARAM_INT);
$sentenciaSQL->execute();
$listaProducto = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

if (empty($listaProducto)) {
    echo "No hay productos para esta categoria";
    exit;
}
?>

<div class="container">
    <h1>Productos</h1>
    <div class="row">
        <?php foreach ($listaProducto as $producto) { ?>
            <div class="col-md-3">
                <div class="card">
                    <img class="card-img-top" src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h4>
                        <form action="agregar_carrito.php" method="POST">
                            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['producto_id']); ?>">
                            <input type="number" name="cantidad" value="1" min="1" class="form-control mb-2">
                            <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include("template/pie.php"); ?>