<button type="button" class="btn btn-danger text-uppercase" data-toggle="modal" data-target="#confirmUserDeletionModal">
    Delete Account
</button>

@push('modals')
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-body p-4">
                        <h4 id="confirmUserDeletionModalLabel" class="mb-3">Are you sure you want to delete your account?
                        </h4>
                        <p class="text-muted">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                            Please enter your password to confirm you would like to permanently delete your account.
                        </p>

                        <div class="form-group">
                            <label for="delete_password" class="sr-only">Password</label>
                            <input id="delete_password" name="password" type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                placeholder="Password">
                            @error('password', 'userDeletion')
                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary text-uppercase"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger text-uppercase">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush