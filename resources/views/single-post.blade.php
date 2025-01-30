<x-layout :doctitle="$postID->title">
    <div class="container py-md-5 container--narrow">
        <div class="d-flex justify-content-between">
            <h2>{{ $postID->title }}</h2>
            @can('update', $postID)
                <span class="pt-2">
                    <a href="/post/{{ $postID->id }}/edit" class="text-primary mr-2" data-toggle="tooltip"
                        data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                    <form class="delete-post-form d-inline" action="/post/{{ $postID->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top"
                            title="Delete"><i class="fas fa-trash"></i></button>
                    </form>
                </span>
            @endcan
        </div>

        <p class="text-muted small mb-4">
            <a href="/profile/{{$postID->user->username}}"><img class="avatar-tiny"
                    src="{{$postID->user->avatar}}" /></a>
            Posted by <a href="/profile/{{$postID->user->username}}">{{ $postID->user->username }}</a> on {{ $postID->created_at->format('n/j/Y') }}
        </p>

        <div class="body-content">
            <p>{!! $postID->body !!}</p>

        </div>
    </div>
</x-layout>
