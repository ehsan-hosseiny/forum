<?php


namespace App\Repositories;

use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnswerRepository
{

    public function getAllAvailableThreads()
    {
//        return Thread::query()->whereFlag(1)->with([
//            'channel:id,name,slug',
//            'user:id,name'
//        ])->latest()->paginate(10);
        return Thread::all();
//        return Thread::whereFlag(1)->latest()->get();


    }

    public function getThreadBySlug($slug)
    {
//        return Thread::whereSlug($slug)->whereFlag(1)->with(['channel', 'user', 'answers', 'answers.user:id,name'])->first();
        return Thread::whereSlug($slug)->whereFlag(1)->first();
    }

    public function store(Request $request)
    {
        Thread::find($request->thread_id)->answers()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
        ]);
    }

    public function update(Request $request, Answer $answer)
    {
            $answer->update([
                'content' => $request->input('content'),
            ]);
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();
    }
}
