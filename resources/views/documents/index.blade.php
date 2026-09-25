<x-app-layout>
    <x-slot name="title">Document</x-slot>

    <div id="flashAlert" class="alert fade mb-5 {{ session('success') ? 'alert-success-soft show' : 'd-none' }}"
        role="alert">
        <span id="flashAlertIcon" class="alert-icon ti-check mr-3"></span>
        <span id="flashAlertMessage">{{ session('success') }}</span>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 mb-1">Documents</h1>
            <p class="text-muted mb-0">
                Organize your documents and files in one place.
            </p>
        </div>

        <button type="button" class="btn btn-primary btn-with-icon" data-toggle="modal"
            data-target="#createDocumentModal">
            <span class="btn-icon ti-plus mr-2"></span>
            New Document
        </button>
    </div>

    <div class="card">
        <div class="card-body pt-0">
            <div id="documentsList">
                <div class="accordion" id="accordionDocuments">
                    @forelse ($documents as $document)
                        <div class="card mb-3" id="documentRow-{{ $document->id }}">
                            <div id="heading-{{ $document->id }}"
                                class="card-header d-flex align-items-center justify-content-between">
                                <h4 class="card-header-title mb-0" aria-expanded="false"
                                    aria-controls="collapse-{{ $document->id }}" data-toggle="collapse"
                                    data-target="#collapse-{{ $document->id }}" style="cursor: pointer;">
                                    <span class="ti-folder mr-2"></span>
                                    <span id="documentName-{{ $document->id }}">{{ $document->name }}</span>
                                    <span class="badge badge-md badge-pill badge-primary-soft ml-2">
                                        {{ $document->documentFiles->count() }}
                                        file{{ $document->documentFiles->count() === 1 ? '' : 's' }}
                                    </span>
                                </h4>

                                <div>
                                    <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm"
                                        data-toggle="modal" data-target="#addFileModal-{{ $document->id }}"
                                        title="Add File">
                                        <span class="btn-icon ti-plus"></span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm ml-2"
                                        data-toggle="collapse" data-target="#addDocumentEditRow-{{ $document->id }}"
                                        data-parent-collapse="#collapse-{{ $document->id }}" aria-expanded="false"
                                        aria-controls="addDocumentEditRow-{{ $document->id }}" title="Edit Document">
                                        <span class="btn-icon ti-pencil-alt"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle btn-with-icon btn-sm ml-2"
                                        data-toggle="modal" data-target="#deleteDocumentModal-{{ $document->id }}"
                                        title="Delete Document">
                                        <span class="btn-icon ti-trash"></span>
                                    </button>
                                </div>
                            </div>

                            <div id="collapse-{{ $document->id }}" class="collapse"
                                aria-labelledby="heading-{{ $document->id }}" data-parent="#accordionDocuments">
                                <div class="card-body">

                                    @forelse ($document->documentFiles as $file)
                                        <div class="media align-items-center py-3 border-bottom" id="fileRow-{{ $file->id }}">
                                            @if ($file->is_image)
                                                <img class="u-avatar-md rounded mr-3" src="{{ $file->url }}"
                                                    alt="{{ $file->file_name }}" style="object-fit: cover;">
                                            @else
                                                <div class="u-icon rounded-circle bg-primary text-white mr-3">
                                                    <span class="ti-file"></span>
                                                </div>
                                            @endif

                                            <div class="media-body">
                                                <h4 class="font-weight-normal mb-0">{{ $file->file_name }}</h4>
                                                <small class="text-muted text-uppercase">.{{ $file->extension }}</small>
                                            </div>

                                            <a href="{{ $file->url }}" download
                                                class="btn btn-sm btn-outline-primary btn-with-icon ml-3">
                                                <span class="btn-icon ti-download mr-2"></span>
                                                Download
                                            </a>
                                            <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm ml-2"
                                                data-toggle="collapse" data-target="#addFileEditRow-{{ $file->id }}"
                                                aria-expanded="false" aria-controls="addFileEditRow-{{ $file->id }}"
                                                title="Edit File">
                                                <span class="btn-icon ti-pencil-alt"></span>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-circle btn-with-icon btn-sm ml-2"
                                                data-toggle="modal" data-target="#deleteFileModal-{{ $file->id }}"
                                                title="Delete File">
                                                <span class="btn-icon ti-trash"></span>
                                            </button>
                                        </div>
                                        <div id="addFileEditRow-{{ $file->id }}" class="collapse mt-3">
                                            <form action="{{ route('document-files.update', [$document, $file]) }}"
                                                method="POST" enctype="multipart/form-data" class="js-edit-file-form">
                                                @method('PATCH')
                                                @csrf
                                                <div class="form-row align-items-end">
                                                    <div class="col-md-4 mb-2 mb-md-0">
                                                        <label class="small text-muted mb-1">File Name</label>
                                                        <input type="text" name="file_name" class="form-control form-control-sm"
                                                            value="{{ $file->file_name }}" placeholder="e.g. Invoice January">
                                                    </div>
                                                    <div class="col-md-5 mb-2 mb-md-0">
                                                        <label class="small text-muted mb-1">File</label>

                                                        <div class="custom-file custom-file-sm">
                                                            <input type="file" name="file" id="fileInput-{{ $file->id }}"
                                                                class="custom-file-input @error('file') is-invalid @enderror"
                                                                onchange="
                                                                                                                        let file = this.files[0];
                                                                                                                        let label = this.nextElementSibling;
                                                                                                                        if (file) {
                                                                                                                            let name = file.name;
                                                                                                                            let dotIndex = name.lastIndexOf('.');
                                                                                                                            let ext = dotIndex !== -1 ? name.substring(dotIndex) : '';
                                                                                                                            let baseName = dotIndex !== -1 ? name.substring(0, dotIndex) : name;
                                                                                                                            let truncated = baseName.length > 10
                                                                                                                                ? baseName.substring(0, 10) + '...' + ext
                                                                                                                                : name;
                                                                                                                            label.textContent = truncated;
                                                                                                                        } else {
                                                                                                                            label.textContent = 'Choose file';
                                                                                                                        }
                                                                                                                    ">

                                                            <label class="custom-file-label" for="fileInput-{{ $file->id }}"
                                                                id="fileInputLabel-{{ $file->id }}">
                                                                Choose file
                                                            </label>
                                                        </div>

                                                        @error('file')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit"
                                                            class="btn btn-block btn-sm btn-primary btn-with-icon">
                                                            <span class="btn-icon ti-upload mr-2"></span>
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        @push('modals')
                                            <div class="modal fade" id="deleteFileModal-{{ $file->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="deleteFileModalLabel-{{ $file->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteFileModalLabel-{{ $file->id }}">Delete
                                                                File</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete <strong>{{ $file->file_name }}</strong>?
                                                            This action cannot be undone.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('document-files.destroy', $file) }}"
                                                                method="POST" class="d-inline js-delete-file-form"
                                                                data-file-row="#fileRow-{{ $file->id }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">
                                                                    <span class="spinner-border spinner-border-sm d-none mr-1"
                                                                        role="status" aria-hidden="true"></span>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endpush
                                    @empty
                                        <p class="text-muted mb-0" id="noFilesText-{{ $document->id }}">No files uploaded yet.
                                        </p>
                                    @endforelse

                                    @push('modals')
                                        <div class="modal fade" id="addFileModal-{{ $document->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="addFileModalLabel-{{ $document->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content border-0 shadow-sm">
                                                    <div class="modal-header">
                                                        <div>
                                                            <h5 class="modal-title" id="addFileModalLabel-{{ $document->id }}">
                                                                <span class="ti-upload mr-2 text-primary"></span>Add File
                                                            </h5>
                                                            <small class="text-muted"> Add a file to
                                                                <strong>{{ $document->name }}</strong> </small>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('document-files.store', $document) }}" method="POST"
                                                        enctype="multipart/form-data" class="js-add-file-form"
                                                        data-document-id="{{ $document->id }}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="fileName-{{ $document->id }}"> File Name </label>
                                                                <input type="text" name="file_name"
                                                                    id="fileName-{{ $document->id }}" class="form-control"
                                                                    placeholder="e.g. Invoice January">
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <label for="addFileModalInput-{{ $document->id }}"> File
                                                                </label>
                                                                <div class="custom-file custom-file-sm">
                                                                    <input type="file" name="file"
                                                                        id="addFileModalInput-{{ $document->id }}" required
                                                                        class="custom-file-input @error('file') is-invalid @enderror"
                                                                        onchange="
                                                                                                                                                    let file = this.files[0];
                                                                                                                                                    let label = this.nextElementSibling;
                                                                                                                                                    if (file) {
                                                                                                                                                        let name = file.name;
                                                                                                                                                        let dotIndex = name.lastIndexOf('.');
                                                                                                                                                        let ext = dotIndex !== -1 ? name.substring(dotIndex) : '';
                                                                                                                                                        let baseName = dotIndex !== -1 ? name.substring(0, dotIndex) : name;
                                                                                                                                                        let truncated = baseName.length > 10
                                                                                                                                                            ? baseName.substring(0, 10) + '...' + ext
                                                                                                                                                            : name;
                                                                                                                                                        label.textContent = truncated;
                                                                                                                                                    } else {
                                                                                                                                                        label.textContent = 'Choose file';
                                                                                                                                                    }
                                                                                                                                                ">
                                                                    <label class="custom-file-label"
                                                                        for="addFileModalInput-{{ $document->id }}"
                                                                        id="addFileModalInputLabel-{{ $document->id }}">
                                                                        Choose file
                                                                    </label>
                                                                </div>

                                                                @error('file')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                                <small class="form-text text-muted"> Select the file you want to
                                                                    upload. </small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light"> <button type="button"
                                                                class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                                                            <button type="submit" class="btn btn-primary btn-with-icon"> <span
                                                                    class="btn-icon ti-upload mr-2"></span> Upload File
                                                            </button> </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endpush
                                    @push('modals')
                                        <div class="modal fade" id="deleteDocumentModal-{{ $document->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteDocumentModalLabel-{{ $document->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteDocumentModalLabel-{{ $document->id }}">
                                                            Delete Document
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete <strong>{{ $document->name }}</strong> ?
                                                        and all its files.
                                                        This action cannot be undone.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('document.destroy', $document) }}" method="POST"
                                                            class="d-inline js-delete-document-form"
                                                            data-document-row="#documentRow-{{ $document->id }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">
                                                                <span class="spinner-border spinner-border-sm d-none mr-1"
                                                                    role="status" aria-hidden="true"></span>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endpush
                                    <div id="addDocumentEditRow-{{ $document->id }}" class="collapse mt-3">
                                        <form action="{{ route('document.update', $document) }}" method="POST"
                                            class="js-edit-document-form">
                                            @method('PATCH')
                                            @csrf
                                            <div class="form-row align-items-end">
                                                <div class="col-md-4 mb-2 mb-md-0">
                                                    <label class="small text-muted mb-1">Document Name</label>
                                                    <input type="text" name="name" class="form-control form-control-sm"
                                                        value="{{ $document->name }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit"
                                                        class="btn btn-block btn-sm btn-primary btn-with-icon">
                                                        <span class="btn-icon ti-upload mr-2"></span>
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0" id="noDocumentsText">No documents yet. Create one above to get started.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @push('modals')
        <div class="modal fade" id="createDocumentModal" tabindex="-1" role="dialog"
            aria-labelledby="createDocumentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title" id="createDocumentModalLabel"> Create New Document </h5> <small
                                class="text-muted"> Give your document a name to get started. </small>
                        </div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                                aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body">
                        <form id="createDocumentForm" action="{{ route('documents.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-4"> <label class="small text-muted mb-1"> Document Name </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="e.g. Project Documents"
                                    class="form-control @error('name') is-invalid @enderror" autofocus>
                                @error('name')
                                <div class="invalid-feedback"> {{ $message }} </div> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-with-icon">
                                <span class="btn-icon ti-plus mr-2"></span> Create Document
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('styles')
        <style>
            .custom-file-sm,
            .custom-file-sm .custom-file-input,
            .custom-file-sm .custom-file-label {
                height: calc(1.4em + 0.5rem + 4px);
            }

            .custom-file-sm .custom-file-label {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
                line-height: 1.5;
            }

            .custom-file-sm .custom-file-label::after {
                height: calc(1.5em + 0.5rem);
                padding: 0.25rem 0.5rem;
                line-height: 1.5;
                font-size: 0.875rem;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            $(function () {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Delete file
                function bindDeleteForm($form) {
                    var $button = $form.find('button[type="submit"]');
                    var $spinner = $button.find('.spinner-border');
                    var $modal = $form.closest('.modal');
                    var $row = $($form.data('file-row') || $form.data('document-row'));

                    $form.on('submit', function (e) {
                        e.preventDefault();
                        $button.prop('disabled', true);
                        $spinner.removeClass('d-none');

                        $.ajax({
                            url: $form.attr('action'),
                            type: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            dataType: 'json'
                        })
                            .done(function (response) {
                                $modal.modal('hide');

                                if ($form.hasClass('js-delete-file-form')) {
                                    var $collapseBody = $row.closest('.collapse[id^="collapse-"]');
                                    var docId = $collapseBody.attr('id') ? $collapseBody.attr('id').replace('collapse-', '') : null;
                                    $row.fadeOut(200, function () {
                                        $row.remove();
                                        var $cardBody = $('#collapse-' + docId + ' .card-body');
                                        var $badge = $('#heading-' + docId + ' .badge');
                                        var count = $cardBody.find('.media.align-items-center').length;
                                        $badge.text(count + (count === 1 ? ' file' : ' files'));
                                    });
                                } else if ($form.hasClass('js-delete-document-form')) {
                                    $row.fadeOut(200, function () { $row.remove(); });
                                }
                                showFlashMessage(response.message, 'success');
                            })
                            .fail(function (xhr) {
                                $modal.modal('hide');
                                var message;
                                if (xhr.status === 403) {
                                    message = 'You are not authorized to delete this file.';
                                } else if (xhr.status === 404) {
                                    message = 'This file no longer exists. The page will refresh.';
                                    setTimeout(function () { location.reload(); }, 2000);
                                } else if (xhr.status === 0) {
                                    message = 'Network error — please check your connection and try again.';
                                } else {
                                    message = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong. Please try again.';
                                }
                                showFlashMessage(message, 'danger');
                            })
                            .always(function () {
                                $button.prop('disabled', false);
                                $spinner.addClass('d-none');
                            });
                    });
                }

                $('.js-delete-file-form, .js-delete-document-form').each(function () {
                    bindDeleteForm($(this));
                });

                var $createForm = $('#createDocumentForm');
                $createForm.on('submit', function (e) {
                    e.preventDefault();

                    var $button = $createForm.find('button[type="submit"]');
                    $button.prop('disabled', true);

                    $.ajax({
                        url: $createForm.attr('action'),
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: $createForm.serialize(),
                        dataType: 'json'
                    })
                        .done(function (response) {
                            $('#noDocumentsText').remove();

                            var $newCard = $(response.html);
                            $('#documentsList').append($newCard);

                            $newCard.filter('.modal').appendTo('#modalsStack');
                            $newCard.find('.modal').appendTo('#modalsStack');

                            $createForm[0].reset();
                            showFlashMessage(response.message, 'success');
                        })
                        .fail(function (xhr) {
                            var message = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong. Please try again.';
                            showFlashMessage(message, 'danger');
                        })
                        .always(function () {
                            $button.prop('disabled', false);
                        });
                });

                // Add file
                $(document).on('submit', '.js-add-file-form', function (e) {
                    e.preventDefault();

                    var $form = $(this);
                    var docId = $form.data('document-id');
                    var $button = $form.find('button[type="submit"]');
                    var formData = new FormData($form[0]);

                    $button.prop('disabled', true);

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json'
                    })
                        .done(function (response) {
                            var file = response.file;
                            var routes = response.routes;
                            var name = $('<div>').text(file.file_name).html();

                            var thumbHtml = file.is_image
                                ? '<img class="u-avatar-md rounded mr-3" src="' + file.url + '" alt="' + name + '" style="object-fit: cover;">'
                                : '<div class="u-icon rounded-circle bg-primary text-white mr-3"><span class="ti-file"></span></div>';

                            var rowHtml =
                                '<div class="media align-items-center py-3 border-bottom" id="fileRow-' + file.id + '">' +
                                thumbHtml +
                                '<div class="media-body">' +
                                '<h4 class="font-weight-normal mb-0">' + name + '</h4>' +
                                '<small class="text-muted text-uppercase">.' + file.extension + '</small>' +
                                '</div>' +
                                '<a href="' + file.url + '" download class="btn btn-sm btn-outline-primary btn-with-icon ml-3">' +
                                '<span class="btn-icon ti-download mr-2"></span>Download' +
                                '</a>' +
                                '<button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm ml-2" data-toggle="collapse" data-target="#addFileEditRow-' + file.id + '" aria-expanded="false" aria-controls="addFileEditRow-' + file.id + '" title="Edit File">' +
                                '<span class="btn-icon ti-pencil-alt"></span>' +
                                '</button>' +
                                '<button type="button" class="btn btn-danger btn-circle btn-with-icon btn-sm ml-2" data-toggle="modal" data-target="#deleteFileModal-' + file.id + '" title="Delete File">' +
                                '<span class="btn-icon ti-trash"></span>' +
                                '</button>' +
                                '</div>' +
                                '<div id="addFileEditRow-' + file.id + '" class="collapse mt-3">' +
                                '<form action="' + routes.update + '" method="POST" enctype="multipart/form-data">' +
                                '<input type="hidden" name="_method" value="PATCH">' +
                                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                '<div class="form-row align-items-end">' +
                                '<div class="col-md-4 mb-2 mb-md-0">' +
                                '<label class="small text-muted mb-1">File Name</label>' +
                                '<input type="text" name="file_name" class="form-control form-control-sm" value="' + name + '" placeholder="e.g. Invoice January">' +
                                '</div>' +
                                '<div class="col-md-5 mb-2 mb-md-0">' +
                                '<label class="small text-muted mb-1">File</label>' +
                                '<div class="custom-file custom-file-sm">' +
                                '<input type="file" name="file" id="fileInput-' + file.id + '" class="custom-file-input" onchange="$(this).siblings(\'.custom-file-label\').text(this.files[0] ? this.files[0].name : \'Choose file\');">' +
                                '<label class="custom-file-label" for="fileInput-' + file.id + '">Choose file</label>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                '<button type="submit" class="btn btn-block btn-sm btn-primary btn-with-icon"><span class="btn-icon ti-upload mr-2"></span>Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</form>' +
                                '</div>';

                            var modalHtml =
                                '<div class="modal fade" id="deleteFileModal-' + file.id + '" tabindex="-1" role="dialog" aria-labelledby="deleteFileModalLabel-' + file.id + '" aria-hidden="true">' +
                                '<div class="modal-dialog modal-dialog-centered" role="document">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title" id="deleteFileModalLabel-' + file.id + '">Delete File</h5>' +
                                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '</div>' +
                                '<div class="modal-body">Are you sure you want to delete <strong>' + name + '</strong>? This action cannot be undone.</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>' +
                                '<form action="' + routes.destroy + '" method="POST" class="d-inline js-delete-file-form" data-file-row="#fileRow-' + file.id + '">' +
                                '<input type="hidden" name="_method" value="DELETE">' +
                                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                                '<button type="submit" class="btn btn-danger"><span class="spinner-border spinner-border-sm d-none mr-1" role="status" aria-hidden="true"></span>Delete</button>' +
                                '</form>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            var $cardBody = $('#collapse-' + docId + ' .card-body');
                            $('#noFilesText-' + docId).remove();
                            $(rowHtml).insertBefore($cardBody.find('#addDocumentEditRow-' + docId));
                            $(modalHtml).appendTo('body');

                            // Update file count badge
                            var $badge = $('#heading-' + docId + ' .badge');
                            var count = $cardBody.find('.media.align-items-center').length;
                            $badge.text(count + (count === 1 ? ' file' : ' files'));

                            bindDeleteForm($('#deleteFileModal-' + file.id + ' .js-delete-file-form'));
                            bindFileEditForm($('#addFileEditRow-' + file.id + ' .js-edit-file-form'));

                            $('#addFileModal-' + docId).modal('hide');
                            $form[0].reset();
                            $form.find('.custom-file-label').text('Choose file');
                            showFlashMessage(response.message, 'success');
                        })
                        .fail(function (xhr) {
                            var message = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong. Please try again.';
                            showFlashMessage(message, 'danger');
                        })
                        .always(function () {
                            $button.prop('disabled', false);
                        });
                });

                function bindDocumentEditForm($form) {
                    var $button = $form.find('button[type="submit"]');
                    var $collapse = $form.closest('.collapse');
                    var docId = $form.attr('action').split('/').pop();

                    $form.on('submit', function (e) {
                        e.preventDefault();

                        $button.prop('disabled', true);

                        $.ajax({
                            url: $form.attr('action'),
                            type: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            data: $form.serialize(),
                            dataType: 'json'
                        })
                            .done(function (response) {
                                var doc = response.document;
                                var name = $('<div>').text(doc.name).html();

                                $('#documentName-' + doc.id).text(name);

                                $form.find('input[name="name"]').val(doc.name);

                                $collapse.collapse('hide');
                                showFlashMessage(response.message, 'success');
                            })
                            .fail(function (xhr) {
                                var message;
                                if (xhr.status === 403) {
                                    message = 'You are not authorized to edit this document.';
                                } else if (xhr.status === 404) {
                                    message = 'This document no longer exists. The page will refresh.';
                                    setTimeout(function () { location.reload(); }, 2000);
                                } else if (xhr.status === 0) {
                                    message = 'Network error — please check your connection and try again.';
                                } else if (xhr.status === 422) {
                                    message = (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.name && xhr.responseJSON.errors.name[0]) || 'Please check the document name.';
                                } else {
                                    message = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong. Please try again.';
                                }
                                showFlashMessage(message, 'danger');
                            })
                            .always(function () {
                                $button.prop('disabled', false);
                            });
                    });
                }

                $('.js-edit-document-form').each(function () {
                    bindDocumentEditForm($(this));
                });

                function bindFileEditForm($form) {
                    var $button = $form.find('button[type="submit"]');
                    var $collapse = $form.closest('.collapse');
                    var $row = $collapse.prev('.media.align-items-center');

                    $form.on('submit', function (e) {
                        e.preventDefault();

                        $button.prop('disabled', true);

                        var formData = new FormData($form[0]);

                        $.ajax({
                            url: $form.attr('action'),
                            type: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'json'
                        })
                            .done(function (response) {
                                var file = response.file;
                                var name = $('<div>').text(file.file_name).html();

                                $row.find('h4.font-weight-normal').text(file.file_name);
                                $row.find('small.text-muted.text-uppercase').text('.' + file.extension);

                                $row.find('a[download]').attr('href', file.url);

                                if (file.is_image) {
                                    var $existingImg = $row.find('img.u-avatar-md');
                                    if ($existingImg.length) {
                                        $existingImg.attr('src', file.url);
                                    } else {
                                        $row.find('.u-icon.rounded-circle').replaceWith(
                                            '<img class="u-avatar-md rounded mr-3" src="' + file.url + '" alt="' + name + '" style="object-fit: cover;">'
                                        );
                                    }
                                } else {
                                    var $existingIcon = $row.find('.u-icon.rounded-circle');
                                    if (!$existingIcon.length) {
                                        $row.find('img.u-avatar-md').replaceWith(
                                            '<div class="u-icon rounded-circle bg-primary text-white mr-3"><span class="ti-file"></span></div>'
                                        );
                                    }
                                }

                                $form.find('input[type="file"]').val('');
                                $form.find('.custom-file-label').text('Choose file');

                                $collapse.collapse('hide');
                                showFlashMessage(response.message, 'success');
                            })
                            .fail(function (xhr) {
                                var message;
                                if (xhr.status === 403) {
                                    message = 'You are not authorized to edit this file.';
                                } else if (xhr.status === 404) {
                                    message = 'This file no longer exists. The page will refresh.';
                                    setTimeout(function () { location.reload(); }, 2000);
                                } else if (xhr.status === 0) {
                                    message = 'Network error — please check your connection and try again.';
                                } else if (xhr.status === 422) {
                                    var errors = xhr.responseJSON && xhr.responseJSON.errors;
                                    message = (errors && (errors.file_name || errors.file) && (errors.file_name || errors.file)[0]) || 'Please check the form and try again.';
                                } else {
                                    message = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong. Please try again.';
                                }
                                showFlashMessage(message, 'danger');
                            })
                            .always(function () {
                                $button.prop('disabled', false);
                            });
                    });
                }

                $('.js-edit-file-form').each(function () {
                    bindFileEditForm($(this));
                });

                function showFlashMessage(message, type) {
                    var iconMap = { success: 'ti-check', danger: 'ti-close' };
                    var icon = iconMap[type] || 'ti-check';

                    var $alert = $('#flashAlert');

                    $alert
                        .removeClass('alert-success-soft alert-danger-soft d-none')
                        .addClass('alert-' + type + '-soft show')
                        .css('display', '');

                    $('#flashAlertIcon').attr('class', 'alert-icon ' + icon + ' mr-3');
                    $('#flashAlertMessage').text(message);

                    clearTimeout(window.__flashAlertTimeout);
                    window.__flashAlertTimeout = setTimeout(function () {
                        $alert.fadeOut(300, function () {
                            $(this).addClass('d-none').css('display', '');
                        });
                    }, 4000);
                }
            });

        </script>
    @endpush
</x-app-layout>