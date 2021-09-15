@extends('layouts.app')

@section('content')

<div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg">
    <h1>Posts</h1>
    <form action="{{ route('posts') }}" method="post" class="mb-4">
        @csrf
        <div class="mb-4">
            <label for="body" class="sr-only">Body</label>
            <textarea name="body" id="body" cols="30" rows="4" class="bg-gray=100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror" placeholder="Post Apa apa!"></textarea>
        
        @error('body')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
        </div> 
        
        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Post</button>
        </div>

    </form>

    @if ($posts->count())
        @foreach ($posts as $post)

        <div class="mb-4">
            <span class="text-gray-600 text-sm">{{ $post->body }} date: {{ $post->created_at->diffForHumans() }}</span>
            <P>Owner: {{ $post->user->name }}</P>

            {{-- Ikut Policy, Kalau user ID sama dengan user ID dlm Post, baru blh delete --}}
                {{-- So kena check policy file PostPolicy --}}
                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post) }}" method="post" class="mr-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-blue-500">Delete</button>
                    </form>
                @endcan

            <div class="flex items-center">
                    {{-- Sapa yang dah login boleh Like atau Unlike --}}
                    @auth
                        @if (!$post->likedBy(auth()->user()))
                            <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                                @csrf
                                <button type="submit" class="text-blue-500">Like</button>
                            </form>
                        @else
                            <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-500">Unlike</button>
                            </form>
                        @endif
                    @endauth 

                <span>{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</span>

            </div>

        </div>
        @endforeach

        {{ $posts->links() }}

    @else
        <P>no Record Found</P>
    @endif

    </div>
</div>
@endsection



