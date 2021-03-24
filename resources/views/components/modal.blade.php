<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
    
    <div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $label }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $label }}">{{ $header }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</div>
