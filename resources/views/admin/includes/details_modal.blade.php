<div class="modal fade view_modal" id="{{ isset($modal_id) ? $modal_id : 'modal_id' }}" tabindex="-1"
    aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">{{ $modal_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="{{ isset($modal_wrap_id) ? $modal_wrap_id : 'modal_wrap_id' }}">
            </div>
        </div>
    </div>
</div>
