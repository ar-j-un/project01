<x-app-layout>
    <x-slot name="title">Document</x-slot>

    @if (session('success'))
        <div class="alert alert-success-soft fade show mb-5" role="alert">
            <span class="alert-icon ti-check mr-3"></span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card mb-5">
        <header class="card-header">
            <h2 class="h4 card-header-title">Create New Document</h2>
        </header>

        <div class="card-body pt-0">
            <form action="{{ route('documents.store') }}" method="POST" class="row align-items-start">
                @csrf
                <div class="col-md-9 mb-2 mb-md-0">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Document name"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-block btn-primary btn-with-icon">
                        <span class="btn-icon ti-plus mr-2"></span>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <header class="card-header">
            <h2 class="h4 card-header-title">My Documents</h2>
        </header>

        <div class="card-body pt-0">

            @forelse ($documents as $document)
                <div class="accordion" id="accordionDocuments">
                    <div class="card mb-3">
                        <div id="heading-{{ $document->id }}"
                            class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-header-title mb-0" aria-expanded="false"
                                aria-controls="collapse-{{ $document->id }}" data-toggle="collapse"
                                data-target="#collapse-{{ $document->id }}" style="cursor: pointer;">
                                <span class="ti-folder mr-2"></span>
                                {{ $document->name }}
                                <span class="badge badge-md badge-pill badge-primary-soft ml-2">
                                    {{ $document->documentFiles->count() }}
                                    file{{ $document->documentFiles->count() === 1 ? '' : 's' }}
                                </span>
                            </h4>

                            <div>
                            <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm"
                                data-toggle="modal" data-target="#addFileModal-{{ $document->id }}" title="Add File">
                                <span class="btn-icon ti-plus"></span>
                            </button>
                            <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm ml-2"
                                data-toggle="collapse" data-target="#addDocumentEditRow-{{ $document->id }}" 
                                data-parent-collapse="#collapse-{{ $document->id }}"
                                aria-expanded="false" aria-controls="addDocumentEditRow-{{ $document->id }}" title="Edit Document">
                                <span class="btn-icon ti-pencil-alt"></span>
                            </button>
                            </div>
                        </div>

                        <div id="collapse-{{ $document->id }}" class="collapse"
                            aria-labelledby="heading-{{ $document->id }}" data-parent="#accordionDocuments">
                            <div class="card-body">

                                @forelse ($document->documentFiles as $file)
                                    <div class="media align-items-center py-3 border-bottom">
                                        @if ($file->is_image)
                                            <img class="u-avatar-md rounded mr-3" src="{{ $file->url }}" alt="{{ $file->file_name }}"
                                                style="object-fit: cover;">
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
                                            data-toggle="collapse" data-target="#addFileEditRow-{{ $file->id }}" aria-expanded="false"
                                            aria-controls="addFileEditRow-{{ $file->id }}" title="Edit File">
                                            <span class="btn-icon ti-pencil-alt"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle btn-with-icon btn-sm ml-2"
                                            data-toggle="modal" data-target="#deleteFileModal-{{ $file->id }}" title="Delete File">
                                            <span class="btn-icon ti-trash"></span>
                                        </button>
                                    </div>
                                    <div id="addFileEditRow-{{ $file->id }}" class="collapse mt-3">
                                    <form action="{{ route('document-files.update', [$document, $file]) }}" method="POST"
                                        enctype="multipart/form-data">
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
                                                    <input type="file"
                                                        name="file"
                                                        id="fileInput-{{ $document->id }}"
                                                        class="custom-file-input @error('file') is-invalid @enderror"
                                                        onchange="$(this).siblings('.custom-file-label').text(this.files[0] ? this.files[0].name : 'Choose file');">

                                                    <label class="custom-file-label" for="fileInput-{{ $document->id }}" id="fileInputLabel-{{ $document->id }}">
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
                                                <h5 class="modal-title" id="deleteFileModalLabel-{{ $file->id }}">Delete File</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $file->file_name }}</strong>?
                                                This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('document-files.destroy', $file) }}" method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endpush
                                @empty
                                    <p class="text-muted mb-0" id="noFilesText-{{ $document->id }}">No files uploaded yet.</p>
                                @endforelse

                                @push('modals')
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
                                                                <input type="file"
                                                                    name="file"
                                                                    id="addFileModalInput-{{ $document->id }}"
                                                                    class="custom-file-input @error('file') is-invalid @enderror"
                                                                    onchange="$(this).siblings('.custom-file-label').text(this.files[0] ? this.files[0].name : 'Choose file');">

                                                                <label class="custom-file-label" for="fileInput-{{ $document->id }}" id="fileInputLabel-{{ $document->id }}">
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
                                                                Upload
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endpush
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
                </div>
            @empty
                <p class="text-muted mb-0">No documents yet. Create one above to get started.</p>
            @endforelse

        </div>
    </div>
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
</x-app-layout>