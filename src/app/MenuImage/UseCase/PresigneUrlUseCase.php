<?php

namespace App\MenuImage\UseCase;

use Illuminate\Support\Facades\Storage;

final class PresigneUrlUseCase
{
    /**
     * S3キー(ファイルパス)から、期限付きURLを取得する
     * @param string $path
     * @return string
     */
    public function get(string $path): string
    {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $command = $client->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $path,
        ]);

        $request = $client->createPresignedRequest($command, "+10 minutes");

        return  (string) $request->getUri();
    }
}
