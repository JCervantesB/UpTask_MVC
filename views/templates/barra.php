<div class="barra">
    <div class="usuario">
        <div class="usuario-inicial">
        <a href="/perfil"><p><?php echo substr($_SESSION['nombre'], 0, 2);?></p></a>
        </div>
        <div class="usuario-datos">
            <p class="usuario-nombre"><?php echo $_SESSION['nombre']; ?></p>
            <p class="usuario-correo"><?php echo $_SESSION['email']; ?></p>
        </div>
    </div>

    <a class="cerrar-sesion" href="/logout">Cerrar Sesión</a>
</div>