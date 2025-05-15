<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, $id)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'type'     => 'required|in:essay,choice',
            'options'  => 'nullable|array',
            'is_assessment'  => 'nullable|boolean',
        ]);

        $data['questionnaire_id'] = $id;
        $data['options'] = $data['type'] === 'choice' ? json_encode($data['options']) : null;

        $question = Question::create($data);

        return response()->json($question);
    }

    public function update(Request $request, $id, Question $question)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'type'     => 'required|in:essay,choice',
            'options'  => 'nullable|array',
            'is_assessment'  => 'nullable|boolean',
        ]);

        $data['options'] = $data['type'] === 'choice' ? json_encode($data['options']) : null;

        $question->update($data);

        return response()->json($question);
    }

    public function destroy($id, Question $question)
    {
        $question->delete();

        return response()->json(['message' => 'Berhasil menghapus pertanyaan.']);
    }
}
