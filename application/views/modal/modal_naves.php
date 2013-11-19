
<div id="modal" class="modal hide fade in" style="display: none;" >
    <div class="modal-header">
        <a data-dismiss="modal" class="close">×</a>
        <h3><center>Seleccione una Naviera</center></h3>
     </div>
    <form method="post">
     <div class="modal-body">
         <div class="modal-naves">
		<div class="span">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="modal-example">
                      <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre Naviera</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              foreach ($navieras as $tabla){
                                  echo "<tr>";
                                  if($tabla['codigo_naviera'] < 10){
                                      echo "<td><a class='codigo-click' data-codigo=".$tabla['codigo_naviera'].">0".$tabla['codigo_naviera']."</a></td>";
                                  }
                                  else{
                                      echo "<td><a class='codigo-click' data-codigo='codigo_naviera'>".$tabla['codigo_naviera']."</a></td>";
                                  }
                                  
                                  echo "<td>".strtoupper($tabla['nombre'])."</td>";
                                  echo "</tr>";
                              }
                              ?>
                       </tbody>
                  </table>    
       </div>	 
	 </div>
		 
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        
    </div>
        </form>
</div>