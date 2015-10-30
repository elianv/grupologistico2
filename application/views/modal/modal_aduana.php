<div id="modal-aduana" class="modal hide fade in" tabindex="-1" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione una A.A.</center></h3>
     </div>
    <form method="post">
     <div class="modal-body">
         
		
                    <table cellpadding="0" class="table table-striped table-bordered" id="tabla-aduana">
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($aduanas as $aduana){
                                  echo "<tr>";
                                  if($aduana['codigo_aduana'] < 10){
                                      echo "<td><a class='codigo-click' data-codigo=".$aduana['codigo_aduana'].">0".$aduana['codigo_aduana']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo=".$aduana['codigo_aduana'].">".$aduana['codigo_aduana']."</a></td>";
                                  }
                                  
                                  echo "<td>".strtoupper($aduana['nombre'])."</td>";
                                  echo "</tr>";
                              }
                              ?>
                       </tbody>
                  </table>    
       	 
	 
		 
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>
        </form>
</div>
