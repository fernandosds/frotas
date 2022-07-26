<!-- Modal -->
<div class="modal fade" id="modalGrid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Insira o período</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form kt-form--label-right" id="form-grid">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputName">Data Inicial</label>
                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="first_date">
                        </div>
                        <div class="form-group col-md-6" id="reloadOption">
                            <label for="">Data Final</label>
                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="last_date">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="">&nbsp;</label>
                            <br>
                            <button type="button" id="btn-grid" class="btn btn-outline-brand btn-elevate btn-icon" data-toggle="modal"  data-backdrop="static">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <hr />
            <div class="center" id="list_grid">
                <div id="message">
                    <h4>Selecione um período.</h4>
                </div>
                <div class="center" id="response"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
