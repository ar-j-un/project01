<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0">Profile</h2>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-5">
                <header class="card-header">
                    <h2 class="h4 card-header-title">Profile Information</h2>
                </header>
                <div class="card-body">
                    <p class="text-muted mb-4">Update your account's profile information and email address.</p>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mb-5">
                <header class="card-header">
                    <h2 class="h4 card-header-title">Update Password</h2>
                </header>
                <div class="card-body">
                    <p class="text-muted mb-4">Ensure your account is using a long, random password to stay secure.</p>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card mb-5 mb-lg-0">
                <header class="card-header">
                    <h2 class="h4 card-header-title text-danger">Delete Account</h2>
                </header>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                        Before deleting your account, please download any data or information you wish to retain.
                    </p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>