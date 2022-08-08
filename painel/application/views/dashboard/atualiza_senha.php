<div class="main-header">    <h2>Alterar minha senha</h2>    <em>preencha os campos abaixo para alterar sua senha</em></div><?php echo form_open( '/dashboard/processa_senha', array('class' => 'form-horizontal label-left', 'role' => 'form', 'method'=>'post') ); ?><div class="widget pessoa-fisica">    <div class="widget-header">        <h3><i class="fa fa-edit"></i> Alteração de Senha</h3>    </div>    <div class="widget-content">        <div class="form-group">            <label class="col-sm-2 control-label">Nova Senha</label>            <div class="col-sm-4">                <?php echo form_password(array('name'=>'senha', 'id'=>'senha', 'maxlength'=>'8', 'required' => 'required', 'autocomplete'=> 'off', 'class' => 'form-control'), 'autofocus')?>                <?php echo form_error('senha'); ?>                (Máximo 8 caracteres)            </div>        </div>        <div class="form-group">            <label class="col-sm-2 control-label">Confirma Nova Senha</label>            <div class="col-sm-4">                <?php echo form_password(array('name'=>'senhaConfirma', 'id'=>'senhaConfirma', 'maxlength'=>'8', 'required' => 'required', 'autocomplete'=> 'off', 'class' => 'form-control'))?>                <?php echo form_error('senhaConfirma'); ?>            </div>        </div>    </div></div><button class="btn btn-primary" type="submit">Alterar</button><?php echo form_close(); ?><script>    $(document).ready(function(){        $('.btn').click(function(){           if($('#senha').val() != $('#senhaConfirma').val()){               alert('Senha não confere com campo Confirmar Senha');               return false;           }        });    });</script>