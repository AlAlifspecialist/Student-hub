<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3 mb-3">Admin login</h1>
                <form method="post" action="<?= e(url('admin/login')) ?>" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

                    <div class="col-12">
                        <label class="form-label" for="username">Username</label>
                        <input class="form-control" type="text" id="username" name="username" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                    </div>

                    <div class="col-12 d-grid">
                        <button class="btn btn-primary">Log in</button>
                    </div>
                </form>

                <hr>
                <div class="small text-muted">
                    Demo accounts: admin / editor / mailer
                </div>
            </div>
        </div>
    </div>
</div>
