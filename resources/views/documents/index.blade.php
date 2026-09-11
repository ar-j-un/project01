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

                            <button type="button" class="btn btn-primary btn-circle btn-with-icon btn-sm"
                                data-toggle="collapse" data-target="#addFileRow-{{ $document->id }}" aria-expanded="false"
                                aria-controls="addFileRow-{{ $document->id }}" title="Add File">
                                <span class="btn-icon ti-plus"></span>
                            </button>
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
                                    </div>
                                @empty
                                    <p class="text-muted mb-0" id="noFilesText-{{ $document->id }}">No files uploaded yet.</p>
                                @endforelse

                                <div id="addFileRow-{{ $document->id }}" class="collapse mt-3">
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
                                                <input type="file" name="file" class="form-control-file">
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
                </div>
            @empty
                <p class="text-muted mb-0">No documents yet. Create one above to get started.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>