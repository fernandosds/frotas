<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalTickets" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Histórico de Atendimentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="kt-form kt-form--label-right" id="form-create-history">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Registrar atendimento</label>
                        <textarea class="form-control" name="message" id="formTextArea" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btn-history-save">Salvar Atendimento</button>
                </div>
            </form>
            <div class="modal-body" id="list_history">
                <i class="fa fa-spinner fa-pulse fa-4x"></i>
            </div>
        </div>
    </div>
</div>
