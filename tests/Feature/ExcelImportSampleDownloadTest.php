<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExcelImportSampleDownloadTest extends TestCase
{
    public function test_admin_can_download_sample_import_file(): void
    {
        $response = $this->get('/admin/products/import/sample');

        $response->assertStatus(200);
        $response->assertDownload('mau-import-san-pham.csv');
        $response->assertHeader('Content-Type', 'text/csv; charset=utf-8');
        $this->assertStringStartsWith("\xEF\xBB\xBF", $response->getContent());
    }
}
