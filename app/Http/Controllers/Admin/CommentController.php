<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Question;
use App\Services\CommentService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;

class CommentController extends Controller
{
    use ResponseTrait;

    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $data = $request->all();
        if(empty($data['new_comment'])) {
            return redirect()->back();
        }
        $this->commentService->create($question, $data);

        return redirect()->back();
    }

    public function resolved(Question $question, Comment $comment)
    {
        $this->commentService->resolved($question, $comment);
        return $this->redirectBackWithSuccess('resolved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Comment $comment)
    {
        $data = $request->all();
        if(empty($data['comment'])) {
            return redirect()->back();
        }
        $this->commentService->update($comment, $data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Comment $comment)
    {
        $this->commentService->delete($comment);
        return redirect()->back();
    }
}
