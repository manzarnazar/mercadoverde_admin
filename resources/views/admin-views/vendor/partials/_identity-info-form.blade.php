@php
    $identityDocuments = [
        [
            'name' => 'tin_certificate_image',
            'label' => translate('CURP/RFC'),
            'restrictions' => translate('JPG, JPEG, PNG, PDF. Max 2 MB'),
            'accept' => '.pdf,.jpg,.png,.jpeg',
            'url_attr' => 'tin_certificate_image_full_url',
            'file_attr' => 'tin_certificate_image',
        ],
        [
            'name' => 'ine_image',
            'label' => translate('INE (Mexican national ID) - Front'),
            'restrictions' => translate('JPG, JPEG, PNG. Max 2 MB'),
            'accept' => '.jpg,.png,.jpeg',
            'url_attr' => 'ine_image_full_url',
            'file_attr' => 'ine_image',
        ],
        [
            'name' => 'ine_back_image',
            'label' => translate('INE (Mexican national ID) - Back'),
            'restrictions' => translate('JPG, JPEG, PNG. Max 2 MB'),
            'accept' => '.jpg,.png,.jpeg',
            'url_attr' => 'ine_back_image_full_url',
            'file_attr' => 'ine_back_image',
        ],
        [
            'name' => 'cofepris_document_image',
            'label' => translate('COFEPRIS') . ' (' . translate('messages.optional') . ')',
            'restrictions' => translate('JPG, JPEG, PNG, PDF. Max 2 MB'),
            'accept' => '.pdf,.jpg,.png,.jpeg',
            'url_attr' => 'cofepris_document_image_full_url',
            'file_attr' => 'cofepris_document_image',
            'optional' => true,
        ],
    ];
    $isEdit = isset($store);
@endphp
<div class="col-lg-12" id="identity-info-assets"
    data-picture-icon="{{ asset('public/assets/admin/img/picture.svg') }}"
    data-document-icon="{{ asset('public/assets/admin/img/document.svg') }}"
    data-blank-thumbnail="{{ asset('public/assets/admin/img/picture.svg') }}">
    <div>
        <div class="card p-20">
            <div class="mb-20">
                <h3 class="mb-1">{{ translate('Identity_Info') }}</h3>
            </div>
            <div class="row g-3">
                @foreach ($identityDocuments as $document)
                    @php
                        $fileUrl = $isEdit ? ($store->{$document['url_attr']} ?? null) : null;
                        $fileName = $isEdit ? ($store->{$document['file_attr']} ?? null) : null;
                        $hasFile = $isEdit && $fileName;
                    @endphp
                    <div class="col-md-6 col-xl-3">
                        <div class="bg--secondary rounded p-20 h-100 single-document-uploaderwrap">
                            <div class="d-flex align-items-center gap-1 justify-content-between mb-20">
                                <div>
                                    <h4 class="mb-1 fz--14px">
                                        {{ $document['label'] }}
                                        @if (empty($document['optional']))
                                            <span class="text-danger">*</span>
                                        @endif
                                    </h4>
                                    <p class="fz-12px mb-0">{{ $document['restrictions'] }}</p>
                                </div>
                                @if ($isEdit && $hasFile)
                                    <div class="d-flex gap-3 align-items-center">
                                        <button type="button"
                                            class="w-30px h-30 rounded d-flex align-items-center justify-content-center btn--primary btn px-3 icon-btn identity-doc-edit-btn"
                                            data-target="{{ $document['name'] }}">
                                            <i class="tio-edit"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group error-wrapper mb-0">
                                <div class="d-flex justify-content-center" id="pdf-container-{{ $document['name'] }}">
                                    <div class="document-upload-wrapper {{ $hasFile ? 'd-none' : '' }}"
                                        id="doc-upload-wrapper-{{ $document['name'] }}">
                                        <input type="file" name="{{ $document['name'] }}" id="{{ $document['name'] }}"
                                            class="document_input identity-document-input" accept="{{ $document['accept'] }}"
                                            data-max-size="2mb">
                                        <div class="textbox">
                                            <img width="40" height="40" class="svg"
                                                src="{{ asset('public/assets/admin/img/doc-uploaded.png') }}" alt="">
                                            <p class="fs-12 mb-0">
                                                {{ translate('messages.Select_a_file_or') }}
                                                <span class="font-semibold">{{ translate('messages.Drag & Drop') }}</span>
                                                {{ translate('messages.here') }}
                                            </p>
                                        </div>
                                    </div>
                                    @if ($hasFile)
                                        <div class="pdf-single" data-file-name="{{ $fileName }}"
                                            data-file-url="{{ $fileUrl ?? asset('public/assets/admin/img/upload-cloud.png') }}">
                                            <div class="pdf-frame">
                                                @php($imgPath = $fileUrl ?? asset('public/assets/admin/img/upload-cloud.png'))
                                                @if (Str::endsWith(strtolower($fileName ?? ''), ['.pdf', '.doc', '.docx']))
                                                    @php($imgPath = asset('public/assets/admin/img/document.svg'))
                                                @endif
                                                <img class="pdf-thumbnail-alt" src="{{ $imgPath }}" alt="File Thumbnail">
                                            </div>
                                            <div class="overlay">
                                                <div class="pdf-info">
                                                    @if (Str::endsWith(strtolower($fileName ?? ''), ['.pdf', '.doc', '.docx']))
                                                        <img src="{{ asset('public/assets/admin/img/document.svg') }}"
                                                            width="34" alt="File Type Logo">
                                                    @else
                                                        <img src="{{ asset('public/assets/admin/img/picture.svg') }}"
                                                            width="34" alt="File Type Logo">
                                                    @endif
                                                    <div class="file-name-wrapper">
                                                        <span class="file-name js-filename-truncate">{{ $fileName }}</span>
                                                        <span class="opacity-50">{{ translate('Click to view the file') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if (!empty($document['optional']))
                                    <a href="https://www.instagram.com/a.canna.mex" target="_blank" rel="noopener noreferrer"
                                        class="fz-12px text--primary mt-2 d-inline-block">
                                        {{ translate('Get COFEPRIS') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
