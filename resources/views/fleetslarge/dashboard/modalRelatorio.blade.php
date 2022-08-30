<div class="modal fade" id="modalRelatorio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width: 600px;">
    <div class="modal-dialog modal-personalizado" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Relatório Telemetria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label><b>Data de entrada:</b></label>
                        <div class="input-group">
                            <input type="text" name="dates" id="reportrange" class="form-control" readonly="" placeholder="Período de datas">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button style="text-decoration: none;" class="btn-success">Gerar relatório</button>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>