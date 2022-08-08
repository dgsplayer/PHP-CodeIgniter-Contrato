<?php echo $this->load->helper('date'); ?>
<?php echo $this->load->helper('funcoes'); ?>

<div class="main-header">
    <div class="col-md-5">
        <h2>Lista de Usuários</h2>
        <em>Lista de todos os usuários cadastrados</em>
    </div>
    <div class="col-md-7">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('administrador/cadastro'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Novo Usuário</h5>
                            <em>Clique aqui para cadastrar novo usuário</em>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="widget widget-table">
    <div class="widget-header">
        <h3><i class="fa fa-table"></i>Usuários</h3>
    </div>
    <div class="widget-content">

        <?php if($mensagem = $this->session->flashdata("sucesso")) { 	?>
        <div class="alert alert-success bg-success text-center">
            <?php echo $mensagem; ?>
        </div>
        <?php } ?>

        <table class="table table-sorting table-striped table-hover datatable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <tr>
<!--                <th>Login</th>-->
                <th>Email</th>
                <th>Última Atualização</th>
                <th>Status</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach( $usuarios as $usuario ) { ?>
            <tr>
<!--                <td><a href="--><?php //echo base_url('administrador/cadastro/' . $usuario->id_usuario ); ?><!--">--><?php //echo $usuario->login; ?><!--</a></td>-->
                <td><a href="<?php echo base_url('administrador/cadastro/' . $usuario->id_usuario ); ?>"><?php echo $usuario->email; ?></a></td>
                <td><a href="<?php echo base_url('administrador/cadastro/' . $usuario->id_usuario ); ?>"><?php echo parseDate($usuario->data_atualizacao,'both'); ?></a></td>
                <td><a href="<?php echo base_url('administrador/cadastro/' . $usuario->id_usuario ); ?>"><?php echo  converteStatus($usuario->ativo); ?></a></td>
                <td>
                    <a href="<?php echo base_url('administrador/cadastro/' . $usuario->id_usuario ); ?>" class="btn btn-custom-secondary btn-sm"><i class="fa fa-binoculars"></i> Visualizar</a>
                </td>
            </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/datatable/jquery.dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('recursos/assets/js/king-table.js'); ?>"></script>