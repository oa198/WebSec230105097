<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CryptoController extends Controller
{
    public function show()
    {
        return view('ecnAndDec.index');
    }

    public function encrypt(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'password' => 'required|string',
        ]);

        $file = $request->file('file');
        $password = $request->password;
        $content = file_get_contents($file->getRealPath());

        $encrypted = openssl_encrypt($content, 'AES-256-CBC', $password, 0, substr(hash('sha256', $password), 0, 16));

        $filename = 'encrypted_' . time() . '.enc';
        Storage::put("public/$filename", $encrypted);

        return response()->download(storage_path("app/public/$filename"))->deleteFileAfterSend();
    }

    public function decrypt(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'password' => 'required|string',
        ]);

        $file = $request->file('file');
        $password = $request->password;
        $content = file_get_contents($file->getRealPath());

        $decrypted = openssl_decrypt($content, 'AES-256-CBC', $password, 0, substr(hash('sha256', $password), 0, 16));

        $filename = 'decrypted_' . time() . '.txt';
        Storage::put("public/$filename", $decrypted);

        return response()->download(storage_path("app/public/$filename"))->deleteFileAfterSend();
    }
}
