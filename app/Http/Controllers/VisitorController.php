<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Blacklist;
use App\Models\Rak;

class VisitorController extends Controller
{
    public function checkin()
    {
        $raks = Rak::where('status', 'aktif')->orderBy('nomor_rak')->get();

        return view('checkin', compact('raks'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'nama'       => 'required|string|min:3|max:100',
                'perusahaan' => 'required|string|max:150',
                'no_hp'      => 'required|string|min:10|max:15',
                'email'      => 'required|email',
                'tujuan'     => 'required|string',
                'nomor_rak'  => 'required|string|max:50',
                'foto'       => 'required|image|max:5120',
            ]);

            $noHpNormalized = $this->normalizePhone($request->no_hp);

            // === CEK BLACKLIST ===
            $blacklisted = Blacklist::where('no_hp', $noHpNormalized)
                ->orWhereRaw('LOWER(email) = ?', [strtolower($request->email)])
                ->first();

            if ($blacklisted) {
                return back()
                    ->withErrors(['blacklist' => 'Maaf, Anda tidak dapat melakukan check-in karena masuk daftar blacklist.'])
                    ->withInput();
            }
            // === SELESAI CEK BLACKLIST ===

            $path = $request->file('foto')->store('visitors', 'public');

            Visitor::create([
                'nama'          => $request->nama,
                'perusahaan'    => $request->perusahaan,
                'no_hp'         => $noHpNormalized,
                'email'         => $request->email,
                'tujuan'        => $request->tujuan,
                'nomor_rak'     => $request->nomor_rak,
                'foto'          => $path,
                'status'        => 'Masuk',
                'waktu_masuk'   => now(),
            ]);

            return redirect()->route('success');

        } catch (\Illuminate\Validation\ValidationException $e) {

            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {

            dd($e->getMessage());

        }
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function searchVisitor(Request $request)
    {
        $request->validate([
            'no_hp' => 'required|string',
        ]);

        $noHp = $this->normalizePhone((string) $request->no_hp);

        // Ambil data visitor terbaru berdasarkan nomor HP (tanpa filter status dulu)
        $visitor = Visitor::where('no_hp', $noHp)
            ->orderByDesc('waktu_masuk')
            ->first();

        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor HP tidak ditemukan dalam data visitor.',
            ], 404);
        }

        if ($visitor->status !== 'Masuk') {
            return response()->json([
                'success' => false,
                'message' => 'Visitor ini sudah melakukan checkout sebelumnya.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id'          => $visitor->id,
                'nama'        => $visitor->nama,
                'no_hp'       => $visitor->no_hp,
                'email'       => $visitor->email,
                'perusahaan'  => $visitor->perusahaan,
                'tujuan'      => $visitor->tujuan,
                'nomor_rak'   => $visitor->nomor_rak ?: '-',
                'foto'        => $visitor->foto
                    ? asset('storage/' . $visitor->foto)
                    : asset('assets/img/default-user.png'),
                'waktu_masuk' => $visitor->waktu_masuk
                    ? $visitor->waktu_masuk->format('d M Y - H:i') . ' WIB'
                    : '-',
            ],
        ]);
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:visitors,id',
        ]);

        $visitor = Visitor::where('id', $request->id)
                        ->where('status', 'Masuk')
                        ->first();

        if (!$visitor) {

            return response()->json([
                'success' => false,
                'message' => 'Visitor tidak ditemukan atau sudah checkout.',
            ], 404);
        }

        $visitor->update([

            'status' => 'Keluar',

            'waktu_keluar' => now()

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil.',
        ]);
    }

    /**
     * Menormalkan format nomor HP:
     * - Menghapus semua karakter non-digit (spasi, tanda -, +, dsb)
     * - Mengubah awalan 62 atau +62 menjadi 0
     *
     * Contoh:
     * "+62 897-485-849" -> "0897485849"
     * "62897485849"      -> "0897485849"
     * "0897485849"       -> "0897485849"
     */
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }
} 