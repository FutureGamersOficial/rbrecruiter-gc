<!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->

<div class="modal fade" tabindex="-1" id="{{$id}}" role="dialog" aria-labelledby="{{$modalLabel}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$modalLabel}}">{{$modalTitle}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">

                {{ $modalFooter }}

                @if ($includeCloseButton == true)
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @endif
            </div>
        </div>
    </div>
</div>
