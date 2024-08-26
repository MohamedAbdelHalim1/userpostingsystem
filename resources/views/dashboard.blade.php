<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 1080;">
        <div style="position: absolute; top: 20px; right: 20px;">
            @if (session('success'))
                <div id="success-toast" class="toast align-items-center text-bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div id="error-toast" class="toast align-items-center text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Navigation Links -->
                    <div class="mt-4 mb-6">
                        <h3 class="text-lg font-semibold mb-2">Manage Your Blog</h3>
                        <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
                    </div>

                    <!-- List of Posts -->
                    @foreach($posts as $post)
                        <div class="mb-4 p-4 bg-gray-100 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                            <p>{{ Str::limit($post->content, 100) }}</p>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">View Post</a>
                            @if($post->user_id == Auth::id())
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize toasts
            var successToast = document.getElementById('success-toast');
            var errorToast = document.getElementById('error-toast');
            if (successToast) {
                var toast = new bootstrap.Toast(successToast);
                toast.show();
            }
            if (errorToast) {
                var toast = new bootstrap.Toast(errorToast);
                toast.show();
            }
        });
    </script>
</x-app-layout>
