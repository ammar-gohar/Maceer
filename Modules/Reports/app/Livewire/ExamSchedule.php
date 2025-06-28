<?php

namespace Modules\Reports\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Semesters\Models\Semester;
use ZipArchive;
use Illuminate\Support\Facades\File as FileHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;

function createZipFromPaths(array $paths, string $zipName = 'output.zip'): bool
{
    $zip = new ZipArchive;
    $zipPath = $zipName;

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return false;
    }

    foreach ($paths as $path) {
        if (FileHelper::isFile($path)) {
            $zip->addFile($path, basename($path));
        } elseif (FileHelper::isDirectory($path)) {
            $files = FileHelper::allFiles($path);
            foreach ($files as $file) {
                $filePath = $file->getRealPath();
                $relativePath = Str::after($filePath, "prepare_schedule" . DIRECTORY_SEPARATOR);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    return $zip->close();
}

function isPythonRunning()
{
    if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
        // Windows: use `tasklist`
        $output = shell_exec('tasklist');
        return preg_match('/python([\d\.]*)?\.exe exam_scheduler.py/i', $output);
    } else {
        // Unix-like: use `ps`
        $output = shell_exec('ps aux');
        return preg_match('/python([\d\.]*)? exam_scheduler.py/', $output);
    }
}

class ExamSchedule extends Component
{
    use WithFileUploads;

    public $start_date;
    public $end_date;
    public $include_fridays = false;
    public $include_graphs = false;
    public $holidays = [''];
    public $semesterId;
    public $schedules_number;
    public $csv;
    public $files;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()?->id;

        if(!$this->semesterId)
        {
            return $this->redirect('/semester');
        }
    }

    public function addHoliday()
    {
        $this->holidays[] = '';
    }

    public function removeHoliday($index)
    {
        unset($this->holidays[$index]);
        $this->holidays = array_values($this->holidays); // Reindex array
    }

    public function generate_exam()
    {
        set_time_limit(0);

        $data = $this->validate([
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'schedules_number' => 'required|integer|min:1',
            'csv'              => 'nullable|mimes:csv',
            'holidays.*'       => 'nullable|date|after_or_equal:start_date|before_or_equal:end_date',
        ]);

        if (isPythonRunning()) {
            notyf()->error("There is a table already generating!!");
            return;
        }

        $students = User::with(['current_enrolled_courses'])->has('student')->has('current_enrollments')->get();

        if(!Storage::exists('exam_schedules')){
            Storage::createDirectory('exam_schedules');
        }

        if (!$this->csv) {
            $csv = fopen(Storage::path('exam_schedules/') . Carbon::now()->format('m_Y') . '.csv', 'w');
            foreach ($students as $student) {
                foreach ($student->current_enrolled_courses as $course) {
                    fputcsv($csv, [$student->full_name, $course->name], ';', '');
                }
            }
            fclose($csv);
            $csv = Storage::path('exam_schedules/') . Carbon::now()->format('m_Y') . '.csv';
        } else {
            $csv = $this->csv;
            $csv = Storage::putFileAs('exam_schedules', $csv, $csv->getClientOriginalName());
        };

        $start_date      = $data['start_date'];
        $end_date        = $data['end_date'];
        $holidays = isset($data['holidays']) && $data['holidays'][0] != "" ? "--holidays " . implode(',', $data['holidays']): "";
        $include_fridays = $this->include_fridays ? "--fridays": ""; //bool
        $include_graphs  = $this->include_graphs ? "generate_plots": "no"; //bool
        $schedules_number = $data['schedules_number'];

        $root = $_SERVER['DOCUMENT_ROOT'] . '/..';
        $storage_path = $root . '/storage/app/private';

        FileHelper::cleanDirectory($storage_path . '/prepare_schedule');

        if ($schedules_number > 1)
        {
            for ($i = 1; $i <= $schedules_number; $i++)
            {
                if (PHP_OS_FAMILY === 'Windows') {
                    $pythonScript = "$root/venv/Scripts/activate && python $root/exam_scheduler.py $include_fridays $holidays $storage_path/$csv $include_graphs $start_date $end_date $storage_path prepare_schedule/$i 2>&1";
                }
                else {
                    $pythonScript = "bash -c 'source $root/venv/bin/activate && python3 $root/exam_scheduler.py $include_fridays $holidays $storage_path/$csv $include_graphs $start_date $end_date $storage_path prepare_schedule/$i 2>&1'";
                }
                shell_exec($pythonScript);
                sleep(1);
            }
        }
        else
        {
            if (PHP_OS_FAMILY === 'Windows') {
                $pythonScript = "$root/venv/Scripts/activate && python $root/exam_scheduler.py $include_fridays $holidays $storage_path/$csv $include_graphs $start_date $end_date $storage_path prepare_schedule 2>&1";
            }
            else {
                $pythonScript = "bash -c 'source $root/venv/bin/activate && python3 $root/exam_scheduler.py $include_fridays $holidays $storage_path/$csv $include_graphs $start_date $end_date $storage_path prepare_schedule 2>&1'";
            }
            $out = shell_exec($pythonScript);
        }

        createZipFromPaths([$storage_path . '/prepare_schedule'], "$storage_path/final_schedule/output.zip");

        FileHelper::cleanDirectory($storage_path . '/prepare_schedule');

        if (count(Storage::files('final_schedule')) == 0) {
            notyf()->error("Can't generate a schedule with the given parameters!");
        } else {
            notyf()->success('Exam generated successfully!');
        }

    }

    public function new_schedule()
    {
        $this->start_date = null;
        $this->end_date = null;
        $this->include_fridays = false;
        $this->include_graphs = false;
        $this->holidays = [''];
        $this->schedules_number = 1;
        $this->csv = null;
        Storage::delete([$this->files['csv'], $this->files['zip']]);
        $this->files = [];
        return;
    }

    public function download($file)
    {
        return response()->download(Storage::path($this->files[$file]), basename($this->files[$file]));
    }

    public function render()
    {
        $files = Storage::files('final_schedule');

        if (!empty($files)) {

            $this->files = [
                'csv' => Storage::files('exam_schedules')[0],
                'zip' => Storage::files('final_schedule')[0],
            ];

        }
        return view('reports::livewire.exam-schedule')->title(__('sidebar.exam_schedule_generate'));
    }
}
