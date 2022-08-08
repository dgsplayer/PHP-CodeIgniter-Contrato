
<style type="text/css">    #warning-message { display: none; }    @media only screen and (orientation:portrait){        #wrapper { display:none; }        #warning-message { display:block; }    }    @media only screen and (orientation:landscape){        #warning-message { display:none; }    }
</style>
<div id="warning-message">    
<h1>Deixe seu celular no modo Paisagem para visualizar melhor esta tela
</h1>    
<BR>
<BR>
</div>
<div class="col-md-10">    
<div class="content">        
<div class="main-header">            
<h2>Assinatura da Empresa
</h2>            
<em>abaixo informações sobre a assinatura da sua empresa que será registrada nos documentos do sistema
</em>        
</div>        
<div class="main-content">            
<div class="widget">                
<div class="widget-content">                    
<div class="span-conteudo-miolo">                        
<div id="wizard" class="swMain">                            
<div>                                  
<?php if(!empty($cliente->imagem_assinatura) && file_exists(BASEPATH . '../recursos/imagens/upload_assinaturas/'.$cliente->imagem_assinatura)){ ?>                            
<div>                                              
<h4>- ASSINATURA ATUAL:
</h4>                                        
<? echo '
<img  style="width: 40%" src="../recursos/imagens/upload_assinaturas/'.$cliente->imagem_assinatura.'">'; ?>        
<BR>
<button id="delete" class="btn btn-danger btn-sm">
Apagar
</button>
<BR>                            
</div>                                
<?php } ?>
                            
<BR>                                
<div id="jsDesenho" class="jsDesenho">                                    
<h4>- FAÇA A ASSINATURA NO QUADRO ABAIXO:
</h4>                                    
<div class="alert alert-info">                                        
<strong>Importante:
</strong> é recomendado que a assinatura seja sempre feita em um dispositivo móvel (Celular ou Tablet), utilizando uma caneta especial.                                    
</div>                                    
<div style="height: 150px !important; width: 400px !important;">                                        
<canvas id="test" style="border: 1px solid #008000; "  >
</canvas>                                        
<div class="links" style="margin-top: 5px;">                                            
<a href="#jsDesenho"  id="jqClear">Limpar
</a>&nbsp;|&nbsp;                                            
<button class="btn-link" id="jqSave">Salvar
</button>                                        
</div>                                    
</div>                                    
<BR>
<BR>                                
</div>                            
</div>                        
</div>                    
</div>                
</div>            
</div>        
</div>    
</div>
</div>
<script src="<?php echo base_url('recursos/assets/js/jqScribble-master/jquery.jqscribble.js'); ?>">
</script>
<script src="<?php echo base_url('recursos/assets/js/jqScribble-master/jqscribble.extrabrushes.js'); ?>">
</script>
<script type="text/javascript">    
base_url = '<?=base_url()?>';

$(document).ready(function($) {        
  $('#jqSave').click(function(){            
    var resp;            
    resp = confirm("Sua assinatura será atualizada agora. Deseja continuar?");            
    if( resp == true ){                
      $("#test").data("jqScribble").save(function(imageData){                    
      $.ajax({                       
         type: "POST",                        
      url: base_url + "administrador/ajax_salva_assinatura",                        
      data:{imagedata: imageData},                        
      dataType: "text",                        
      cache:false,                        
      success:                            
      function(data){                                
        alert('Assinatura gravada com sucesso.');
        //window.location='contratonet.com.br/painel/administrador/assinatura';
        location.reload();                            
        }                    
        });                
        });            
        }
        else{                
          return false;            }        
        
        });       

        $('#delete').click(function(){            
          var resp;            
          resp = confirm("Deseja continuar a exclusão?");            
          if( resp == true ){                
                          
            $.ajax({                       
              type: "POST",                        
              url: base_url + "administrador/ajax_remove_assinatura",                           
              dataType: "text",                        
              cache:false,                        
              success:                            
              function(data){                                
                // alert('Assinatura gravada com sucesso.');
                //window.location='contratonet.com.br/painel/administrador/assinatura';
                location.reload();                            
                }                    
              });              
              }
          else{                
            return false;            }        
          
        });      


        $("#test").jqScribble();        
        
        $("#jqClear").click(function(){            
          $("#test").data("jqScribble").clear();       
           });    
    });
</script>