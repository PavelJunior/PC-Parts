<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased">
    <div>
        @include('layouts.navigation')
    </div>
    <main class="mt-5 container">
        @include($page)
    </main>

    <script>
        let selectedId = null;
        const buttons = document.getElementsByClassName('contact-btn')
        for (const button of buttons){
            button.addEventListener('click', e => {
                selectedId = e.target.getAttribute('data-id')
            });
        }

        function submitContactForm(type) {
            const form = document.getElementById('contact-form');
            let formData = new FormData();
            for (let i = 0; i < form.length; i++){
                if(!form[i].name){
                    continue
                }
                formData.append(form[i].name, form[i].value)
            }
            formData.append('id', selectedId)
            formData.append('type', type)

            const xhr = new XMLHttpRequest();
            xhr.open("POST", '/contact')
            xhr.setRequestHeader('Accept', 'application/json')
            xhr.send(formData)

            const modal = bootstrap.Modal.getInstance(document.getElementById('contact-form-modal')) // relatedTarget
            modal.hide()
        }

        function handleFilterSubmit(e){
            e.preventDefault()
            const form = document.getElementById('filter-form');
            let search = ''
            let categories = []
            for (let element of form.elements) {
                if (element.id === 'filter-search') {
                    search = element.value;
                } else if (element.tagName.toLowerCase() === "input" && element.checked) {
                    categories.push(element.value)
                }
            }

            var url = new URL(window.location.href);

            if (search !== '') {
                url.searchParams.set('query', search);
            } else {
                url.searchParams.delete('query')
            }

            if (categories.length !== 0) {
                url.searchParams.set('categories', categories.join(','));
            } else {
                url.searchParams.delete('categories')
            }

            window.location.href = url;
        }


        function validateForm(id) {
            const form = document.getElementById(id);
            form.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener(('input'), () => {
                    if (form.checkValidity()) {
                        form.querySelector('button').removeAttribute("disabled")
                    } else {
                        form.querySelector('button').setAttribute("disabled", "disabled")
                    }
                });
            });
        }

        function markListingAsSold(id, type) {
            updateListingStatus(id, type, 'sold', "Are you sure you want to mark this listing as sold?")
        }

        function deleteListing(id, type) {
            updateListingStatus(id, type, 'deleted', "Are you sure you want to delete this listing?")
        }

        function updateListingStatus(id, type, status, message) {
            var answer = window.confirm(message);
            if (answer) {
                let formData = new FormData();
                formData.append('status', status)
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content)

                const xhr = new XMLHttpRequest();
                xhr.open("POST", '/' + type +'/' + id)
                xhr.setRequestHeader('Accept', 'application/json')
                xhr.send(formData)
            }
            document.location.reload()
        }

        validateForm('contact-form');

        document.addEventListener("DOMContentLoaded", function(){
            const params = new URLSearchParams(window.location.search)
            if (params.has('query')) {
                document.getElementById('filter-search').value = params.get('query');
            }
            if (params.has('categories')) {
                const categories = params.get('categories').split(',');
                const inputs = document.getElementsByClassName('filter-category');
                for (const input of inputs) {
                    if (categories.includes(input.value)) {
                        input.checked = true;
                    }
                }
            }
        });

        function deleteAccount() {
            var answer = window.confirm("Are you sure you want to delete you account and all listings?");
            if (answer) {
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}')

                const xhr = new XMLHttpRequest();
                xhr.open("DELETE", '/account')
                xhr.setRequestHeader('Accept', 'application/json')
                xhr.send(formData)
            }
        }
    </script>
    </body>
</html>
