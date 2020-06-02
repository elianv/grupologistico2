<style>

@import url(https://fonts.googleapis.com/css?family=Roboto:300,400);
    body {
      height: 100%;
      padding: 0px;
      margin: 0px;
      background: #333;
      font-family: 'Roboto', sans-serif !important;
      font-size: 1em;
    }
    h1{
      font-family: 'Roboto', sans-serif;
      font-size: 30px;
      color: #999;
      font-weight: 300;
      margin-bottom: 55px;
      margin-top: 45px;
      text-transform: uppercase;
    }
    h1 small{
      display: block;
      font-size: 18px;
      text-transform: none;
      letter-spacing: 1.5px;
      margin-top: 12px;
    }
    .row{
      max-width: 950px;
      margin: 0 auto;
    }
    .btn{
      white-space: normal;
    }
    .button-wrap {
      position: relative;
      text-align: center;
      .btn {
        font-family: 'Roboto', sans-serif;
        box-shadow: 0 0 15px 5px rgba(0, 0, 0, 0.5);
        border-radius: 0px;
        border-color: #222;
        cursor: pointer;
        text-transform: uppercase;
        font-size: 1.1em;
        font-weight: 400;
        letter-spacing: 1px;
        small {
          font-size: 0.8rem;
          letter-spacing: normal;
          text-transform: none;
        }
      }
    }


    /** SPINNER CREATION **/

    .loader {
      position: relative;
      text-align: center;
      margin: 15px auto 35px auto;
      z-index: 9999;
      display: block;
      width: 80px;
      height: 80px;
      border: 10px solid rgba(0, 0, 0, .3);
      border-radius: 50%;
      border-top-color: #000;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to {
        -webkit-transform: rotate(360deg);
      }
    }

    @-webkit-keyframes spin {
      to {
        -webkit-transform: rotate(360deg);
      }
    }


    /** MODAL STYLING **/

    .modal-content {
      border-radius: 0px;
      box-shadow: 0 0 20px 8px rgba(0, 0, 0, 0.7);
    }

    .modal-backdrop.show {
      opacity: 0.75;
    }

    .loader-txt {
      p {
        font-size: 13px;
        color: #666;
        small {
          font-size: 11.5px;
          color: #999;
        }
      }
    }

    #output {
      padding: 25px 15px;
      background: #222;
      border: 1px solid #222;
      max-width: 350px;
      margin: 35px auto;
      font-family: 'Roboto', sans-serif !important;
      p.subtle {
        color: #555;
        font-style: italic;
        font-family: 'Roboto', sans-serif !important;
      }
      h4 {
        font-weight: 300 !important;
        font-size: 1.1em;
        font-family: 'Roboto', sans-serif !important;
      }
      p {
        font-family: 'Roboto', sans-serif !important;
        font-size: 0.9em;
        b {
          text-transform: uppercase;
          text-decoration: underline;
        }
      }
    }
    
</style>

<div class="container">
	
    <div class="row">

        <div class="col-md-2"></div>
        <div class="col-md-8" align="center">
            <legend><h3><center><?php echo $titulo; ?> </center></h3></legend>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">

        <div class="col-md-2"></div>
        <div class="col-md-8" align="center" style="margin-left: 10px">
            <?php 
                if(validation_errors()){
                    echo "<div class='alert alert-info '>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo validation_errors();
                    echo "</div>";
                } 
            ?>
            <?php
                $correcto = $this->session->flashdata('sin_orden');
                if ($correcto){
                    echo "<div class='alert alert-error'>";
                    echo "<a class='close' data-dismiss='alert'>×</a>";
                    echo "<span id='registroCorrecto'>".$correcto."</span>";
                    echo "</div>";
                }
            ?>            
        </div>
        <div class="col-md-2"></div>
    </div>    

    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data" id="from_upfiles">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="control-group">
                    <label class="control-label" ><strong>Cliente</strong></label>
                    <div class="controls">
                        <select input type='text' class='span5' id='cliente' name='cliente'>
                        <?php
                        echo '<pre>';
                            foreach ($clientes as $key => $value) {
                                echo '<option value="'.$value['rut_cliente'].'">'.$value['razon_social'].'</option>';
                            }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" ><strong>Archivos</strong></label>
                    <div class="controls">
                        <input type="file" id="orden_file" name="orden_file[]" multiple>
                        <input type="hidden" id="file" name="file">
                    </div>
                </div>            
            </div>
            <div class="col-md-2"></div>
        </div>
    
        <div class="row">
            <div class="form-actions" >
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <input type="submit" class="btn btn-success" value="Cargar" id="form_submit"/>
                    <input type="submit" class="btn" value="Volver"/>
                </div>
                <div class="col-md-2">

                </div>
            </div>    
        </div>
    </form>

    <?php if($result) echo $result; ?>    
    
    <!-- MODAL PARA LA CARGA -->
    <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-body text-center">
            <div class="loader"></div>
            <div clas="loader-txt">
                <center><p>Se estan cargando las ordenes.<br><br><small>Favor sea paciente...</small></p></center>
            </div>
          </div>
        </div>
      </div>
    </div>       
    
</div>

<script>
    $('#cliente').change(function(){
        var cliente = $(this).children("option:selected").val();
        console.log(cliente)
    });
    
    $('#form_submit').click(function(e){
        e.preventDefault();
        console.log('Sending form');
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
        $('#from_upfiles').submit();
        
    })
</script>
