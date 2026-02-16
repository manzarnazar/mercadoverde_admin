<button class="btn" data-toggle="modal" data-target="#image-{{ $key }}">
    <div class="gallary-card">
        <img class="rounded mx-h150 mx-w-100"
            data-onerror-image="{{ asset('/public/assets/admin/img/900x400/img1.jpg') }}"
            src="{{ $img }}"
            width="275" height="150" alt="">
    </div>
</button>
<div class="modal fade" id="image-{{ $key }}" tabindex="-1" role="dialog"
    aria-labelledby="myModlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModlabel">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span><span
                        class="sr-only">{{ translate('messages.Close') }}</span></button>
            </div>
            <div class="modal-body">
                <img data-onerror-image="{{ asset('/public/assets/admin/img/900x400/img1.jpg') }}"
                    src="{{ $img }}"
                    class="w-100 onerror-image">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
