<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Followings">
    <div class="list-group">
        @foreach ($following as $followings)
            <a wire:navigate href="/profile/{{ $followings->userBeingFollowed->username }}" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{ $followings->userBeingFollowed->avatar }}" />
                {{$followings->userBeingFollowed->username}}
            </a>
        @endforeach
    </div>
</x-profile>
