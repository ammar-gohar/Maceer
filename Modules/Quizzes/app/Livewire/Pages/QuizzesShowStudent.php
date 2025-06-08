<?php

namespace Modules\Quizzes\Livewire\Pages;

use Carbon\Carbon;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Quizzes\Models\Answer;
use Modules\Quizzes\Models\Attemp;
use Modules\Quizzes\Models\QuestionOption;
use Modules\Quizzes\Models\Quiz;
use Modules\Semesters\Models\Semester;

class QuizzesShowStudent extends Component
{

    public Quiz $quiz;
    public $questions = [];
    public $answers = [];
    public $submitted = null;
    public $semesterId;
    public $courseName;
    public $courseId;
    public $remainingSeconds;
    public $attempt;

    public function mount($id)
    {
        $this->semesterId = Semester::where('is_current', 1)->first()->id;
        $quiz = Quiz::with(['course', 'questions', 'questions.options', 'questions.correct_option', 'attempts'])->findOrFail($id);
        $this->quiz = $quiz;
        $course = $quiz->course;
        $this->courseName = $course->name;
        $this->courseId = $course->id;
        $this->questions = $quiz->questions()->with('options', 'correct_option')->get()->shuffle();

        if($quiz->semester_id !== $this->semesterId || Carbon::now() < $quiz->start_time || Carbon::now() > $quiz->end_time || !$quiz->is_active || !Auth::user()->current_enrolled_courses->contains('id', $quiz->course_id) || $quiz->attempts?->where('student_id', Auth::id())->first()?->submitted_at !== null)
        {
            return $this->redirect('/quizzes');
        }

        if(!$quiz->attempts?->where('student_id', Auth::id())->first())
        {
            $time = $this->quiz->duration_minutes * 60 + 1;
            $this->attempt = Attemp::create([
                'quiz_id' => $this->quiz->id,
                'student_id' => Auth::id(),
                'started_at' => Carbon::now(),
                'remaining_seconds' => $time,
            ]);

            $this->remainingSeconds = $time;

        } else {

            $this->attempt = $quiz->attempts?->where('student_id', Auth::id())->first();

            $time = (integer) (-1 * Carbon::parse($this->attempt->started_at)->addSeconds($quiz->duration_minutes * 60)->diffInSeconds(Carbon::now()));

            $this->attempt->update([
                'remaining_seconds' => $time,
            ]);

            $this->remainingSeconds = $time;

        };

    }

    public function submit()
    {
        if($this->attempt->submitted_at !== null){
            $this->submitted = true;
            return;
        }

        $this->submitted = true;

        $correctCount = 0;

        foreach ($this->questions as $question) {

            $studentAnswer = $this->answers[$question->id] ?? null;

            $isCorrect = false;

            switch ($question->type) {
                case 'mcq':
                    $isCorrect = $question->correct_option->id == $studentAnswer;
                    Answer::create([
                        'attempt_id' => $this->attempt->id,
                        'question_id' => $question->id,
                        'selected_option_id' => $studentAnswer,
                        'is_correct' => $isCorrect,
                        'marks_obtained' => $question->marks
                    ]);
                    break;
                case 'true_false':
                    $isCorrect = $studentAnswer === $question->correct_answer;
                    break;
                case 'short_answer':
                case 'long_answer':
                    $isCorrect = strtolower(trim($studentAnswer)) === strtolower(trim($question->correct_answer));
                    break;
            }

            if ($isCorrect) {
                $correctCount += $question->marks;
            }

            if($question->type != 'mcq'){
                Answer::create([
                    'attempt_id' => $this->attempt->id,
                    'question_id' => $question->id,
                    'answer_text' => $studentAnswer,
                    'is_correct' => $isCorrect,
                    'marks_obtained' => $question->marks
                ]);
            }
        }

        $this->attempt->update([
            'score' => $correctCount,
            'submitted_at' => Carbon::now(),
            'remaining_seconds' => 0,
        ]);

        $this->remainingSeconds = 0;

        return notyf()->success(App::isLocale('ar') ? 'نجح التأكيد' : 'submitted');
    }

    public function render()
    {

        if($this->attempt->submitted_at === null){

            if(Carbon::now() > Carbon::parse($this->attempt->started_at)->addSeconds($this->quiz->duration_minutes * 60) || $this->attempt->remaining_seconds > $this->quiz->duration_minutes * 60 + 1 ){

                $this->attempt->update([
                    'remaining_seconds' => 0,
                ]);

                $this->submit();

            } else {

                $this->attempt->update([
                    'remaining_seconds' => $this->remainingSeconds - 1,
                ]);

                $this->remainingSeconds = $this->attempt->remaining_seconds;

            }

        }

        return view('quizzes::livewire.pages.quizzes-show-student');
    }
}
