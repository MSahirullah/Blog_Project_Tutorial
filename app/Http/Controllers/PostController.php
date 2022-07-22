<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index',);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'tags' => Tag::all(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        // $tags = explode(',', $request->tags);
        $tags = $request->tags;

        $post = new Post();

        $post->title = $request->title;

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');

            $imageName = $image->getClientOriginalName();
            $imageNewName = explode('.', $imageName)[0];
            $fileExtention = time() . '.' . $imageNewName . '.' . $image->getClientOriginalExtension();

            $location = storage_path('app/public/images/' . $fileExtention);

            Image::make($image)->resize(1200, 630)->save($location);

            $post->cover_image = $fileExtention;
        }

        $post->body = $request->body;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category_id;
        $post->published_at = $request->published_at;
        $post->meta_description = $request->meta_description;
        $post->author_id = Auth::user()->id;

        $post->save();

        $post->tags()->sync($tags);

        return redirect()->route('posts.index')->with('success', 'Post successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'tags' => Tag::all(),
            'categories' => Category::all(),
            'oldTags' => $post->tags->pluck('id')->toArray(),
        ]);
        //compact('post', 'tags', 'categories');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $tags = $request->tags;

        //$post->update($request->all());

        $post->title = $request->title;
        $post->body = $request->body;
        $post->slug = Str::slug($request->title);
        $post->category_id = $request->category_id;
        $post->published_at = $request->published_at;
        $post->meta_description = $request->meta_description;
        $post->author_id = Auth::user()->id;

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');

            $imageName = $image->getClientOriginalName();
            $imageNewName = explode('.', $imageName)[0];
            $fileExtention = time() . '.' . $imageNewName . '.' . $image->getClientOriginalExtension();

            $location = storage_path('app/public/images/' . $fileExtention);

            Image::make($image)->resize(1200, 630)->save($location);

            $post->cover_image = $fileExtention;

            File::delete(storage_path('app/public/images/' . $post->cover_image));
        }

        $post->save();

        $post->tags()->sync($tags);

        return redirect()->route('posts.index')->with('success', 'Post successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
