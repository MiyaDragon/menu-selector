<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MenuImage extends Model
{
    use HasFactory;

    // S3キー(ファイルパス)から、期限付きURLを取得する
    public function GetPresignedURL()
    {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $command = $client->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $this->path,
        ]);
        $request = $client->createPresignedRequest($command, "+10 minutes");
        return  (string) $request->getUri();
    }
}
