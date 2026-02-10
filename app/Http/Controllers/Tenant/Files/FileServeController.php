<?php

namespace App\Http\Controllers\Tenant\Files;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileServeController extends Controller
{
    public function show(Request $request, File $file)
    {
        // Seguridad: Verificar firma
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        // Usamos el disco configurado
        $diskName = config('holdingtec.uploads.disk', 'public');
        $disk = Storage::disk($diskName);

        // ---------------------------------------------------------
        // ESTRATEGIA A: S3
        // ---------------------------------------------------------
        // Si el driver es S3, delegamos la descarga a Amazon.
        $config = config("filesystems.disks.{$diskName}");

        if (($config['driver'] ?? '') === 's3') {
            return redirect($disk->temporaryUrl(
                $file->path,
                now()->addMinutes(5),
                ['ResponseContentDisposition' => 'inline; filename="'.$file->name.'"']
            ));
        }

        // ---------------------------------------------------------
        // ESTRATEGIA B: BASE
        // ---------------------------------------------------------
        // En local, simplemente verificamos que exista y lo servimos.

        if (! $disk->exists($file->path)) {
            abort(404);
        }

        // Servir el archivo
        return $disk->response($file->path, $file->name, [
            'Content-Type' => $file->mime_type,
            'Content-Disposition' => 'inline; filename="'.$file->name.'"',
        ]);
    }
}
