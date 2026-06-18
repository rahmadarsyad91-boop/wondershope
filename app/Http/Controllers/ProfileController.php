<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Menampilkan riwayat pesanan milik member yang sedang login
     */
    public function riwayatPesanan()
    {
        $user = auth()->user();

        // Mengambil pesanan berdasarkan nama penerima yang sesuai dengan nama user
        $pesananSaya = \App\Models\Order::with('items')
            ->where('nama_penerima', $user->name)
            ->latest()
            ->get();

        // Statistik ringkasan untuk member
        $stats = [
            'total'    => $pesananSaya->count(),
            'diproses' => $pesananSaya->where('status', 'diproses')->count(),
            'dikirim'  => $pesananSaya->where('status', 'dikirim')->count(),
            'selesai'  => $pesananSaya->where('status', 'selesai')->count(),
            'batal'    => $pesananSaya->where('status', 'batal')->count(),
            'retur'    => $pesananSaya->where('status', 'retur')->count(),
            'omset'    => $pesananSaya->where('status', 'selesai')->sum('total_harga'),
        ];

        return view('profile.riwayat_pesanan', compact('pesananSaya', 'stats'));
    }

    /**
     * Konfirmasi dari member bahwa paket sudah sampai (Ubah status jadi Selesai)
     */
    public function konfirmasiDiterima($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        if ($order->status == 'dikirim') {
            $order->status = 'selesai';
            $order->save();
            return redirect()->back()->with('success', 'Terima kasih! Pesanan telah selesai.');
        }

        return redirect()->back()->with('error', 'Tindakan tidak valid.');
    }

    /**
     * Menampilkan detail invoice pesanan
     */
    public function showPesanan($id)
    {
        $user = auth()->user();
        $order = \App\Models\Order::with('items')
            ->where('id', $id)
            ->where(function($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('nama_penerima', $user->name);
            })
            ->firstOrFail();

        return view('profile.show_pesanan', compact('order'));
    }
}
