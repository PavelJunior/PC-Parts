<div>
    <x-form-card>
        <form method="POST" enctype="multipart/form-data" style="width: 22rem;">
            @csrf

            <div class="form-outline mb-4">
                <label class="form-label" for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $part->title }}" required/>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required rows="5">{{ $part->description }}</textarea>
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="description">Category</label>
                <select class="form-select" name="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" selected="{{ $part->category_id === $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>


            <div id="oldimage" class="mb-4">
                <label class="form-label" for="image">Previous Image</label>
                <img  src="{{ asset('uploads/' . $part->image_name) }}" height="300" width="300" class="pl-3" alt="">
            </div>

            <div class="form-outline mb-4">
                <p>If you want to change an image upload a new one</p>
                <label class="form-label" for="image">Image</label>
                <input type="file" id="img" name="image" accept="image/*">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success mb-4">Confirm</button>
            </div>
        </form>
    </x-form-card>
</div>
