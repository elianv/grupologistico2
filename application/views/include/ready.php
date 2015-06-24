<script>

window.onload = function() {
  var selected = document.getElementById("tipo_factura");
  var checked = document.getElementById("check_tramo");

  if (selected.value == "OTRO SERVICIO"){
  		checked.style.display = "";
  }
  else{
  		checked.style.display = "none";
  }

}

</script>