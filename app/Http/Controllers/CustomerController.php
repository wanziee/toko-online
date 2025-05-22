<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Helpers\ImageHelper;

class CustomerController extends Controller
{

    public function index()
    {
        $customer = Customer::orderBy('id', 'desc')->get();
        return view('backend.v_customer.index', [
            'judul' => 'Customer',
            'sub' => 'Halaman Customer',
            'index' => $customer
        ]);
    }
    // Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function callback()
    {
        try {
            Log::info('Callback dari Google dimulai');

            // Mendapatkan informasi pengguna dari Google
            $socialUser = Socialite::driver('google')->user();

            // Debug: Tampilkan info socialUser
            Log::info('Data socialUser', [
                'id' => $socialUser->id,
                'email' => $socialUser->email,
                'name' => $socialUser->name,
            ]);

            // Cek apakah email sudah terdaftar
            $registeredUser = User::where('email', $socialUser->email)->first();

            if (!$registeredUser) {
                // Jika email belum terdaftar, buat user baru
                Log::info('Email belum terdaftar, membuat user baru', ['email' => $socialUser->email]);

                $user = User::create([
                    'nama' => $socialUser->name,
                    'email' => $socialUser->email,
                    'role' => '2', // Role customer
                    'status' => 1, // Status aktif
                    'password' => Hash::make('default_password'), // Password default
                ]);

                Log::info('User baru berhasil dibuat', ['user' => $user]);

                // Buat data customer
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'google_id' => $socialUser->id,
                    'google_token' => $socialUser->token
                ]);

                Log::info('Customer baru berhasil dibuat', ['customer' => $customer]);

                // Login pengguna baru
                Auth::login($user);
            } else {
                // Jika email sudah terdaftar, langsung login
                Log::info('Email sudah terdaftar, langsung login', ['email' => $socialUser->email]);
                Auth::login($registeredUser);
            }

            // Redirect ke halaman utama setelah login
            return redirect()->intended('beranda');
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            Log::error('Terjadi kesalahan saat login dengan Google', [
                'error' => $e->getMessage(),
            ]);

            // Redirect ke halaman utama jika terjadi kesalahan
            return redirect('/')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        Log::info('User logout dimulai');

        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerate token CSRF

        Log::info('User berhasil logout');

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    public function akun($id)
    {
        $loggedInCustomerId = Auth::user()->id;
        if ($id != $loggedInCustomerId) {
            return redirect()->route('customer.akun', ['id' => $loggedInCustomerId])
                ->with('msgError', 'Anda tidak berhak mengakses akun ini.');
        }

        $customer = Customer::where('user_id', $id)->firstOrFail();
        return view('v_customer.edit', [
            'judul' => 'Customer',
            'subJudul' => 'Akun Customer',
            'edit' => $customer
        ]);
    }

    public function updateAkun(Request $request, $id)
    {
        $customer = Customer::where('user_id', $id)->firstOrFail();
        $rules = [
            'nama' => 'required|max:255',
            'hp' => 'required|min:10|max:13',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];
        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ];

        if ($request->email != $customer->user->email) {
            $rules['email'] = 'required|max:255|email|unique:customer';
        }
        if ($request->alamat != $customer->alamat) {
            $rules['alamat'] = 'required';
        }
        if ($request->pos != $customer->pos) {
            $rules['pos'] = 'required';
        }

        $validatedData = $request->validate($rules, $messages);

        if ($request->file('foto')) {
            if ($customer->user->foto) {
                $oldImagePath = public_path('storage/img-customer/') . $customer->user->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-customer/';
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);

            $validatedData['foto'] = $originalFileName;
        }

        $customer->user->update($validatedData);

        $customer->update([
            'alamat' => $request->input('alamat'),
            'pos' => $request->input('pos'),
        ]);

        return redirect()->route('customer.akun', $id)->with('success', 'Data berhasil diperbarui');
    }
}
