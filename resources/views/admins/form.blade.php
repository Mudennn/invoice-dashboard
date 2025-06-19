<div class="form-input-container">
    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ isset($admin) ? $admin->name : old('name') }}"
                            class="form-control" >

                        @error('name')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder=""
                            value="{{ old('email', isset($admin->email) ? $admin->email : '') }}"
                            >

                        @error('description')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-controll @error('password') is-invalid @enderror" id="password" name="password" {{ !isset($admin) ? 'required' : '' }} autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                            </button>
                        </div>
                        @if(isset($admin))
                            <small class="text-muted">Leave blank to keep current password</small>
                        @endif
                        @error('password')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-controll" id="password_confirmation" name="password_confirmation" {{ !isset($admin) ? 'required' : '' }} autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Change icon based on password visibility
            const icon = this.querySelector('.material-symbols-outlined');
            icon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
        
        // Toggle password confirmation visibility
        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            
            // Change icon based on password visibility
            const icon = this.querySelector('.material-symbols-outlined');
            icon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
    });
</script>