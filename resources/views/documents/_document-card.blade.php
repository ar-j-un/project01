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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFileModalLabel-{{ $document->id }}">Add File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('document-files.store', $document) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-row align-items-end">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label class="small text-muted mb-1">File Name</label>
                            <input type="text" name="file_name" class="form-control form-control-sm"
                                placeholder="e.g. Invoice January">
                        </div>
                        <div class="col-md-5 mb-2 mb-md-0">
                            <label class="small text-muted mb-1">File</label>
                            <div class="custom-file custom-file-sm">
                                <input type="file" name="file" id="addFileModalInput-{{ $document->id }}"
                                    class="custom-file-input"
                                    onchange="$(this).siblings('.custom-file-label').text(this.files[0] ? this.files[0].name : 'Choose file');">
                                <label class="custom-file-label" for="addFileModalInput-{{ $document->id }}">Choose
                                    file</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-block btn-sm btn-primary btn-with-icon">
                                <span class="btn-icon ti-upload mr-2"></span>
                                Upload
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>