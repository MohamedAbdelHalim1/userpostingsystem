<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Post') }}
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                    <p>"{{ $post->content }}"</p>

                    <!-- Comments Section -->
                    <div class="mt-6">
                                                <!-- Add Comment -->
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700">Add Comment</label>
                                <textarea id="content" name="content" rows="3" class="form-input mt-1 block w-full" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Comment</button>
                        </form><br><hr><br>
                        <h4 class="text-md font-semibold mb-2">Comments</h4>
                        @foreach ($post->comments as $comment)
                            <div class="comment">
                                <p>"{{ $comment->content }}"</p>
                                <p><small>By {{ $comment->user->name }}</small></p>

                                @if ($comment->user_id === Auth::id())
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
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
