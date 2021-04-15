<legend><h3><center><?php echo $titulo; ?></center></h3></legend>

<div class="container">
    <?php if(validation_errors()){ ?>
        <div class='alert alert alert-error' align=center>
            <a class='close' data-dismiss='alert'>×</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>
</div>

<div class="container">

    <div class=<?php echo "tabla-div-".$clase."\""; ?>">
        <table id=<?php echo "tabla-".$clase; ?> class="table table-bordered table-striped dataTable">

            <thead>
            <tr>
                <?php 
                    foreach($titulos as $titulo) { 
                        echo "<th>".$titulo."</th>";
                    } 
                ?> 
            </tr>
            </thead>
            <tbody>
            </tbody>

        </table>

    </div>
    <br>
    <div align="right">
        <?php 
            if(isset($botones)){
                foreach ($botones as $boton) {  
                echo "<a class='btn btn-".$boton['tipo']."' id='".$boton['id']."'>".$boton['texto']."</a>";}
        } ?>
        
    </div>
    <div id="detalle">
    </div>

</div>
