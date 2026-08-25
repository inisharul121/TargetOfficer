<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Subject;
use Illuminate\Http\Request;

class TaxonomyApiController extends Controller
{
    public function subjects()
    {
        $subjects = Subject::with('topics')->where('is_active', true)->get();
        return response()->json(['status' => 'success', 'data' => $subjects]);
    }

    public function setterBodies()
    {
        $setters = Organization::where('is_question_setter', true)->withCount('setterQuestions')->get();
        return response()->json(['status' => 'success', 'data' => $setters]);
    }
}
