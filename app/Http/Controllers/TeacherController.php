<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $teachers = Teacher::latest()->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'position' => 'nullable|string|max:255',
            ], [
                'name.required' => 'Nama guru harus diisi',
                'name.string' => 'Nama guru harus berupa teks',
                'name.max' => 'Nama guru maksimal 255 karakter',
                'position.required' => 'Jabatan guru harus diisi',
                'position.string' => 'Jabatan guru harus berupa teks',
                'position.max' => 'Jabatan guru maksimal 255 karakter',
                'photo.image' => 'File harus berupa gambar',
                'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'photo.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Siapkan data untuk disimpan
            $data = $request->only(['name', 'position']);

            // Upload foto jika ada
            if ($request->hasFile('photo')) {
                $uploadedFile = $request->file('photo');
                if (!$uploadedFile || !$uploadedFile->isValid()) {
                    return redirect()->back()->with('error', 'File foto tidak valid atau tidak ditemukan');
                }
                // Upload ke Cloudinary
                $cloudinary = new CloudinaryService();
                $uploadResult = $cloudinary->upload($uploadedFile, 'teachers');
                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            } else {
                $data['image_url'] = null;
                $data['public_id'] = null;
            }

            Teacher::create($data);
    
            return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil ditambahkan.');
        }

        // Simpan data ke database
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\View\View
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\View\View
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Teacher $teacher)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'Nama guru harus diisi',
                'name.string' => 'Nama guru harus berupa teks',
                'name.max' => 'Nama guru maksimal 255 karakter',
                'photo.image' => 'File harus berupa gambar',
                'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'photo.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Siapkan data untuk diupdate
            $data = $request->only(['name']);

            // Upload foto baru jika ada
            if ($request->hasFile('photo')) {
                $uploadedFile = $request->file('photo');
                if (!$uploadedFile || !$uploadedFile->isValid()) {
                    return redirect()->back()->with('error', 'File foto tidak valid atau tidak ditemukan');
                }
                // Hapus foto lama dari Cloudinary jika ada
                if ($teacher->public_id ?? false) {
                    $cloudinary = new CloudinaryService();
                    $cloudinary->delete($teacher->public_id);
                }
                // Upload ke Cloudinary
                $cloudinary = new CloudinaryService();
                $uploadResult = $cloudinary->upload($uploadedFile, 'teachers');
                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }

            // Update data di database
            $teacher->update($data);

            return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Teacher $teacher)
    {
        try {
            // Hapus foto dari Cloudinary jika ada
            if ($teacher->public_id ?? false) {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($teacher->public_id);
            }
            // Hapus foto dari storage jika ada
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }

            // Hapus data dari database
            $teacher->delete();

            return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman pengelolaan guru dengan JavaScript
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function teacherManager()
    {
        return view('admin.teachers.manager');
    }

    /**
     * API untuk mendapatkan semua data guru
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex()
    {
        $teachers = Teacher::latest()->get();
        return response()->json($teachers);
    }

    /**
     * API untuk mendapatkan detail guru berdasarkan ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            return response()->json($teacher);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Guru tidak ditemukan'], 404);
        }
    }

    /**
     * API untuk menyimpan data guru baru
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Siapkan data untuk disimpan
            $data = $request->only(['name', 'position']);

            // Upload foto jika ada
            if ($request->hasFile('photo')) {
                $uploadedFile = $request->file('photo');
                if (!$uploadedFile || !$uploadedFile->isValid()) {
                    return response()->json(['error' => 'File foto tidak valid'], 400);
                }
                // Upload ke Cloudinary
                $cloudinary = new CloudinaryService();
                $uploadResult = $cloudinary->upload($uploadedFile, 'teachers');
                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }
            dd($data);
            $teacher = Teacher::create($data);
    
            return response()->json($teacher, 201);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    /**
     * API untuk mengupdate data guru
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $teacher = Teacher::findOrFail($id);

            // Siapkan data untuk diupdate
            $data = $request->only(['name', 'position']);

            // Upload foto baru jika ada
            if ($request->hasFile('photo')) {
                $uploadedFile = $request->file('photo');
                if (!$uploadedFile || !$uploadedFile->isValid()) {
                    return response()->json(['error' => 'File foto tidak valid'], 400);
                }
                // Hapus foto lama dari Cloudinary jika ada
                if ($teacher->public_id ?? false) {
                    $cloudinary = new CloudinaryService();
                    $cloudinary->delete($teacher->public_id);
                }
                // Upload ke Cloudinary
                $cloudinary = new CloudinaryService();
                $uploadResult = $cloudinary->upload($uploadedFile, 'teachers');
                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }

            $teacher->update($data);

            return response()->json($teacher);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * API untuk menghapus data guru
     * 
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiDestroy($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);

            // Hapus foto dari Cloudinary jika ada
            if ($teacher->public_id ?? false) {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($teacher->public_id);
            }
            // Hapus data dari database
            $teacher->delete();

            return response()->json(['message' => 'Guru berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan daftar guru di halaman frontend
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function teacherFrontend()
    {
        $teachers = Teacher::latest()->get();
        return view('frontend.teachers', compact('teachers'));
    }
}