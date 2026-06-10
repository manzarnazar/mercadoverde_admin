"use strict";
$(document).ready(function () {
    const fileAssets = $("#identity-info-assets");
    const pictureIcon = fileAssets.data("picture-icon");
    const documentIcon = fileAssets.data("document-icon");
    const blankThumbnail = fileAssets.data("blank-thumbnail");

    function getContainer(input) {
        const fieldName = $(input).attr("name");
        return $("#pdf-container-" + fieldName);
    }

    function getUploadWrapper(input) {
        const fieldName = $(input).attr("name");
        return $("#doc-upload-wrapper-" + fieldName);
    }

    function validateFile(input, file) {
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            if (typeof toastr !== "undefined") {
                toastr.error("File size must be less than 2 MB");
            }
            return false;
        }

        let acceptAttr = $(input).attr("accept") || "";
        const validTypes = acceptAttr
            ? acceptAttr.split(",").map((type) => type.trim().toLowerCase())
            : [".jpg", ".jpeg", ".png"];

        const fileType = file.type.toLowerCase();
        const fileExt = "." + file.name.split(".").pop().toLowerCase();

        const isValidType = validTypes.some((type) => {
            if (type.startsWith("image/") || type.includes("/")) {
                return fileType === type;
            }
            return fileExt === type;
        });

        if (!isValidType) {
            if (typeof toastr !== "undefined") {
                toastr.error("Invalid file type.");
            }
            return false;
        }

        return true;
    }

    function renderPreview(container, file) {
        const fileURL = URL.createObjectURL(file);
        const fileType = file.type;
        const iconSrc = fileType.startsWith("image/") ? pictureIcon : documentIcon;
        const thumbnailSrc = fileType.startsWith("image/") ? fileURL : blankThumbnail;

        container.find(".pdf-single").remove();

        const pdfSingle = $(`
            <div class="pdf-single" data-file-name="${file.name}" data-file-url="${fileURL}">
                <div class="pdf-frame">
                    <img class="pdf-thumbnail-alt" src="${thumbnailSrc}" alt="File Thumbnail">
                </div>
                <div class="overlay">
                    <div class="pdf-info">
                        <img src="${iconSrc}" width="34" alt="File Type Logo">
                        <div class="file-name-wrapper">
                            <span class="file-name js-filename-truncate">${file.name}</span>
                            <span class="opacity-50">Click to view the file</span>
                        </div>
                    </div>
                </div>
            </div>
        `);

        container.append(pdfSingle);
    }

    $(".identity-document-input").on("change", function () {
        const input = this;
        const file = input.files[0];
        if (!file) return;

        if (!validateFile(input, file)) {
            $(input).val("");
            return;
        }

        const container = getContainer(input);
        const uploadWrapper = getUploadWrapper(input);

        renderPreview(container, file);
        uploadWrapper.addClass("d-none");
    });

    $(".identity-doc-edit-btn").on("click", function () {
        const fieldName = $(this).data("target");
        const input = $("#" + fieldName);
        const container = $("#pdf-container-" + fieldName);
        const uploadWrapper = $("#doc-upload-wrapper-" + fieldName);

        input.val("");
        container.find(".pdf-single").remove();
        uploadWrapper.removeClass("d-none");
        input[0].click();
    });

    $(document).on("click", "[id^='pdf-container-'] .pdf-single", function () {
        const fileURL = $(this).data("file-url");
        if (fileURL) {
            window.open(fileURL, "_blank");
        }
    });

    $("#reset_btn").on("click", function () {
        $(".identity-document-input").val("");
        $("[id^='pdf-container-']").find(".pdf-single").remove();
        $("[id^='doc-upload-wrapper-']").removeClass("d-none");
    });
});
