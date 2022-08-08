<?php $this->load->helper('funcoes'); ?>
<div class="main-header">
    <div class="col-md-12">
        <div class="top-content">
            <ul class="list-inline quick-access">
                <li>
                    <a href="<?php echo base_url('contract'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Contrato dos clientes cadastrados</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('contract/vinc_cliente'); ?>">
                        <div class="quick-access-item bg-color-green">
                            <i class="fa fa-clipboard"></i>
                            <h5>Vincular contrato com cliente</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('contract/index_fornecedor'); ?>">
                        <div class="quick-access-item bg-color-blue">
                            <i class="fa fa-clipboard"></i>
                            <h5>Contrato dos fornecedores cadastrados</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('contract/vinc_fornecedor'); ?>">
                        <div class="quick-access-item bg-color-blue">
                            <i class="fa fa-clipboard"></i>
                            <h5>Vincular contrato com fornecedor</h5>
                        </div>
                    </a>
                </li><BR><BR>
                <li>
                    <a href="<?php echo base_url('contract/empresas'); ?>">
                        <div class="quick-access-item bg-color-yellow">
                            <i class="fa fa-clipboard"></i>
                            <h5>Empresas</h5>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('contract/bancos'); ?>">
                        <div class="quick-access-item bg-color-orange">
                            <i class="fa fa-clipboard"></i>
                            <h5>Bancos</h5>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>
    <?php echo $output; ?>
</div>