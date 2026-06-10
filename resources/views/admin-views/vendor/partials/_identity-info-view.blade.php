@php
    $identityDocuments = [
        [
            'label' => translate('CURP/RFC'),
            'url_attr' => 'tin_certificate_image_full_url',
            'file_attr' => 'tin_certificate_image',
        ],
        [
            'label' => translate('INE (Mexican national ID) - Front'),
            'url_attr' => 'ine_image_full_url',
            'file_attr' => 'ine_image',
        ],
        [
            'label' => translate('INE (Mexican national ID) - Back'),
            'url_attr' => 'ine_back_image_full_url',
            'file_attr' => 'ine_back_image',
        ],
        [
            'label' => translate('COFEPRIS'),
            'url_attr' => 'cofepris_document_image_full_url',
            'file_attr' => 'cofepris_document_image',
        ],
    ];
    $hasIdentityDocs = $store->tin_certificate_image
        || $store->ine_image
        || $store->ine_back_image
        || $store->cofepris_document_image
        || $store->tin;
@endphp
@if ($hasIdentityDocs)
    <div class="row pt-3 g-3">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title m-0 d-flex align-items-center">
                        <span class="card-header-icon mr-2">
                            <i class="tio-user"></i>
                        </span>
                        <span class="ml-1">{{ translate('Identity_Info') }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($identityDocuments as $document)
                            @php
                                $fileName = $store->{$document['file_attr']} ?? null;
                                $fileUrl = $fileName ? ($store->{$document['url_attr']} ?? null) : null;
                            @endphp
                            @if ($fileName)
                                <div class="col-md-6 col-xl-3">
                                    <p class="mb-2 fw-semibold">{{ $document['label'] }}</p>
                                    <div class="pdf-single cus-document-responsive"
                                        data-pdf-url="{{ $fileUrl ?? asset('public/assets/admin/img/upload-cloud.png') }}">
                                        <div class="pdf-frame">
                                            @php($imgPath = $fileUrl ?? asset('public/assets/admin/img/upload-cloud.png'))
                                            @if (Str::endsWith(strtolower($fileName), ['.pdf', '.doc', '.docx']))
                                                @php($imgPath = asset('public/assets/admin/img/document.svg'))
                                            @endif
                                            <img class="pdf-thumbnail-alt" src="{{ $imgPath }}" alt="File Thumbnail">
                                        </div>
                                        <div class="overlay">
                                            <a href="javascript:void(0);" class="download-btn" title="">
                                                <i class="tio-download-to"></i>
                                            </a>
                                            <div class="pdf-info d-flex gap-10px align-items-center">
                                                @if (Str::endsWith(strtolower($fileName), ['.pdf', '.doc', '.docx']))
                                                    <img src="{{ asset('public/assets/admin/img/document.svg') }}"
                                                        width="34" alt="File Type Logo">
                                                @else
                                                    <img src="{{ asset('public/assets/admin/img/picture.svg') }}"
                                                        width="34" alt="File Type Logo">
                                                @endif
                                                <div class="fs-13 text--title d-flex flex-column">
                                                    <span class="file-name js-filename-truncate">{{ $fileName }}</span>
                                                    <span class="opacity-50">{{ translate('Click to view the file') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
