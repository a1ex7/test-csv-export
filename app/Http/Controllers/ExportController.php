<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentsExportRequest;
use App\Http\Services\CsvExportService;
use App\Http\Transformers\CoursesToCsvTransformer;
use App\Http\Transformers\StudentToCsvTransformer;
use App\Models\Student;
use DB;

class ExportController extends Controller
{
    /**
     * @var CsvExportService
     */
    private $csvExportService;

    /**
     * ExportController constructor.
     * @param CsvExportService $csvExportService
     */
    public function __construct(CsvExportService $csvExportService)
    {

        $this->csvExportService = $csvExportService;
    }

    public function welcome()
    {
        return view('hello');
    }

    /**
     * View all students found in the database
     */
    public function viewStudents()
    {
        $students = Student::with('course')->get();
        return view('view_students', compact('students'));
    }

    /**
     * Exports all student data to a CSV file
     * @param StudentsExportRequest $request
     * @return string
     * @throws \League\Csv\CannotInsertRecord
     */
    public function exportStudentsToCSV(StudentsExportRequest $request)
    {
        $students = Student::whereIn('id', $request->studentIds)->get();

        return $this->csvExportService->createCsv($students, 'students', new StudentToCsvTransformer());
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     * @throws \League\Csv\CannotInsertRecord
     */
    public function exportCourseAttendenceToCSV()
    {
        $coursesStudents = Student::select(DB::raw('courses.id, courses.course_name, COUNT(course_id) AS students'))
            ->join('courses', 'courses.id', '=', 'students.course_id')
            ->groupBy('course_id')->get();

        return $this->csvExportService->createCsv($coursesStudents, 'courses_students', new CoursesToCsvTransformer());
    }
}
