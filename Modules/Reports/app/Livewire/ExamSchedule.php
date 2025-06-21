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

        $students = User::with(['current_enrolled_courses'])->has('student')->has('current_enrollments')->get();

        if(!Storage::exists('exam_schedules')){
            Storage::createDirectory('exam_schedules');
        }

        if (!$this->csv) {
            $csv = fopen(Storage::path('exam_schedules/') . Carbon::now()->format('m_Y') . '.csv', 'w');
            foreach ($students as $student) {
                foreach ($student->current_enrolled_courses as $course) {
                    fputcsv($csv, [$student->fullName(), $course->name], ';', '');
                }
            }
            fclose($csv);
            $csv = Storage::path('exam_schedules/') . Carbon::now()->format('m_Y') . '.csv';
        } else {
            $csv = $this->csv;
            $csv = Storage::putFileAs('exam_schedules', $csv, Carbon::now()->format('m_Y') . '.csv');
        };

        $start_date      = $data['start_date'];
        $end_date        = $data['end_date'];
        $holidays = isset($data['holidays']) && $data['holidays'][0] != "" ? "--holidays " . implode(' ', $data['holidays']): "";
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

        notyf()->success('Exam generated successfully!');
    }

    public function render()
    {
        $files = Storage::files('final_schedule');

        if (!empty($files)) {
            /*
            Ammar => Put here the view for either go to generate another
            schedule thus => (delete the "contents" of `final_schedule` folder) or download the zip file


            NOTE there will be a file named output.zip if there is generated schedule
            */
        }
        return view('reports::livewire.exam-schedule')->title(__('sidebar.exam_schedule_generate'));
    }
}
