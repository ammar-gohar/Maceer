<?php

namespace Modules\Quizzes\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Quizzes\Models\Question;
use Modules\Quizzes\Models\Quiz;
use Modules\Semesters\Models\Semester;

class QuizzesEdit extends Component
{
    public $quizId;
    public $title;
    public $description;
    public $start_time;
    public $end_time;
    public $total_marks;
    public $duration_minutes;
    public $courseId;
    public $semesterId;
    public $currentTab = [];
    public $courseName;
    public array $questions = [];
    public $is_active;

    public function mount($quizId)
    {
        $this->quizId = $quizId;
        $quiz = Quiz::with(['questions.options'])->findOrFail($this->quizId);

        $this->semesterId = $quiz->semester_id;
        $this->courseId = $quiz->course_id;
        $this->title = $quiz->title;
        $this->description = $quiz->description;
        $this->start_time = $quiz->start_time;
        $this->end_time = $quiz->end_time;
        $this->duration_minutes = $quiz->duration_minutes;
        $this->is_active = $quiz->is_active;
        $this->total_marks = $quiz->total_marks;

        $course = Course::findOrFail($this->courseId);
        $this->courseName = $course->name;

        if(!$this->currentTab){
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.edit_questions');
        }

        $this->questions = $quiz->questions->map(function($question) {
            $questionData = [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'type' => $question->type,
                'mark' => $question->marks,
                'correct_answer' => $question->correct_answer,
                'options' => []
            ];

            if ($question->type === 'mcq') {
                $questionData['options'] = $question->options->map(function($option) {
                    return [
                        'id' => $option->id,
                        'option_text' => $option->option_text,
                        'is_correct' => $option->is_correct
                    ];
                })->toArray();
            }

            return $questionData;
        })->toArray();
    }

    public function change_tab()
    {
        if($this->currentTab['show'] == 1) {
            $this->currentTab['show'] = 2;
            $this->currentTab['btn'] = __('forms.back');
        } else {
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.edit_questions');
        }
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question_text' => '',
            'type' => 'mcq',
            'mark' => 1,
            'options' => [
                ['option_text' => ''],
                ['option_text' => ''],
                ['option_text' => ''],
                ['option_text' => ''],
            ],
            'correct_answer' => '',
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function moveUp($index)
    {
        if ($index > 0) {
            $temp = $this->questions[$index - 1];
            $this->questions[$index - 1] = $this->questions[$index];
            $this->questions[$index] = $temp;
        }
    }

    public function moveDown($index)
    {
        if ($index < count($this->questions) - 1) {
            $temp = $this->questions[$index + 1];
            $this->questions[$index + 1] = $this->questions[$index];
            $this->questions[$index] = $temp;
        }
    }

    public function rules()
    {
        return [
            'title'                             => 'bail|required|string',
            'description'                       => 'bail|nullable',
            'start_time'                        => 'bail|required|date|after_or_equal:tomorrow',
            'end_time'                          => 'bail|required|date|after:start_time',
            'duration_minutes'                  => 'bail|required|integer|min:0',
            'questions.*.question_text'         => 'bail|required|string',
            'questions.*.type'                  => 'bail|required|in:mcq,true_false,short_answer,long_answer',
            'questions.*.mark'                  => 'bail|required|min:1',
            'questions.*.correct_answer'        => 'bail|required_if:questions.*.type,mcq,true_false,short_answer',
            'questions.*.options'               => 'bail|nullable|array',
            'questions.*.options.*.option_text' => 'bail|nullable',
        ];
    }

    public function update_quiz()
    {
        $data = $this->validate();

        DB::beginTransaction();

        try {
            $total_marks = 0;
            foreach($data['questions'] as $q) {
                $total_marks += $q['mark'];
            }

            $quiz = Quiz::findOrFail($this->quizId);
            $quiz->update([
                'title'            => $data['title'],
                'description'      => $data['description'],
                'total_marks'      => $total_marks,
                'start_time'       => $data['start_time'],
                'end_time'         => $data['end_time'],
                'duration_minutes' => $data['duration_minutes'],
                'is_active'        => $this->is_active,
            ]);

            $existingQuestionIds = $quiz->questions->pluck('id')->toArray();
            $updatedQuestionIds = [];

            foreach ($data['questions'] as $q) {
                if (isset($q['id'])) {
                    $question = Question::find($q['id']);
                    $question->update([
                        'question_text'  => $q['question_text'],
                        'type'           => $q['type'],
                        'marks'          => $q['mark'],
                        'correct_answer' => $q['correct_answer'],
                    ]);
                    $updatedQuestionIds[] = $q['id'];
                } else {
                    $question = Question::create([
                        'quiz_id'        => $quiz->id,
                        'question_text'  => $q['question_text'],
                        'type'           => $q['type'],
                        'marks'          => $q['mark'],
                        'correct_answer' => $q['correct_answer'],
                    ]);
                    $updatedQuestionIds[] = $question->id;
                }

                if ($q['type'] === 'mcq') {
                    $this->updateMcqOptions($question, $q);
                }
            }

            Question::where('quiz_id', $quiz->id)
                    ->whereNotIn('id', $updatedQuestionIds)
                    ->delete();

            DB::commit();

            return notyf()->success(__('modules.quizzes.quiz_updated.success'));

        } catch (\Exception $e) {
            DB::rollBack();
            return notyf()->error('error', 'Update failed: '.$e->getMessage());
        }
    }

    protected function updateMcqOptions($question, $questionData)
    {
        if (!isset($questionData['options'])) return;

        $existingOptionIds = $question->options->pluck('id')->toArray();
        $updatedOptionIds = [];

        foreach ($questionData['options'] as $index => $option) {
            if (isset($option['id'])) {
                $question->options()
                        ->where('id', $option['id'])
                        ->update([
                            'option_text' => $option['option_text'],
                            'is_correct' => $questionData['correct_answer'] == $index,
                        ]);
                $updatedOptionIds[] = $option['id'];
            } else {
                $newOption = $question->options()->create([
                    'option_text' => $option['option_text'],
                    'is_correct' => $questionData['correct_answer'] == $index,
                ]);
                $updatedOptionIds[] = $newOption->id;
            }
        }

        $question->options()
                ->whereNotIn('id', $updatedOptionIds)
                ->delete();
    }

    public function render()
    {
        return view('quizzes::livewire.pages.quizzes-edit');
    }
}
