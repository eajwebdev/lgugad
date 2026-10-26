<div class="modal fade" id="modal-idcards" tabindex="-1" role="dialog" aria-labelledby="modal-idcards-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" action="{{ route('citizenIdCards') }}" method="POST" target="_blank" id="idCardForm">
            @csrf
            <div class="modal-header">
                <h2 class="modal-title h6" id="modal-idcards-title">
                    <i class="fas fa-id-card" aria-hidden="true"></i> Generate Senior Citizen ID cards
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="mb-3" id="idCardSummary"></p>
                <div id="idCardIds"></div>

                <div class="form-group">
                    <label for="idCardDateIssued">Date issued</label>
                    <input type="date" name="date_issued" id="idCardDateIssued" value="{{ now()->format('Y-m-d') }}" class="form-control form-control-sm" required>
                </div>

                <div class="custom-control custom-checkbox mb-2">
                    <input type="hidden" name="photos" value="0">
                    <input type="checkbox" class="custom-control-input" id="idCardPhotos" name="photos" value="1" checked>
                    <label class="custom-control-label font-weight-normal" for="idCardPhotos">Print profile photos in the 1x1 box (when uploaded)</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="back" value="0">
                    <input type="checkbox" class="custom-control-input" id="idCardBack" name="back" value="1" checked>
                    <label class="custom-control-label font-weight-normal" for="idCardBack">Add a back page after each sheet (RA 9994 benefits) for two-sided printing</label>
                </div>
                <p class="small text-muted mt-3 mb-0">Print on long bond (8.5" × 13") at 100% scale. For two-sided printing, flip on the long edge.</p>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-pdf" aria-hidden="true"></i> Generate PDF
                </button>
            </div>
        </form>
    </div>
</div>
