<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg rounded overflow-hidden">
            <div class="p-5">
                <h1 class="mb-2 text-center">Welcome</h1>
                <form wire:submit="submit">
                    @if ($errors->any())
                        <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 20px;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <label class="form-label" for="emailaddress">Email address</label>
                        <input class="form-control" type="email" id="emailaddress" placeholder="Enter your email"
                            wire:model="email">
                        @error('email')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" type="password" id="password" placeholder="Enter your password"
                            wire:model="password">
                        @error('password')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox-signin" checked>
                            <label class="form-check-label ms-2" for="checkbox-signin">Remember me</label>
                        </div>
                    </div> --}}
                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary w-100" type="submit"> Log In </button>
                    </div>
                </form>
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <p class="text-muted mb-2">
                            <a class="text-muted font-weight-medium ms-1" href="pages-recoverpw.html">Forgot your
                                password?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
