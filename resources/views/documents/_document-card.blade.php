<div class="accordion" id="accordionDocuments">
    <div class="card mb-3">
        <div id="heading-{{ $document->id }}" class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-header-title mb-0" aria-expanded="false" aria-controls="collapse-{{ $document->id }}"
                data-toggle="collapse" data-target="#collapse-{{ $document->id }}" style="cursor: pointer;">
                <span class="ti-folder mr-2"></span>
                <span id="documentName-{{ $document->id }}">{{ $document->name }}</span>
                <span class="badge badge-md badge-pill badge-primary-soft ml-2">
                    0 files
                </span>
            </h4>

            <div>
                <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm" data-toggle="modal"
                    data-target="#addFileModal-{{ $document->id }}" title="Add File">
                    <span class="btn-icon ti-plus"></span>
                </button>
                <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm ml-2"
                    data-toggle="collapse" data-target="#addDocumentEditRow-{{ $document->id }}"
                    data-parent-collapse="#collapse-{{ $document->id }}" aria-expanded="false"
                    aria-controls="addDocumentEditRow-{{ $document->id }}" title="Edit Document">
                    <span class="btn-icon ti-pencil-alt"></span>
                </button>
                <button type="button" class="btn btn-danger btn-circle btn-with-icon btn-sm ml-2" data-toggle="modal"
                    data-target="#deleteDocumentModal-{{ $document->id }}" title="Delete Document">
                    <span class="btn-icon ti-trash"></span>
                </button>
            </div>
        </div>

        <div id="collapse-{{ $document->id }}" class="collapse" aria-labelledby="heading-{{ $document->id }}"
            data-parent="#accordionDocuments">
            <div class="card-body">
                <p class="text-muted mb-0" id="noFilesText-{{ $document->id }}">No files uploaded yet.</p>

                <div id="addFileRow-{{ $document->id }}" class="collapse mt-3"></div>

                <div id="addDocumentEditRow-{{ $document->id }}" class="collapse mt-3">
                    <form action="{{ route('document.update', $document) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-row align-items-end">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <label class="small text-muted mb-1">Document Name</label>
                                <input type="text" name="name" class="form-control form-control-sm"
                                    value="{{ $document->name }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-block btn-sm btn-primary btn-with-icon">
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
</div>

<div class="modal fade" id="addFileModal-{{ $document->id }}" tabindex="-1" role="dialog"
    aria-labelledby="addFileModalLabel-{{ $document->id }}" aria-hidden="true">
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('document-files.store', $document) }}" method="POST" enctype="multipart/form-data"
                class="js-add-file-form" data-document-id="{{ $document->id }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fileName-{{ $document->id }}"> File Name </label>
                        <input type="text" name="file_name" id="fileName-{{ $document->id }}" class="form-control"
                            placeholder="e.g. Invoice January">
                    </div>
                    <div class="form-group mb-0">
                        <label for="addFileModalInput-{{ $document->id }}"> File
                        </label>
                        <div class="custom-file custom-file-sm">
                            <input type="file" name="file" id="addFileModalInput-{{ $document->id }}" required
                                class="custom-file-input @error('file') is-invalid @enderror" onchange="
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
                            <label class="custom-file-label" for="addFileModalInput-{{ $document->id }}"
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
                <div class="modal-footer bg-light"> <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"> Cancel </button>
                    <button type="submit" class="btn btn-primary btn-with-icon"> <span
                            class="btn-icon ti-upload mr-2"></span> Upload File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteDocumentModal-{{ $document->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteDocumentModalLabel-{{ $document->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDocumentModalLabel-{{ $document->id }}">Delete Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $document->name }}</strong> ? and all its files.
                This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('document.destroy', $document) }}" method="POST"
                    class="d-inline js-delete-document-form" data-document-row="#documentRow-{{ $document->id }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <span class="spinner-border spinner-border-sm d-none mr-1" role="status"
                            aria-hidden="true"></span>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>