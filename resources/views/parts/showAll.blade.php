<div>
    <h1>Parts</h1>
    <p>Buy, Sell & Trade Computers with Local Kenyan's</p>

    <form onsubmit="handleFilterSubmit(event)" id="filter-form">
        <div class="input-group flex-nowrap">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
            <input type="text" class="form-control" placeholder="Search" aria-label="Search" id="filter-search" aria-describedby="">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary" id="dropdownFilterButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownFilterButton" id="dropdownFilter">
                    @foreach($categories as $category)
                        <li class="dropdown-item">
                            <input class="form-check-input me-1 filter-category" type="checkbox" value="{{ $category->id }}" aria-label="{{ $category->name }}">
                            {{ $category->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </form>

    @auth
        <div class="mt-3 d-grid d-md-flex justify-content-md-center mb-md-5 mt-md-5">
            <a class="btn btn-primary" href="/parts/create">List a Computer Part</a>
        </div>
    @endauth
    @guest
        <div class="mt-3 d-grid d-md-flex justify-content-md-center mb-md-5 mt-md-5">
            <p class="text-center">Log in to list a part</p>
        </div>
    @endguest

    <div class="row justify-content-around item-list mt-4">
        @foreach($parts as $part)
            <div class="card mb-4 col-auto" style="max-width: 400px">
                <img src="{{ asset('uploads/' . $part->image_name) }}" class="card-img-top" alt="{{$part->title}}">
                <div class="card-body">
                    <h5 class="card-title">{{ $part->title }}</h5>
                    <div class="collapsible-description">
                        <div class="collapse" id="{{ "collapseDescription" . $part->id }}">
                            {{ $part->description }}
                        </div>
                        <a class="link-primary collapsed mt-2" type="button" data-bs-toggle="collapse" data-bs-target="{{ "#collapseDescription" . $part->id }}" aria-expanded="false" aria-controls="{{ "collapseDescription" . $part->id }}"></a>
                    </div>
                    <br>
                    <span class="badge bg-secondary mb-4">{{ $part->category->name }}</span>
                    <br>
                    @if(!auth()->user() || intval(auth()->user()->id) !== intval($part->user_id))
                        <button type="button" class="btn btn-primary contact-btn" data-bs-toggle="modal" data-bs-target="#contact-form-modal" data-id="{{ $part->id }}">
                            Contact Seller
                        </button>
                    @else
                        <a type="button" class="btn btn-primary edit-btn" href="/parts/edit/{{$part->id}}">
                            Edit
                        </a>
                        <button type="button" class="btn btn-secondary edit-btn" onclick="markListingAsSold({{$part->id}}, 'parts')">
                            Mark as sold
                        </button>
                        <button type="button" class="btn btn-danger edit-btn" onclick="deleteListing({{$part->id}}, 'parts')">
                            Delete
                        </button>
                    @endif
                </div>
            </div>
        @endforeach

        @if (count($parts) === 0)
            <p class="text-center">Nothing is found</p>
        @endif

        <nav aria-label="Page navigation example" class="mt-md-3">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $parts->currentPage() == 1 ? 'disabled' : '' }}" >
                    <a class="page-link" href={{ $parts->previousPageUrl() }} tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $parts->currentPage() }}</span>
                </li>
                <li class="page-item {{ $parts->currentPage() == $parts->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href={{ $parts->nextPageUrl() }} tabindex="-1" aria-disabled="true">Next</a>
                </li>
            </ul>
        </nav>
    </div>


    <div class="modal fade" id="contact-form-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contact Seller</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="contact-form">
                        @csrf

                        <div class="form-group">
                            <label for="contact-name-input">Name</label>
                            <input name="name" type="name" class="form-control" id="contact-name-input" aria-describedby="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-email-input">Email</label>
                            <input name="email" type="email" class="form-control" id="contact-email-input" aria-describedby="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-phone-input">Phone</label>
                            <input name="phone" class="form-control" id="contact-phone-input" aria-describedby="phone" placeholder="Enter phone number" required>
                        </div>
                        <button type="button" class="btn btn-primary mt-2" onclick="submitContactForm('parts')" disabled>Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
