@extends('layouts.app')

@section('title', $movie['title'] ?? 'Chi tiết phim')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Loading State -->
    <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)">
        <div x-show="loading" class="fixed inset-0 bg-black/50 flex items-center justify-center">
            <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-red-600"></div>
        </div>

        <!-- Hero Video Section -->
        <div class="relative h-[70vh] md:h-[85vh] overflow-hidden">
            <!-- Back Button -->
            <div class="absolute top-4 left-4 z-10">
                <a href="{{ route('movies.index') }}"
                   class="flex items-center px-4 py-2 bg-gray-800/50 text-white rounded-lg hover:bg-gray-800 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Trở về
                </a>
            </div>

            @if(isset($videos['results']) && count($videos['results']) > 0)
                <div class="absolute inset-0 w-full">
                    <iframe src="https://www.youtube.com/embed/{{ $videos['results'][0]['key'] }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $videos['results'][0]['key'] }}"
                            class="w-full h-full"
                            style="width: 100vw; height: 100vh; object-fit: cover;"
                            allow="autoplay; encrypted-media"
                            allowfullscreen></iframe>
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
                </div>
            @else
                <div class="absolute inset-0 w-full">
                    <img src="https://image.tmdb.org/t/p/original{{ $movie['backdrop_path'] }}"
                         alt="{{ $movie['title'] }}"
                         class="w-full h-full object-cover"
                         style="width: 100vw; height: 100vh; object-fit: cover;">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
                </div>
            @endif

            <!-- Movie Info Overlay -->
            <div class="absolute bottom-0 left-0 right-0">
                <div class="container mx-auto px-4 pb-12">
                    <div class="max-w-3xl">
                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">{{ $movie['title'] }}</h1>
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-2xl mr-2"></i>
                                <span class="text-2xl font-bold">{{ round($movie['vote_average'], 1) }}/10</span>
                            </div>
                            <span class="text-gray-300">|</span>
                            <span class="text-gray-300">{{ date('Y', strtotime($movie['release_date'])) }}</span>
                            <span class="text-gray-300">|</span>
                            <span class="text-gray-300">{{ $movie['runtime'] }} phút</span>
                            <span class="text-gray-300">|</span>
                            <div class="flex items-center space-x-2">
                                @foreach($movie['genres'] ?? [] as $genre)
                                    <span class="px-3 py-1 bg-red-600/20 text-red-400 rounded-full text-sm">{{ $genre['name'] }}</span>
                                @endforeach
                            </div>
                        </div>
                        <p class="text-gray-300 text-lg mb-8">{{ Str::limit($movie['overview'], 200) }}</p>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('movies.watch', $movie['id']) }}"
                               class="inline-flex items-center px-8 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                                <i class="fas fa-play mr-2"></i>
                                Xem phim
                            </a>
                            <button class="inline-flex items-center px-6 py-3 bg-gray-800/50 text-white rounded-lg hover:bg-gray-800 transition duration-300">
                                <i class="fas fa-plus mr-2"></i>
                                Thêm vào danh sách
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-3">
                    <!-- Cast Section -->
                    @if(isset($credits['cast']) && count($credits['cast']) > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-white mb-6">Diễn viên</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach(array_slice($credits['cast'], 0, 12) as $cast)
                            <div class="group">
                                <div class="relative aspect-[2/3] rounded-lg overflow-hidden mb-3">
                                    <img src="https://image.tmdb.org/t/p/w185{{ $cast['profile_path'] }}"
                                         alt="{{ $cast['name'] }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                </div>
                                <h3 class="text-white font-semibold group-hover:text-red-600 transition">{{ $cast['name'] }}</h3>
                                <p class="text-gray-400 text-sm">{{ $cast['character'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div>
                    <!-- Movie Info -->
                    <div class="bg-gray-800/50 rounded-lg p-6 mb-8">
                        <h2 class="text-xl font-bold text-white mb-4">Thông tin</h2>
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-gray-400 text-sm">Đạo diễn</h3>
                                <p class="text-white">
                                    @foreach($credits['crew'] ?? [] as $crew)
                                        @if($crew['job'] === 'Director')
                                            {{ $crew['name'] }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Ngôn ngữ</h3>
                                <p class="text-white">{{ $movie['original_language'] }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Ngày phát hành</h3>
                                <p class="text-white">{{ date('d/m/Y', strtotime($movie['release_date'])) }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-400 text-sm">Doanh thu</h3>
                                <p class="text-white">${{ number_format($movie['revenue']) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="bg-gray-800/50 rounded-lg p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Chia sẻ</h2>
                        <div class="flex items-center space-x-4">
                            <a href="#" class="w-10 h-10 flex items-center justify-center bg-blue-600 rounded-full hover:bg-blue-700 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center bg-blue-400 rounded-full hover:bg-blue-500 transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center bg-red-600 rounded-full hover:bg-red-700 transition">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Movies -->
        <div class="container mx-auto px-4 py-12">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-8">Phim tương tự</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                @foreach($similarMovies as $similarMovie)
                    <a href="{{ route('movies.detail', $similarMovie['id']) }}" class="group">
                        <div class="relative aspect-[2/3] rounded-lg overflow-hidden shadow-lg">
                            <img src="https://image.tmdb.org/t/p/w500{{ $similarMovie['poster_path'] }}"
                                 alt="{{ $similarMovie['title'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="text-white font-semibold text-base md:text-lg mb-2">{{ $similarMovie['title'] }}</h3>
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star mr-1"></i>
                                        <span>{{ round($similarMovie['vote_average'], 1) }}/10</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Comments Section -->
        <div class="container mx-auto px-4 py-12">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-8">Bình luận</h2>

            @auth
            <!-- Comment Form -->
            <div class="mb-8">
                <form id="commentForm" class="space-y-4">
                    @csrf
                    <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                    <div class="flex items-start space-x-4">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                             alt="{{ Auth::user()->name }}"
                             class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <textarea name="content" rows="3"
                                      class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                      placeholder="Viết bình luận của bạn..."></textarea>
                            <div class="mt-2 flex justify-end">
                                <button type="submit"
                                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                                    Gửi bình luận
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endauth

            <!-- Comments List -->
            <div id="commentsList" class="space-y-6">
                @foreach($comments as $comment)
                    <div class="flex items-start space-x-4" data-comment-id="{{ $comment->id }}">
                        <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                             alt="{{ $comment->user->name }}"
                             class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="bg-gray-800 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-white">{{ $comment->user->name }}</h4>
                                    <span class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-300" id="comment-content-{{ $comment->id }}">{{ $comment->content }}</p>

                                <!-- Comment Actions -->
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        @auth
                                        <button onclick="toggleLike({{ $comment->id }})"
                                                class="flex items-center space-x-1 text-gray-400 hover:text-red-500 transition">
                                            <i class="fas fa-heart {{ $comment->isLikedByUser(Auth::id()) ? 'text-red-500' : '' }}"></i>
                                            <span class="likes-count">{{ $comment->likes_count }}</span>
                                        </button>
                                        <button onclick="showReplyForm({{ $comment->id }})"
                                                class="text-gray-400 hover:text-white transition">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        @if(Auth::id() === $comment->user_id)
                                        <button onclick="editComment({{ $comment->id }})"
                                                class="text-gray-400 hover:text-white transition">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteComment({{ $comment->id }})"
                                                class="text-gray-400 hover:text-red-500 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                        @endauth
                                    </div>
                                </div>

                                <!-- Reply Form -->
                                <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden">
                                    <form class="space-y-2" onsubmit="submitReply(event, {{ $comment->id }})">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="content" rows="2"
                                                  class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                                  placeholder="Viết phản hồi..."></textarea>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" onclick="hideReplyForm({{ $comment->id }})"
                                                    class="px-4 py-1 text-gray-400 hover:text-white transition">
                                                Hủy
                                            </button>
                                            <button type="submit"
                                                    class="px-4 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                Gửi
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Edit Form -->
                                <div id="edit-form-{{ $comment->id }}" class="mt-4 hidden">
                                    <form class="space-y-2" onsubmit="updateComment(event, {{ $comment->id }})">
                                        @csrf
                                        <textarea name="content" rows="2"
                                                  class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                                                  id="edit-content-{{ $comment->id }}">{{ $comment->content }}</textarea>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" onclick="cancelEdit({{ $comment->id }})"
                                                    class="px-4 py-1 text-gray-400 hover:text-white transition">
                                                Hủy
                                            </button>
                                            <button type="submit"
                                                    class="px-4 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                Cập nhật
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Replies -->
                                <div class="mt-4 space-y-4">
                                    @foreach($comment->replies as $reply)
                                        <div class="ml-6 pl-4 border-l-2 border-gray-700">
                                            <div class="flex items-start space-x-4">
                                                <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}"
                                                     alt="{{ $reply->user->name }}"
                                                     class="w-8 h-8 rounded-full">
                                                <div class="flex-1">
                                                    <div class="bg-gray-700 rounded-lg p-3">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <h5 class="font-semibold text-white">{{ $reply->user->name }}</h5>
                                                            <span class="text-gray-400 text-xs">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-gray-300">{{ $reply->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Comment Form
document.getElementById('commentForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('/comments', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            const commentsList = document.getElementById('commentsList');
            const commentHtml = `
                <div class="flex items-start space-x-4" data-comment-id="${data.comment.id}">
                    <img src="${data.comment.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.comment.user.name)}"
                         alt="${data.comment.user.name}"
                         class="w-10 h-10 rounded-full">
                    <div class="flex-1">
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-white">${data.comment.user.name}</h4>
                                <span class="text-gray-400 text-sm">Vừa xong</span>
                            </div>
                            <p class="text-gray-300" id="comment-content-${data.comment.id}">${data.comment.content}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <button onclick="toggleLike(${data.comment.id})"
                                            class="flex items-center space-x-1 text-gray-400 hover:text-red-500 transition">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes-count">0</span>
                                    </button>
                                    <button onclick="showReplyForm(${data.comment.id})"
                                            class="text-gray-400 hover:text-white transition">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button onclick="editComment(${data.comment.id})"
                                            class="text-gray-400 hover:text-white transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteComment(${data.comment.id})"
                                            class="text-gray-400 hover:text-red-500 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            commentsList.insertAdjacentHTML('afterbegin', commentHtml);
            form.reset();
        }
    } catch (error) {
        console.error('Error:', error);
    }
});

// Reply Form
function showReplyForm(commentId) {
    document.getElementById(`reply-form-${commentId}`).classList.remove('hidden');
}

function hideReplyForm(commentId) {
    document.getElementById(`reply-form-${commentId}`).classList.add('hidden');
}

async function submitReply(e, commentId) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('/comments', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
            const repliesContainer = commentElement.querySelector('.mt-4.space-y-4');

            const replyHtml = `
                <div class="ml-6 pl-4 border-l-2 border-gray-700">
                    <div class="flex items-start space-x-4">
                        <img src="${data.comment.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.comment.user.name)}"
                             alt="${data.comment.user.name}"
                             class="w-8 h-8 rounded-full">
                        <div class="flex-1">
                            <div class="bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <h5 class="font-semibold text-white">${data.comment.user.name}</h5>
                                    <span class="text-gray-400 text-xs">Vừa xong</span>
                                </div>
                                <p class="text-gray-300">${data.comment.content}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            if (repliesContainer) {
                repliesContainer.insertAdjacentHTML('beforeend', replyHtml);
            }

            hideReplyForm(commentId);
            form.reset();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Edit Comment
function editComment(commentId) {
    document.getElementById(`edit-form-${commentId}`).classList.remove('hidden');
    document.getElementById(`comment-content-${commentId}`).classList.add('hidden');
}

function cancelEdit(commentId) {
    document.getElementById(`edit-form-${commentId}`).classList.add('hidden');
    document.getElementById(`comment-content-${commentId}`).classList.remove('hidden');
}

async function updateComment(e, commentId) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById(`comment-content-${commentId}`).textContent = data.comment.content;
            cancelEdit(commentId);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Delete Comment
async function deleteComment(commentId) {
    if (!confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
        return;
    }

    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            document.querySelector(`[data-comment-id="${commentId}"]`).remove();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Like Comment
async function toggleLike(commentId) {
    try {
        const response = await fetch(`/comments/${commentId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            const likeButton = document.querySelector(`[data-comment-id="${commentId}"] .fa-heart`);
            const likesCount = document.querySelector(`[data-comment-id="${commentId}"] .likes-count`);

            if (likeButton.classList.contains('text-red-500')) {
                likeButton.classList.remove('text-red-500');
                await fetch(`/comments/${commentId}/unlike`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
            } else {
                likeButton.classList.add('text-red-500');
            }

            likesCount.textContent = data.likes_count;
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
@endpush
@endsection
