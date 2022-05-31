<div>
    @if (auth()->user())
        <h1 class="text-center">{{ auth()->user()->name }}</h1>
        <p class="text-center"> {{ auth()->user()->email }}</p>
    @endif

    <div class="text-center">
        <a href="/forgot-password" class="link-secondary">Update Password</a>
    </div>


    <div class="mt-3 d-grid d-md-flex justify-content-md-center mb-md-5 mt-md-5">
        <a class="btn btn-primary" href="/pcs/create">List a Computer</a>
    </div>
    <div class="mt-3 d-grid d-md-flex justify-content-md-center mb-md-5 mt-md-5">
        <a class="btn btn-primary" href="/parts/create">List a Computer Part</a>
    </div>


    <div class="row justify-content-around item-list mt-4">
        @foreach($listings as $listing)
            <div class="card mb-4 col-auto" style="max-width: 400px">
                <img src="{{ asset('uploads/' . $listing->image_name) }}" class="card-img-top" alt="{{$listing->title}}">
                <div class="card-body">
                    <h5 class="card-title">{{ $listing->title }}</h5>
                    <div class="collapsible-description">
                        <div class="collapse" id="{{ "collapseDescription" . $listing->type . $listing->id }}">
                            {{ $listing->description }}
                        </div>
                        <a class="link-primary collapsed mt-2" type="button" data-bs-toggle="collapse" data-bs-target="{{ "#collapseDescription" . $listing->type . $listing->id }}" aria-expanded="false" aria-controls="{{ "collapseDescription" . $listing->type . $listing->id }}"></a>
                    </div>
                    @if ($listing->type === 'parts')
                        <span class="badge bg-secondary mb-4">{{ $listing->category->name }}</span> <br>
                    @endif

                    <br>
                    <a type="button" class="btn btn-primary edit-btn" href="/{{$listing->type}}/edit/{{$listing->id}}">
                        Edit
                    </a>
                    <button type="button" class="btn btn-secondary edit-btn" onclick="markListingAsSold({{$listing->id}}, '{{ $listing->type }}')">
                        Mark as sold
                    </button>
                    <button type="button" class="btn btn-danger edit-btn" onclick="deleteListing({{$listing->id}},  '{{ $listing->type }}')">
                        Delete
                    </button>
                </div>
            </div>
        @endforeach

        @if (count($listings) === 0)
            <p class="text-center">Nothing is found</p>
        @endif
    </div>
</div>
