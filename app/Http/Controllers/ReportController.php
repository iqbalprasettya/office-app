<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Job;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportController extends Controller
{
    public function index()
    {
        // Mengambil laporan milik pengguna yang sedang login
        $reports = Report::where('user_id', Auth::id())->with('jobs')->get();
        $user = Auth::user();
        $departments = Department::all(); // Ambil semua department
        // return view('reports.index', compact('reports', 'user', 'departments'));

        return view('report.index', [
            'reports' => $reports,
            'departments' => $departments,
            'userDepartment' => $user->department // Ambil department pengguna saat ini
        ]);
    }


    // create
    public function create()
    {
        return view('report.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reports.*.date' => 'required|date',
            'reports.*.jobs.*.description' => 'required|string',
            'reports.*.jobs.*.status' => 'required|in:Selesai,Belum Selesai',
        ]);

        foreach ($request->reports as $reportData) {
            $report = Report::create([
                'user_id' => Auth::id(),
                'date' => $reportData['date'],
            ]);

            foreach ($reportData['jobs'] as $jobData) {
                Job::create([
                    'report_id' => $report->id,
                    'description' => $jobData['description'],
                    'status' => $jobData['status'],
                ]);
            }
        }

        return redirect()->route('report')->with('success', 'Reports added successfully');
    }

    // Method untuk menampilkan form edit
    public function edit($id)
    {
        $report = Report::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $jobs = $report->jobs;
        return view('report.edit', compact('report', 'jobs'));
    }

    // Method untuk memperbarui laporan
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'jobs.*.description' => 'required|string|max:255',
            'jobs.*.status' => 'required|string|max:50',
        ]);

        $report = Report::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $report->date = $request->input('date');
        $report->save();

        // Delete existing jobs
        $report->jobs()->delete();

        // Add updated jobs
        foreach ($request->input('jobs') as $job) {
            $report->jobs()->create([
                'description' => $job['description'],
                'status' => $job['status'],
            ]);
        }

        return redirect()->route('report')->with('success', 'Report updated successfully');
    }

    // Method untuk menghapus laporan
    public function destroy($id)
    {
        $report = Report::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $report->delete();

        return redirect()->route('report')->with('success', 'Report deleted successfully');
    }


    // FILTER
    public function display(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $department = $request->input('department');

        $reports = Report::with('jobs', 'user.department')
            ->whereBetween('date', [$from, $to])
            ->whereHas('user', function ($query) use ($department) {
                $query->where('department_id', $department);
            })
            ->get();

        return response()->json($reports);
    }

    public function export(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $department = $request->input('department');

        $reports = Report::with('jobs', 'user.department')
            ->whereBetween('date', [$from, $to])
            ->whereHas('user', function ($query) use ($department) {
                $query->where('department_id', $department);
            })
            ->get();

        if ($reports->isEmpty()) {
            // Mengembalikan response JSON jika tidak ada data
            return response()->json([
                'success' => false,
                'message' => 'No data available for the selected filters.'
            ]);
        }

        $exportData = [];
        foreach ($reports as $report) {
            foreach ($report->jobs as $job) {
                $exportData[] = [
                    'Tanggal' => $report->date,
                    'Deskripsi' => $job->description,
                    'Status' => $job->status,
                    'Employee' => $report->user->name,
                    'Department' => $report->user->department->name,
                ];
            }
        }

        // Generate filename with current date and time
        $timestamp = now()->format('Ymd_His');
        $filename = "reports_{$timestamp}.xlsx";

        return Excel::download(new ReportsExport($exportData), $filename);
    }
}
