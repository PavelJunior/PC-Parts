<div>
    <div class="text-center">
        <h3>Authenticate new seller</h3>
    </div>
    <x-form-card class="border border-gray-200">

        <form method="POST" enctype="multipart/form-data" style="width: 22rem;">
            @csrf

            <div class="form-outline mb-4">
                <label class="form-label" for="stident-id">Student ID</label>
                <input type="text" name="student-id" id="student-id" class="form-control" required/>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="seller-email">Seller email</label>
                <input type="text" name="seller-email" id="seller-email" class="form-control" required/>
            </div>


            <div class="d-grid">
                <button type="submit" class="btn btn-success mb-4">Authenticate</button>
            </div>
        </form>
    </x-form-card>
</div>
