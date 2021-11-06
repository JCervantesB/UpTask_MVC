<div class="barra">
    <div class="usuario">
        <div class="usuario-inicial">
        <p><?php echo substr($_SESSION['nombre'], 0, 2);?></p>
        </div>
        <p class="usuario-nombre"><?php echo $_SESSION['nombre']; ?></p>
    </div>

    <a class="cerrar-sesion" href="/logout">Cerrar Sesión</a>
</div>