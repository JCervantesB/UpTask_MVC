<?php include_once __DIR__ . '/header-dashboard.php' ?>
    <?php setlocale(LC_TIME,"es_MX"); ?>
    <?php if(count($proyectos) === 0) { ?>
        <p class="no-proyectos">No hay proyectos aún <a href="/crear-proyecto">Comienza creando uno</a></p>
    <?php } else { ?>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto) { ?>                
                <div class="caja">
                    <a href="/proyecto?id=<?php echo $proyecto->url; ?>">
                    <div class="fecha"><?php echo date("M-d-Y", strtotime($proyecto->fecha)); ?></div>
                        <li class="proyecto">
                            <?php echo $proyecto->proyecto; ?>
                        </li>
                        <div class="estado">
                            <div class="barra-progreso-texto"><p>Progreso:</p></div>
                            <div class="barra-progreso">                            
                                <div class="progreso"></div>
                            </div>
                        </div>
                    </a>
                    
                </div>
            <?php } ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>