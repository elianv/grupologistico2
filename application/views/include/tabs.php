<div class="container">

<h3><center>Orden de Servicio</center></h3>

<ul class="nav nav-tabs">
  <li <?php if($active == 'exportacion'){ echo "class='active'"; }?> >
      <a href="#">Exportación</a>
  </li>

  <li <?php if($active == 'importacion'){ echo "class='active'"; }?>>
    <a href="#">Importación</a>
  </li>
  
  <li <?php if($active == 'nacional'){ echo "class='active'"; }?>>
      <a>Nacional</a>
  </li>

  <li <?php if($active == 'otros'){ echo "class='active'"; }?>>
      <a>Otros Servicios</a>
  </li>
</ul>
</div>
