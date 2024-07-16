<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Profile Information</h3>
                <div class="card-body tw-px-6">
                    <p>Update your account's profile information and email address. </p>
                    <div class="form-group mt-3">
                        <label for="name">Name</label>
                        <input type="text" wire:model="name" class="form-control tw-w-full lg:tw-w-6/12">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" wire:model="email" class="form-control tw-w-full lg:tw-w-6/12">
                    </div>
                    <button wire:click.prevent="updateProfile()" class="btn btn-primary">SAVE PROFILE</button>
                </div>
            </div>
            <div class="card">
                <h3>Update Password</h3>
                <div class="card-body tw-px-6">
                    <p>Ensure your account is using a long, random password to stay secure. </p>
                    <div class="form-group mt-3">
                        <label for="current_password">Current Password</label>
                        <input type="password" wire:model="current_password"
                            class="form-control tw-w-full lg:tw-w-6/12">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" wire:model="password" class="form-control tw-w-full lg:tw-w-6/12">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" wire:model="password_confirmation"
                            class="form-control tw-w-full lg:tw-w-6/12">
                    </div>
                    <button wire:click.prevent="updatePassword()" class="btn btn-primary">SAVE PASSWORD</button>
                </div>
            </div>
        </div>
    </section>
</div>
