<?php

namespace Modules\Quizzes\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Courses\Models\Course;
use Modules\Quizzes\Models\Question;
use Modules\Quizzes\Models\Quiz;
use Modules\Semesters\Models\Semester;

class QuizzesCreate extends Component
{

    public $title;
    public $description = null;
    public $start_time;
    public $end_time;
    public $total_marks;
    public $duration_minutes;
    public $courseId;
    public $semesterId;
    public $currentTab = [];
    public $courseName;
    public array $questions = [];

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()?->id;

        if (!$this->semesterId && Auth::user()->hasPermissionTo('semester')) {
            return $this->redirect('/semester');
        }

        $course = Course::findOrFail($this->courseId);
        $this->courseName = $course->name;

        if(!$this->currentTab){
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.add_questions');
        }

        $this->addQuestion();

    }

    public function change_tab()
    {
        if($this->currentTab['show'] == 1) {
            $this->currentTab['show'] = 2;
            $this->currentTab['btn'] = __('forms.back');
        } else {
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.add_questions');
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

    public function updated()
    {
        debugbar()->info($this->questions);
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

    public function add_quiz()
    {
        // dd($this->questions);

        $data = $this->validate();

        DB::beginTransaction();

        try {

            $total_marks = 0;
            foreach($data['questions'] as $q){
                $total_marks += $q['mark'];
            }

            $quiz = Quiz::create([
                'semester_id'      => $this->semesterId,
                'course_id'        => $this->courseId,
                'title'            => $data['title'],
                'description'      => $data['description'],
                'total_marks'      => $total_marks,
                'start_time'       => $data['start_time'],
                'end_time'         => $data['end_time'],
                'duration_minutes' => $data['duration_minutes'],
                'is_active'        => 0,
                'created_by'       => Auth::id(),
            ]);

            foreach ($data['questions'] as $q) {
                $question = Question::create([
                    'quiz_id'        => $quiz->id,
                    'question_text'  => $q['question_text'],
                    'type'           => $q['type'],
                    'marks'          => $q['mark'],
                    'correct_answer' => $q['correct_answer'],
                ]);

                if ($q['type'] === 'mcq') {
                    $i = 0;
                    foreach ($q['options'] as $option) {
                        $question->options()->create([
                            'option_text' => $option['option_text'],
                            'is_correct'  => $q['correct_answer'] == $i,
                        ]);
                        $i++;
                    }
                }
            }

            DB::commit();

            return notyf()->success(__('modules.quizzes.quiz_created.success'));

        } catch (\Exception $e) {
            // Something went wrong, rollback
            DB::rollBack();

            return notyf()->error('error', 'Order failed: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('quizzes::livewire.pages.quizzes-create');
    }
}
