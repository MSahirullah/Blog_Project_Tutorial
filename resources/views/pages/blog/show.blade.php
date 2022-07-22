<x-base-layout>

    {{--Meta Description--}}
    @section('meta_description', $post->metaDescription())

    {{--Facebook Meta Description--}}
    @section('og:title', $post->title)
    @section('og:image', 'storage/images'.$post->cover_image)

    {{--Title--}}
    @section('title', $post->title)


    <main class="min-h-screen">
        <section class="container pt-24 mx-auto space-y-4">

            <article class="p-4 bg-white">
                <h1 class="font-bold text-2xl mb-3">
                    {{$post->title}}

                </h1>

                <div>
                    {!!$post->body!!}
                </div>


                <button class="pt-2 mt-16 text-xs text-white bg-blue-500">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}" target="_blank">Share On Facebook</a>
                </button>
            </article>




        </section>
    </main>
</x-base-layout>