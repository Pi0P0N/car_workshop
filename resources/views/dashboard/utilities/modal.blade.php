<div class="modal fade" id="{{ $modalId ?? 'genericModal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalLabelId ?? 'genericModalLabel' }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalLabelId ?? 'genericModalLabel' }}">{{ $modalTitle ?? 'Modal title' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $modalContent ?? '' }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                <button type="submit" class="btn {{ $buttonStyle ?? 'btn-primary' }}" onclick="event.preventDefault(); document.getElementById('{{ $formId }}').submit();">{{ $modalSaveText }}</button>
            </div>
        </div>
    </div>
</div>