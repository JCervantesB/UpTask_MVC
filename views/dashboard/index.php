<?php include_once __DIR__ . '/header-dashboard.php' ?>
<?php use Model\Tarea; ?>
    <?php setlocale(LC_TIME,"es_MX"); ?>
    <?php if(count($proyectos) === 0) { ?>
        <p class="no-proyectos">No hay proyectos aún <a href="/crear-proyecto">Comienza creando uno</a></p>
    <?php } else { ?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto) { ?>                 
                <div class="caja">
                    <a href="/proyecto?id=<?php echo $proyecto->url; ?>">                    
                        <li class="proyecto">
                            <?php echo $proyecto->proyecto; ?>
                        </li>
                    </a>                    
                </div>               
            <?php } ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>