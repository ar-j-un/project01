<button type="button" class="btn btn-danger text-uppercase" data-toggle="modal" data-target="#confirmUserDeletionModal">
    Delete Account
</button>

@push('modals')
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteAccountForm" method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-body p-4">
                        <h4 id="confirmUserDeletionModalLabel" class="mb-3">Are you sure you want to delete your account?
                        </h4>
                        <p class="text-muted">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                            Please enter your password to confirm you would like to permanently delete your account.
                        </p>

                        <div class="form-group mb-0">
                            <label for="delete_password" class="sr-only">Password</label>
                            <input id="delete_password" name="password" type="password" class="form-control"
                                placeholder="Password" autocomplete="current-password">
                            <span id="deletePasswordError" class="invalid-feedback d-block" role="alert"
                                style="display: none;"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary text-uppercase"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger text-uppercase" id="deleteAccountSubmit">Delete
                            Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $(function () {
            var $form = $('#deleteAccountForm');
            if (!$form.length) return;

            var $password = $('#delete_password');
            var $error = $('#deletePasswordError');
            var $submitBtn = $('#deleteAccountSubmit');
            var $modal = $('#confirmUserDeletionModal');

            $modal.on('show.bs.modal', function () {
                $password.val('').removeClass('is-invalid');
                $error.hide().text('');
            });

            $form.on('submit', function (event) {
                event.preventDefault();

                $submitBtn.prop('disabled', true).text('Deleting…');
                $password.removeClass('is-invalid');
                $error.hide();

                $.ajax({
                    url: $form.attr('action'),
                    type: 'DELETE',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: JSON.stringify({ password: $password.val() }),
                    success: function () {
                        window.location.href = '{{ route('login') }}';
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            var message = (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.password && xhr.responseJSON.errors.password[0]) || 'Something went wrong.';
                            $password.addClass('is-invalid');
                            $error.text(message).show();
                            $submitBtn.prop('disabled', false).text('Delete Account');
                            return;
                        }

                        window.location.reload();
                    },
                });
            });
        });
    </script>
@endpush