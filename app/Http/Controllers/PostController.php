<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $posts = Post::with('user')->latest()->get();

        if($posts->count() > 0){
            return response()->json([
                'status'=> 200,
                'posts'=> $posts,
            ],200);
        }else{
            return response()->json([
                'status'=> 404,
                'message'=> 'No record found',
            ],404);
        }
    }

    public function fetch_post_user($id)
    {
        $posts = POST::where('user_id','=',$id)->latest()->get();

        if($posts->count() > 0){
            return response()->json([
                'status'=> 200,
                'posts'=> $posts,
            ],200);
        }else{
            return response()->json([
                'status'=> 404,
                'message'=> 'No record found',
            ],404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'body'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $post = Post::create([
                'title'=> $request->title,
                'body'=> $request->body,
                'user_id'=>$id
            ]);
            if($post){
                return response()->json([
                    'status'=> 200,
                    'message'=>'Posted Successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=> 500,
                    'message'=> 'Something went wrong'
                ],500);
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        if($post){
            return response()->json([
                'status'=> 200,
                'data'=>$post
            ],200);
        }else{
            return response()->json([
                'status'=> 404,
                'errors'=> 'Post no found'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'body'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'errors'=>$validator->messages()
            ],422);
        }else{
                $post=Post::find($id);

            if($post){
                $post->update([
                    'title'=> $request->title,
                    'body'=> $request->body,
                ]);
                return response()->json([
                    'status'=> 200,
                    'message'=>'Post Updated Successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message'=> 'Post not found'
                ],404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post){
            $post->delete();
            return response()->json([
                'status'=> 200,
                'message'=> 'Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=> 404,
                'errors'=> 'Post not found'
            ],404);
        }
    }
}
