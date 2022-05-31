<div>
    <x-form-card>
        <form method="POST" enctype="multipart/form-data" style="width: 22rem;">
            @csrf

            <div class="form-outline mb-4">
                <label class="form-label" for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required/>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required rows="5"></textarea>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="description">Category</label>
                <select class="form-select" name="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="image">Image</label>
                <input type="file" id="img" name="image" accept="image/*">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary mb-4">Confirm</button>
            </div>
        </form>
    </x-form-card>
</div>

