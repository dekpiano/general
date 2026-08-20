<?php

namespace App\Libraries;

class RemoteUploadService
{
    /**
     * Upload a file to the remote server (https://skj.nsnpao.go.th/upload.php)
     * 
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file
     * @param string $remotePath เช่น 'general/Equipment/pickup', 'general/Equipment/return', 'general/Equipment/items'
     * @param string|null $prefix คำนำหน้าชื่อไฟล์
     * @return string|false ชื่อไฟล์ที่บันทึกสำเร็จ หรือ false หากเกิดข้อผิดพลาด
     */
    public static function upload($file, $remotePath = 'general/Equipment', $prefix = 'eq')
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            log_message('error', '[RemoteUpload] File invalid or already moved. Valid=' . ($file ? ($file->isValid() ? 'yes' : 'no') : 'null') . ' Moved=' . ($file ? ($file->hasMoved() ? 'yes' : 'no') : 'null'));
            return false;
        }

        $upload_server_url = getenv('upload.server.url') ?: 'https://skj.nsnpao.go.th/upload.php';
        $client = \Config\Services::curlrequest();

        $local_temp_path = $file->getTempName();
        $mimeType = $file->getMimeType();
        $originalName = $file->getName();

        log_message('debug', '[RemoteUpload] Starting upload: file=' . $originalName . ' tempPath=' . $local_temp_path . ' mime=' . $mimeType . ' remotePath=' . $remotePath);

        // ตรวจสอบว่า temp file มีอยู่จริง
        if (!file_exists($local_temp_path)) {
            log_message('error', '[RemoteUpload] Temp file not found: ' . $local_temp_path);
            return false;
        }

        try {
            $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
            $sanitizedName = preg_replace('/[^\w-]/', '_', $nameWithoutExt);
            $sanitizedName = trim(preg_replace('/_+/', '_', $sanitizedName), '_');
            $extension = $file->getClientExtension() ?: 'jpg';
            $finalName = $prefix . '_' . ($sanitizedName ?: 'file') . '_' . time() . '_' . uniqid() . '.' . $extension;

            log_message('debug', '[RemoteUpload] Sending to: ' . $upload_server_url . ' finalName=' . $finalName);

            $response = $client->request('POST', $upload_server_url, [
                'headers' => ['X-Auth-Token' => 'Dekpiano2025!!'],
                'multipart' => [
                    'file' => new \CURLFile($local_temp_path, $mimeType, $finalName),
                    'path' => $remotePath,
                    'desired_filename' => $finalName,
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody();
            log_message('debug', '[RemoteUpload] Response status=' . $statusCode . ' body=' . $responseBody);

            if ($statusCode === 200) {
                $body = json_decode($responseBody);
                if ($body && isset($body->status) && $body->status === 'success' && isset($body->filename)) {
                    log_message('info', '[RemoteUpload] SUCCESS: ' . $body->filename);
                    return $body->filename;
                }
                log_message('error', '[RemoteUpload] Server returned 200 but unexpected body: ' . $responseBody);
            } else {
                log_message('error', '[RemoteUpload] Server returned status ' . $statusCode . ': ' . $responseBody);
            }

            // Fallback: หาก Remote Server ไม่ตอบสนอง ให้เซฟลงใน Local Directory เพื่อความต่อเนื่องในการใช้งาน
            $localDir = FCPATH . 'uploads/' . str_replace('general/', '', $remotePath);
            if (!is_dir($localDir)) {
                mkdir($localDir, 0777, true);
            }
            $file->move($localDir, $finalName);
            log_message('info', '[RemoteUpload] Fallback saved locally: ' . $localDir . '/' . $finalName);
            return $finalName;

        } catch (\Exception $e) {
            log_message('error', '[RemoteUpload] Exception: ' . $e->getMessage());

            // Fallback to local
            try {
                $finalName = $prefix . '_' . time() . '_' . $file->getRandomName();
                $localDir = FCPATH . 'uploads/' . str_replace('general/', '', $remotePath);
                if (!is_dir($localDir)) {
                    mkdir($localDir, 0777, true);
                }
                $file->move($localDir, $finalName);
                log_message('info', '[RemoteUpload] Exception fallback saved locally: ' . $localDir . '/' . $finalName);
                return $finalName;
            } catch (\Exception $ex) {
                log_message('error', '[RemoteUpload] Local fallback also failed: ' . $ex->getMessage());
                return false;
            }
        }
    }

    /**
     * ลบไฟล์ออกจาก Remote Server และ Local Directory
     * 
     * @param string|array $filenames ชื่อไฟล์เดี่ยว หรือ Array หรือ String คั่นด้วยคอมมา
     * @param string $remotePath เช่น 'general/Equipment/pickup'
     * @return bool
     */
    public static function deleteFile($filenames, $remotePath = 'general/Equipment')
    {
        if (empty($filenames)) {
            return false;
        }

        if (is_string($filenames)) {
            $files = array_values(array_filter(array_map('trim', explode(',', $filenames))));
        } elseif (is_array($filenames)) {
            $files = array_values(array_filter($filenames));
        } else {
            return false;
        }

        if (empty($files)) {
            return false;
        }

        $deleteUrl = getenv('upload.server.delete.url') ?: 'https://skj.nsnpao.go.th/delete.php';
        $client = \Config\Services::curlrequest();

        // 1. ลบจาก Remote Server (ส่ง JSON payload: 'files' => array, 'path' => string)
        try {
            $response = $client->request('POST', $deleteUrl, [
                'headers' => [
                    'X-Auth-Token' => 'Dekpiano2025!!'
                ],
                'json' => [
                    'files' => $files,
                    'path'  => $remotePath,
                ],
                'http_errors' => false,
            ]);
            log_message('debug', '[RemoteUpload] Delete response for path ' . $remotePath . ': ' . $response->getStatusCode() . ' body: ' . $response->getBody());
        } catch (\Throwable $e) {
            log_message('error', '[RemoteUpload] Remote file delete failed: ' . $e->getMessage());
        }

        // 2. ลบจาก Local Directory (ถ้ามี)
        $localDir = FCPATH . 'uploads/' . str_replace('general/', '', $remotePath);
        foreach ($files as $file) {
            $localFile = rtrim($localDir, '/\\') . DIRECTORY_SEPARATOR . $file;
            if (file_exists($localFile)) {
                @unlink($localFile);
            }
        }

        return true;
    }

    /**
     * สแกนและลบไฟล์ขยะที่ไม่มีชื่ออยู่ในฐานข้อมูล (Orphan Files Cleanup)
     * 
     * @param array $validFilenames รายชื่อไฟล์ทั้งหมดที่ยังใช้อยู่ในฐานข้อมูล
     * @param string $remotePath เช่น 'general/Equipment/docs'
     * @return array ผลลัพธ์การลบ ['deleted_count' => int, 'deleted_files' => array]
     */
    public static function cleanupOrphanFiles(array $validFilenames, $remotePath = 'general/Equipment/docs')
    {
        $validMap = array_fill_keys(array_filter(array_map('trim', $validFilenames)), true);
        $deletedFiles = [];

        // 1. สแกนและลบจาก Local Uploads Directory
        $localDir = FCPATH . 'uploads/' . str_replace('general/', '', $remotePath);
        if (is_dir($localDir)) {
            $localFiles = scandir($localDir);
            foreach ($localFiles as $file) {
                if ($file === '.' || $file === '..' || $file === '.gitkeep' || $file === 'index.html') {
                    continue;
                }
                if (!isset($validMap[$file])) {
                    $filePath = rtrim($localDir, '/\\') . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                        if (@unlink($filePath)) {
                            $deletedFiles[] = $file;
                        }
                    }
                }
            }
        }

        // 2. ส่งคำขอลบไปยัง Remote Server สำหรับไฟล์ขยะที่ตรวจพบ
        if (!empty($deletedFiles)) {
            self::deleteFile($deletedFiles, $remotePath);
        }

        return [
            'deleted_count' => count($deletedFiles),
            'deleted_files' => $deletedFiles
        ];
    }

    /**
     * Helper URL สำหรับแสดงรูปภาพหรือไฟล์
     */
    public static function getUrl($filename, $subPath = 'Equipment')
    {
        if (empty($filename)) {
            return '';
        }
        if (strpos($filename, 'http://') === 0 || strpos($filename, 'https://') === 0) {
            return $filename;
        }

        // URL จาก Remote Server
        $remoteBase = "https://skj.nsnpao.go.th/uploads/general/" . trim($subPath, '/') . "/";
        return $remoteBase . $filename;
    }
}
